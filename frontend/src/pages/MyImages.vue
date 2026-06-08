<script setup>
import { RouterView } from 'vue-router'

const imgs = [
  {
  id: 1,
  name: 'Tom Cook',
  imageAlt: 'Tom Cook',
  href: '#',
  imageSrc: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
  {
  id: 2,
  name: 'James Russell',
  imageAlt: 'James Russell',
  href: '#',
  imageSrc: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
]
</script>

<template>
  <header class="relative bg-white shadow-sm">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">My Images</h1>
      </div>
  </header>
    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="img in imgs" :key="img.id" class="group relative">
          <img :src="img.imageSrc" :alt="img.imageAlt" class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
          <div class="mt-4 flex justify-between">
            <div>
              <h3 class="text-sm text-gray-700">
                <a :href="img.href">
                  <span aria-hidden="true" class="absolute inset-0"></span>
                  {{ img.name }}
                </a>
              </h3>
              
            </div>
            
          </div>
        </div>
      </div>
        
      </div>
    </main>
</template>
<style scoped>
</style>