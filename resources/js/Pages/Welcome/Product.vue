<script setup>
import { ref, computed, watch } from 'vue';
import CardView from '@/Components/CardView.vue';
import SearchInput from '@/Components/SearchInput.vue';
import SparePartDetail from '../SparePart/SparePartDetail.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import ButtonImage from '@/Components/ButtonImage.vue';
import BackIcon from '@/Components/Icon/BackIcon.vue';
import NextIcon from '@/Components/Icon/NextIcon.vue';

const props = defineProps({
    spareParts: Array,
    categorySpareParts: Array
});

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(12);

const filteredSpareParts = computed(() => {
    if (!searchQuery.value) {
        return props.spareParts;
    }
    return props.spareParts.filter(sparePart =>
        sparePart.category_spare_part.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        sparePart.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        sparePart.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const paginatedSpareParts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return filteredSpareParts.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredSpareParts.value.length / itemsPerPage.value);
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

const showingModalSparePartDetail = ref(false);
const selectedSparePart = ref(null);

const showModalSparePartDetail = (sparePart) => {
    selectedSparePart.value = sparePart;
    showingModalSparePartDetail.value = true;
};

const closeModal = () => {
    showingModalSparePartDetail.value = false;
};
</script>

<template>
    <div class="flex justify-between items-center pt-4 pb-2 gap-4">
        <div class="flex items-center">
            <h2 class="flex items-center gap-2 font-semibold text-green-900 leading-tight flex-none py-4">
                <span>Spare Part</span>
            </h2>
        </div>
        <div class="flex w-full items-center">
            <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for the part name, category or description" />
        </div>

        
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 my-2 text-sm font-bold text-green-900">
        <div v-for="sparePart in paginatedSpareParts" :key="sparePart.id">
            <CardView @click="showModalSparePartDetail(sparePart)" :category="sparePart.category_spare_part.name" :name="sparePart.name"
                :price="formatCurrency(sparePart.price)">
                <template #img>
                    <img :src="sparePart.image_path" :alt="sparePart.name" class="h-32 sm:h-48 w-full object-cover shadow" />
                </template>
            </CardView>
        </div>
    </div>
    <div class="flex justify-center gap-4 items-center p-6">
        <ButtonImage class="py-2 border-none shadow-none" @click="previousPage" :disabled="currentPage === 1"><BackIcon /></ButtonImage>
        <span>{{ currentPage }} / {{ totalPages }}</span>
        <ButtonImage class="py-2 border-none shadow-none" @click="nextPage" :disabled="currentPage === totalPages"><NextIcon /></ButtonImage>
    </div>

    <Modal maxWidth="7xl" :show="showingModalSparePartDetail">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Detail Spare Part</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <SparePartDetail :sparePart="selectedSparePart" :categorySpareParts="categorySpareParts" />
        </div>
    </Modal>
</template>
