<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import DarkModeRoot from '@/Components/DarkModeRoot.vue';
import ModifyBalance from './Partials/ModifyBalance.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-primarytext leading-tight">Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-bg shadow shadow-primarytext/20 hover:shadow-primarytext/30 sm:rounded-lg">
                    <DarkModeRoot />
                </div>
                <div class="bg-bg p-4 sm:p-8 bg-bg shadow shadow-primarytext/20 hover:shadow-primarytext/30 sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="bg-bg p-4 sm:p-8 shadow shadow-primarytext/20 hover:shadow-primarytext/30 sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="bg-bg p-4 sm:p-8 shadow shadow-primarytext/20 hover:shadow-primarytext/30 sm:rounded-lg">
                    <ModifyBalance class="max-w-xl" />
                </div>

                <div class="bg-bg p-4 sm:p-8 shadow shadow-primarytext/20 hover:shadow-primarytext/30 sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>