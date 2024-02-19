<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-primarytext leading-tight">Crypto Trading Platform</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-bg overflow-hidden shadow-sm shadow-primarytext/20 sm:rounded-lg">
                    <div class="p-6 text-primarytext">You're logged in!</div>
                    
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
