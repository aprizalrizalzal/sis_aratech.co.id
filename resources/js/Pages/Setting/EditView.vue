<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CardButton from '@/Components/CardButton.vue';
import ImagesIcon from '@/Components/Icon/ImagesIcon.vue';
import Modal from '@/Components/Modal.vue';
import CarouselForm from '@/Pages/Setting/Carousel/CarouselForm.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    
});

const showModalAddCarousel = ref(false);

</script>

<template>

    <Head title="Setting" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                    <CardButton @click="showModalAddCarousel = true" title="Add Carousel"
                        description="Membuat karousel baru untuk item unggulan atau promosi."
                        :tags="['karousel', 'promosi', 'unggulan']">
                        <template #svg>
                            <ImagesIcon width="32" height="32" fill="#0f4d0f" />
                        </template>
                    </CardButton>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">

                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                    
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                    
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
