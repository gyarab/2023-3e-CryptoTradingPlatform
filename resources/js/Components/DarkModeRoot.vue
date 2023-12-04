<script setup>
import { ref } from 'vue'

const count = ref("light")

function change(theme) {
    document.documentElement.setAttribute('data-theme', theme)
}

const themes = ["light", "dark", "gemstone", "modern", "pro"];
</script>

<template>
    <h2 class="text-lg font-medium text-primarytext">Themes</h2>
    <div id="theme-switcher" v-for="theme in themes">
        <input :id="theme" @click="change(theme)" :value="theme" type="radio" name="style-options">
        <label :for="theme" v-html="theme" class="text-primarytext"></label>
    </div>
</template>

