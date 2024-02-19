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
    cryptocurrencies: {
        type: Array
    }
});
</script>

<template>
    <Head title="Welcome" />

    <header class="text-primarytext sticky flex  justify-between border-b border-border p-2 left-0 right-0 top-0 bg-bg"><!--Header-->
        <div>
            <ApplicationLogo class="w-12 h-12" />
        </div>
        <div>
            <span>Crypto Trading Platform</span>
        </div>
        <div v-if="canLogin" class="">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            Dashboard</Link>

            <template v-else>
                <Link :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Log in</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Register</Link>
            </template>
        </div>
    </header>
    <div class="pt-12 pr-12 pl-12 h-full text-primarytext bg-bg"> <!--wrapper-->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4"><!--Content-->

            <div>
                <h1 class="lg:text-6xl sm:text-5xl">Welcome to Trade Crypto</h1> <br>
                <p class="text-4xl">Learn how to trade!!!</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam fuga quod rerum illo alias voluptates,
                    reiciendis ab earum illum incidunt, repellendus, dignissimos esse tenetur rem distinctio dolore quisquam
                    sapiente vitae quae? Molestias sit quos, unde nulla quo nemo quam odit earum eaque odio fuga explicabo,
                    ducimus officiis rem, reprehenderit reiciendis!</p>
            </div>

            <div class="justify-center overflow-x-auto shadow-md rounded-lg">
                <div>
                    <table
                        class="table-fixed overflow-scroll w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Cryptocurrency
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Shortcut
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price in USD
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                v-for="currency in cryptocurrencies">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ currency["name"] }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ currency["symbol"] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ currency["priceUsd"] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</template>

