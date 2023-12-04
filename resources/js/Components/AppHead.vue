<script setup>
import { Head } from '@inertiajs/vue3'

defineProps({ title: String })
</script>


<template>
    <div class="">
        <Head :title="title ? `${title} - My App` : 'My App'">
            
        </Head>
    </div>
</template>
