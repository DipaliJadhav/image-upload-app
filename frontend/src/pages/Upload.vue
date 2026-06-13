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
const imagePreview = ref(null)

const toast = ref({
    show: false,
    message: '',
    type: ''
})

const showToast = (message, type = 'success') => {

    toast.value = {
        show: true,
        message,
        type
    }

    setTimeout(() => {
        toast.value.show = false
    }, 1500)
}

const handleFileUpload = (event) => {

    image.value = event.target.files[0]

    if (image.value) {
        imagePreview.value = URL.createObjectURL(image.value)
    }
}
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
        showToast(response.data.message,'success')
        label.value = ''
        image.value = null
        imagePreview.value = null
        setTimeout(() => {
            router.push({ name: 'Home' })
        }, 3000)

    } catch (error) {

        console.error(error)
        showToast('Failed to upload image', 'error')

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

          <div v-if="imagePreview" class="mt-4">

              <img
                  :src="imagePreview"
                  alt="Preview"
                  class="w-64 h-64 object-cover rounded border"
              >

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
      
      <div
          v-if="toast.show"
          class="fixed top-5 right-5 px-4 py-3 rounded shadow-lg text-white z-50"
          :class="toast.type === 'success'
              ? 'bg-green-500'
              : 'bg-red-500'"
      >
          {{ toast.message }}
      </div>
    </main>
  
</template>
<style scoped>
</style>