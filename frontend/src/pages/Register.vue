<script setup>
import { RouterView } from 'vue-router'
import router from '../router.js';
import GuestLayout from '../components/GuestLayout.vue'
import {ref} from 'vue'
//import axios from 'axios'
import axiosClient from '../axios.js'


// const router = useRouter()
const message = ref('')
const form = ref({
  fname: '',
  email: '',
  password: '',
  confirmedpassword: ''
})

const submitForm = async () => {

    try {
        const response = await axiosClient.post('/api/register', form.value);
        message.value = response.data.message
        setTimeout(() => {
            router.push({ name: 'Login' })
        }, 1500)
    } catch(error) {

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
      <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray">Create an account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form @submit.prevent="submitForm" class="space-y-6">
        <div>
          <label for="fname" class="block text-sm/6 font-medium text-gray-900">First name</label>
          <div class="mt-2">
            <input type="text" v-model="form.fname" name="fname" id="fname" required="" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-gray outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
          </div>
        </div>
        <div>
          <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
          <div class="mt-2">
            <input type="email" v-model="form.email" name="email" id="email" required="" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-gray outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
          </div>
        </div>
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
          </div>
          <div class="mt-2">
            <input type="password" v-model="form.password" name="password" id="password" autocomplete="current-password" required="" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-gray outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="confirmedpassword" class="block text-sm/6 font-medium text-gray-900">Confirm Password</label>
          </div>
          <div class="mt-2">
            <input type="password" v-model="form.confirmedpassword" name="confirmedpassword" id="confirmedpassword" required="" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-gray outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
          </div>
        </div>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Create account</button>
        </div>
      </form>
      <p>{{ message  }}</p>
      <p class="mt-10 text-center text-sm/6 text-gray-400">
        Already have an account?
        {{ ' ' }}
        <RouterLink to="/login" class="font-semibold text-indigo-400 hover:text-indigo-300">Sign in</RouterLink>
      </p>
    </div>
  </GuestLayout>
</template>
<style scoped>
</style>