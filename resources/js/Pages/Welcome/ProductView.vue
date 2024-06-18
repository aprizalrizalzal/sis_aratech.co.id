<script setup>
import { ref, computed, watch } from 'vue';
import CardView from '@/Components/CardView.vue';
import SearchInput from '@/Components/SearchInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    spareParts: Array,
});

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 6;

const filteredSpareParts = computed(() => {
    if (!searchQuery.value) {
        return props.spareParts;
    }
    return props.spareParts.filter(sparePart =>
        sparePart.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        sparePart.price.toString().toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const paginatedSpareParts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredSpareParts.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredSpareParts.value.length / itemsPerPage);
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

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

watch(searchQuery, () => {
    currentPage.value = 1;
});
</script>

<template>
    <div class="flex justify-between items-center pt-4 pb-2">
        <div class="flex items-center">
            <h2 class="flex font-semibold text-lg text-green-900 leading-tight flex-none px-2 py-4">
                <span class="hidden lg:block">ASLI Mandiri Computer-</span>
                <span>AMITech</span>
            </h2>
        </div>
        <div class="flex items-center">
            <SearchInput v-model:searchQuery="searchQuery" />
        </div>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 my-2 text-sm font-bold text-green-900">
        <CardView v-for="sparePart in paginatedSpareParts" :key="sparePart.id" :name="sparePart.name"
            :price="formatCurrency(sparePart.price)">
            <template #img>
                <img :src="sparePart.image_path" :alt="sparePart.name">
            </template>
        </CardView>
    </div>
    <div class="flex justify-center gap-4 items-center p-6">
        <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
    </div>
</template>
