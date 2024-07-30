<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>

        <Head title="Email Verification" />

        <div class="mb-4 text-sm text-green-700">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
            we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        <div class="mb-4 font-medium text-sm text-green-700" v-if="verificationLinkSent">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <p v-else class="text-sm text-red-900 my-2">Failed to send email, please try again later.</p>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Resend Verification Email
                </PrimaryButton>

                <Link :href="route('logout')" method="post" as="button"
                    class="underline text-sm text-green-700 hover:text-green-700 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-700">
                Log Out</Link>
            </div>
        </form>
    </GuestLayout>
</template>
