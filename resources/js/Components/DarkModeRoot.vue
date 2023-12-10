<script setup>
import { ref } from 'vue'

const count = ref("light")

function change(theme) {
    document.documentElement.setAttribute('data-theme', theme)
}

const themes = ["Light", "Dark", "Modern", "Pro"];
</script>

<template>
    <h2 class="text-lg font-medium text-primarytext">Themes</h2>
    <div id="theme-switcher" v-for="theme in themes" class="mb-1">
        <input :id="theme" @click="change(theme)" :value="theme" type="radio" name="style-options" class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-gray-900 checked:bg-gray-900 checked:before:bg-gray-900 hover:before:opacity-0">
        <label :for="theme" v-html="theme" class="text-primarytext ml-2"></label>
    </div>
</template>

