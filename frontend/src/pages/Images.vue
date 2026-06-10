<script setup>
import { RouterView } from 'vue-router'
import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid'
import { ChevronDownIcon } from '@heroicons/vue/16/solid'
import router from '../router.js';
import { ref } from 'vue'
import axiosClient from '../axios.js'

const label = ref('')
const image = ref(null)
const message = ref('')

const handleFileUpload = (event) => {
  const file = event.target.files[0]; 
  image.value = file;
};
const uploadImage = async () => {

    try {

        const token = localStorage.getItem('token')

        const formData = new FormData()

        formData.append('label', label.value)
        formData.append('image', image.value)

        const response = await axiosClient.post(
            '/api/images',
            formData,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                    'Content-Type': 'multipart/form-data'
                }
            }
        )

        message.value = response.data.message
       
        label.value = ''
        image.value = null
        setTimeout(() => {
            router.push({ name: 'Home' })
        }, 1500)

    } catch (error) {

        console.error(error)

        if (error.response) {
            message.value = error.response.data.message
        }
        
    }
}

</script>

<template>
  <header class="relative bg-white shadow-sm">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Upload Image</h1>
      </div>
  </header>
    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <p>{{ message }} ffff</p>
        <div class="mb-4">
            <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Cover photo</label>
            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
              <div class="text-center">
                <PhotoIcon class="mx-auto size-12 text-gray-300" aria-hidden="true" />
                <div class="mt-4 flex text-sm/6 text-gray-600">
                  <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-indigo-600 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-indigo-600 hover:text-indigo-500">
                    <span>Upload a file</span>
                    <input id="file-upload" @change="handleFileUpload" name="image" type="file" class="sr-only" />
                  </label>
                  <p class="pl-1">or drag and drop</p>
                </div>
                <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label for="label" class="block text-sm/6 font-medium text-gray-900">Image Label</label>
            <div class="mt-2">
              <input type="text" v-model="label" name="label" id="label" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
            </div>
          </div>
          <div class="mt-6 flex items-center gap-x-6">      
            <button type="submit" @click="uploadImage" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Upload</button>
          </div>
      </div>
      
    </main>
  
</template>
<style scoped>
</style>