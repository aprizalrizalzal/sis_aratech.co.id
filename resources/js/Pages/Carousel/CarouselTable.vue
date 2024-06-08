<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const props = defineProps({
    carousels: {
        type: Array,
        required: true
    }
});

const confirmingCarouselDeletion = ref(false);
const form = useForm({
    id: null,
});

const confirmCarouselDeletion = (carouselId) => {
    confirmingCarouselDeletion.value = true;
    form.id = carouselId;
};

const deleteCarousel = () => {
    form.delete(route('destroy.carousel', { carousel: form.id }), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: (errors) => {
            if (errors) {
                closeModal();
            } else {
                const errorMessages = Object.values(errors).flat();
                alert(`${errorMessages}`);
            }
        }
    });
};

const closeModal = () => {
    confirmingCarouselDeletion.value = false;
};
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">#</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Image</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Alternative</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(carousel, index) in carousels" :key="carousel.id" class="hover:bg-green-100">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <img :src="`${carousel.image_path}`" :alt="carousel.alt"
                            class="w-24 h-24 object-cover rounded-md mx-auto" />
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ carousel.alt }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmCarouselDeletion(carousel.id)" class="m-2">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <Modal :show="confirmingCarouselDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-green-900">
                    Are you sure you want to delete this carousel?
                </h2>

                <p class="mt-1 text-sm text-green-600">
                    Once your carousel is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteCarousel">
                        Delete Carousel
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
