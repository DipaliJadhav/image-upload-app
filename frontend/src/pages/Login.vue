<script setup>
import { RouterView } from 'vue-router'
import GuestLayout from '../components/GuestLayout.vue'
import { ref } from 'vue'
import router from '../router.js'
//import axios from 'axios'
import axiosClient from '../axios.js'

const message = ref('')
const form = ref({
  email: '',
  password: ''
})

const loginForm = async () => {
  try {
    const response = await axiosClient.post('/api/login', form.value)
     localStorage.setItem(
            'token',
            response.data.token
        )

        localStorage.setItem(
            'user',
            JSON.stringify(response.data.user)
        )

        message.value = response.data.message

        router.push({ name: 'Home' })
  } catch (error) {
    if (error.response) {
            message.value = error.response.data.message
        }

        console.error(error)
   }
}

</script>

<template>
  <GuestLayout>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray">Sign in to your account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form @submit.prevent="loginForm" class="space-y-6">
        <div>
          <label for="email" class="block text-sm/6 font-medium text-white-100">Email address</label>
          <div class="mt-2">
            <input type="email" v-model="form.email" name="email" id="email" autocomplete="email" required="" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-gray outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-white-100">Password</label>
            
          </div>
          <div class="mt-2">
            <input type="password" v-model="form.password" name="password" id="password" autocomplete="current-password" required="" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-gray outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
          </div>
        </div>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign in</button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm/6 text-gray-900">
        Not a member?
        {{ ' ' }}
        <RouterLink to="/register" class="font-semibold text-indigo-400 hover:text-indigo-500">Create an account</RouterLink>
      </p>
    </div>
  </GuestLayout>
</template>
<style scoped>
</style>