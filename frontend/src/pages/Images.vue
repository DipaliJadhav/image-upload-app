<script setup>
import { RouterView } from 'vue-router'
import { ref, onMounted } from 'vue'
import axiosClient, { API_URL }  from '../axios.js'

const images = ref([])
const loading = ref(false)
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
const getImages = async () => {

    try {

        const token = localStorage.getItem('token')
        loading.value = true

        const response = await axiosClient.get(
            '/api/images',
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }
        )

        images.value = response.data

    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    getImages()
})

const showDeleteModal = ref(false)
const selectedImage = ref(null)

const openDeleteModal = (image) => {
    selectedImage.value = image
    showDeleteModal.value = true
}

const closeDeleteModal = () => {
    selectedImage.value = null
    showDeleteModal.value = false
}

const deleteImage = async () => {

    try {

        const token = localStorage.getItem('token')
        const response = await axiosClient.delete(`/api/images/${selectedImage.value.id}`,
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }
        )
        showToast(response.data.message,'success')   
        images.value = images.value.filter(
        image => image.id !== selectedImage.value.id
        )

        closeDeleteModal()

    } catch (error) {

        console.error(error)

    } 
}


</script>

<template>
  <header class="relative bg-white shadow-sm">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">My Images</h1>
      </div>
  </header>
    <main>
     <div v-if="loading">
            <<div class="mx-auto w-full max-w-sm rounded-md border border-blue-300 p-4">
                <div class="flex animate-pulse space-x-4">
                    <div class="size-10 rounded-full bg-gray-200"></div>
                    <div class="flex-1 space-y-6 py-1">
                    <div class="h-2 rounded bg-gray-200"></div>
                    <div class="space-y-3">
                        <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2 h-2 rounded bg-gray-200"></div>
                        <div class="col-span-1 h-2 rounded bg-gray-200"></div>
                        </div>
                        <div class="h-2 rounded bg-gray-200"></div>
                    </div>
                    </div>
                </div>
                </div>
        </div>   

    <div class="grid grid-cols-4 gap-4">
      <div
        v-for="image in images"
        :key="image.id"
        class="p-4 rounded mb-4 text-center">
          <h3 class="text-center">{{ image.label }}</h3>

          <img
              :src="`${API_URL}/storage/${image.image_path}`"
              class="mx-auto w-70 h-70 object-cover"
          >

          <button
              @click="openDeleteModal(image)"
              class="mt-2 bg-red-500 text-white px-4 py-2 rounded"
          >
              Delete
          </button>
      </div>
        
      
    </div>

    <div
        v-if="showDeleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">

            <h2 class="text-xl font-semibold mb-4">
                Delete Image
            </h2>

            <p class="mb-6">
                Are you sure you want to delete
                <strong>{{ selectedImage?.label }}</strong>?
            </p>

            <div class="flex justify-end gap-2">

                <button
                    @click="closeDeleteModal"
                    class="px-4 py-2 border rounded"
                >
                    Cancel
                </button>

                <button
                    @click="deleteImage"
                    :disabled="isDeleting"
                    class="px-4 py-2 bg-red-600 text-white rounded"
                >
                    {{ isDeleting ? 'Deleting...' : 'Delete' }}
                </button>

            </div>

        </div>
      </div>
        <div
            v-if="toast.show"
            class="fixed top-5 right-5 px-4 py-3 rounded shadow-lg text-white z-50"
            :class="toast.type === 'success'
                ? 'bg-green-500'
                : 'bg-red-500'" >
            {{ toast.message }}
        </div>
    </main>
</template>
<style scoped>
</style>