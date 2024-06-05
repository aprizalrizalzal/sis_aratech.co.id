<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CarouselTable from '@/Pages/Carousel/CarouselTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    carousels: {
        type: Array,
        required: true
    }
});
const searchQuery = ref('');

const filteredCarousels = computed(() => {
    if (!searchQuery.value) {
        return props.carousels;
    }
    return props.carousels.filter(carousel =>
        carousel.img.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        carousel.alt.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        carousel.phone.includes(searchQuery.value)
    );
});
</script>

<template>

    <Head title="Carousels" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <h2 class="font-semibold text-xl text-green-800 leading-tight flex-none">Carousels</h2>
                </div>
                <div class="flex items-center">
                    <SearchInput v-model:searchQuery="searchQuery" />
                </div>
            </div>
        </template>
        <div class="flex">
            <!-- Main Content -->
            <div class="py-6 flex-1 transition-all duration-300">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <!-- Your main content here -->
                        <CarouselTable :carousels="filteredCarousels" />
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
