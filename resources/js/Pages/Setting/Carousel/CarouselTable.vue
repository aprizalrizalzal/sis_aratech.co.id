<script setup>
import CarouselForm from '@/Pages/Setting/Carousel/CarouselForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import ButtonImage from '@/Components/ButtonImage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EditIcon from '@/Components/Icon/EditIcon.vue';

const props = defineProps({
    carousels: Array,
});

const showingModelCarouselUpdateImage = ref(false);
const showingModelCarouselUpdate = ref(false);
const selectedCarouselId = ref(null);
const selectedCarousel = ref(null);

const showModalCarouselUpdateImage = (carouselId) => {
    selectedCarouselId.value = carouselId;
    showingModelCarouselUpdateImage.value = true;
};

const showModalCarouselUpdate = (carousel) => {
    selectedCarousel.value = carousel;
    showingModelCarouselUpdate.value = true;
};

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
    showingModelCarouselUpdate.value = false;
    showingModelCarouselUpdateImage.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 5;

const paginatedCarousels = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.carousels.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.carousels.length / itemsPerPage);
});

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};
</script>

<template>
    <div class=" overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Image</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Alternative</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(carousel, index) in paginatedCarousels" :key="carousel.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300">
                        <div class="flex justify-center items-center m-2">
                            <img :src="`${carousel.image_path}`" :alt="carousel.alt"
                                class="h-16 object-cover rounded-md mx-2" />
                            <ButtonImage @click="showModalCarouselUpdateImage(carousel.id)">
                                <EditIcon />
                            </ButtonImage>
                        </div>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ carousel.alt }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalCarouselUpdate(carousel)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmCarouselDeletion(carousel.id)" class="m-2">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-center gap-4 items-center p-6">
        <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
    </div>

    <Modal :show="showingModelCarouselUpdateImage">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Carousel Image</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <CarouselForm :carouselId="selectedCarouselId" />
        </div>
    </Modal>

    <Modal :show="showingModelCarouselUpdate">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Carousel</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <CarouselForm :carousel="selectedCarousel" />
        </div>
    </Modal>

    <Modal :show="confirmingCarouselDeletion">
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
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
