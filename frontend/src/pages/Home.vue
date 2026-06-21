<script setup>
import { RouterView } from 'vue-router'
import { ref, onMounted } from 'vue'
import axiosClient, { API_URL }  from '../axios.js'

const images = ref([])
const loading = ref(false)
const pagination = ref({})
const getImages = async (page = 1) => {
    try {
        const token = localStorage.getItem('token')
        loading.value = true

        const response = await axiosClient.get(`/api/feed?page=${page}`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })

        images.value = response.data.data
        pagination.value = response.data.meta
    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}
const getPageNumber = (url) => {
    if (!url) return

    const params = new URL(url).searchParams

    return params.get('page')
}
onMounted(() => {
    getImages()
})


</script>

<template>
  <header class="relative bg-white shadow-sm">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Feed</h1>
      </div>
  </header>
    <main>
        <div v-if="loading">
            <div class="mx-auto w-full max-w-sm rounded-md border border-blue-300 p-4">
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
    <div class="grid grid-cols-4 gap-2">
      <div
        v-for="image in images"
        :key="image.id"
        class="p-4 rounded mb-4">
          <h3 class="text-center">{{ image.label }}</h3>

          <img
              :src="image.image_path"
              class="mx-auto w-70 h-70 object-cover"
          >

        </div>
        
      
    </div>

    <div class="flex justify-center gap-2 mt-6">
        <button
            v-for="link in pagination.links"
            :key="link.label"
            :disabled="!link.url"
            @click="getImages(getPageNumber(link.url))"
            class="px-3 py-2 border rounded"
            :class="{
                'font-bold': link.active,
                'opacity-50': !link.url
            }"
            v-html="link.label"
        />
    </div>
        
    </main>
</template>
<style scoped>
</style>