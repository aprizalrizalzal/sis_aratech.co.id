<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CardButton from '@/Components/CardButton.vue';
import ImagesIcon from '@/Components/Icon/ImagesIcon.vue';
import Modal from '@/Components/Modal.vue';
import CarouselForm from '@/Pages/Setting/Carousel/CarouselForm.vue';
import DangerButton from '@/Components/DangerButton.vue';
import CarouselTable from './Carousel/CarouselTable.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    carousels: Array
});

const showModalAddCarousel = ref(false);

</script>

<template>

    <Head title="Setting" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                    <h2 class="font-bold">Setting Header</h2>
                    <div class="flex flex-col my-2 items-end">
                        <PrimaryButton @click="showModalAddCarousel = true" class="">Add Carousel
                        </PrimaryButton>
                    </div>
                    <CarouselTable :carousels="props.carousels" />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                    <h2 class="font-bold">Setting Carousel</h2>
                    <div class="flex flex-col my-2 items-end">
                        <PrimaryButton @click="showModalAddCarousel = true" class="">Add Carousel
                        </PrimaryButton>
                    </div>
                    <CarouselTable :carousels="props.carousels" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                    <h2 class="font-bold">Setting Footer</h2>
                    <div class="flex flex-col my-2 items-end">
                        <PrimaryButton @click="showModalAddCarousel = true" class="">Add Carousel
                        </PrimaryButton>
                    </div>
                    <CarouselTable :carousels="props.carousels" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal v-model:show="showModalAddCarousel">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddCarousel = false">X</DangerButton>
      </div>
      <CarouselForm />
    </div>
  </Modal>
</template>
