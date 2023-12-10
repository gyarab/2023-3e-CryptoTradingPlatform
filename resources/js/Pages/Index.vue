<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { VueElement } from 'vue';
import DarkModeRoot from '@/Components/DarkModeRoot.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';
import DangerButton from '@/Components/DangerButton.vue';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div class="fixed top-0 left-0 right-0 bottom-0 text-primarytext bg-bg"> <!--wrapper-->
        
        <div class="sticky flex  justify-between border-b border-border p-2 left-0 right-0 top-0 bg-bg"><!--Header-->
            <div>
                <ApplicationLogo class="w-12 h-12"/>
            </div>
            <div>
                <span>Crypto Trading Platform</span>
            </div>
            <div v-if="canLogin" class="">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Dashboard</Link
                >

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >Log in</Link
                    >

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >Register</Link
                    >
                </template>
            </div>
        </div>
        <div class="mt-10"><!--Content-->
            <h1 class="lg:text-6xl sm:text-5xl">Welcome to Trade Crypto</h1> <br>
            <p class="text-4xl">Learn how to trade!!!</p>
        </div>
    </div>
</template>

