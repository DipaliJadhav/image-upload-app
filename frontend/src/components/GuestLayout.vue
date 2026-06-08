<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-gray-900">
    <body class="h-full">
    ```
  -->
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <slot></slot>
  </div>
</template>
<style scoped>
</style>
