<script setup>
import { ref, computed, watch } from 'vue';
import CardView from '@/Components/CardView.vue';
import SearchInput from '@/Components/SearchInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SparePartDetail from '../SparePart/SparePartDetail.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import ButtonImage from '@/Components/ButtonImage.vue';
import RadioButton from '@/Components/RadioButton.vue';
import GridIcon from '@/Components/Icon/GridIcon.vue';
import Dropdown from '@/Components/Dropdown.vue';
import FilterIcon from '@/Components/Icon/FilterIcon.vue';

const props = defineProps({
    spareParts: Array,
    categorySpareParts: Array
});

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(6); // Initial value

const filteredSpareParts = computed(() => {
    if (!searchQuery.value) {
        return props.spareParts;
    }
    return props.spareParts.filter(sparePart =>
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
        <!-- <div class="relative">
            <Dropdown align="left" width="48">
                <template #trigger>
                    <span class="inline-flex rounded">
                        <div>
                            <ButtonImage class="border-none p-2">
                                <FilterIcon />
                            </ButtonImage>
                        </div>
                    </span>
                </template>

<template #content>
                    <RadioButton name="itemsPerPage" value="6" v-model:checked="itemsPerPage">6 Product</RadioButton>
                    <RadioButton name="itemsPerPage" value="12" v-model:checked="itemsPerPage">12 Product</RadioButton>
                    <RadioButton name="itemsPerPage" value="24" v-model:checked="itemsPerPage">24 Product</RadioButton>
                    <RadioButton name="itemsPerPage" :value="filteredSpareParts.length" v-model:checked="itemsPerPage">
                        All Product</RadioButton>
                </template>
</Dropdown>
</div> -->
        <div class="flex items-center">
            <h2 class="flex font-semibold text-green-900 leading-tight flex-none py-4">
                <span>Spare Part</span>
            </h2>
        </div>
        <div class="flex w-full items-center">
            <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for the part name or description" />
        </div>

        <div class="relative">
            <Dropdown align="right" width="48">
                <template #trigger>
                    <span class="inline-flex rounded">
                        <div>
                            <ButtonImage class="border-none p-2">
                                <GridIcon />
                            </ButtonImage>
                        </div>
                    </span>
                </template>

                <template #content>
                    <RadioButton name="itemsPerPage" value="6" v-model:checked="itemsPerPage">6 Product</RadioButton>
                    <RadioButton name="itemsPerPage" value="12" v-model:checked="itemsPerPage">12 Product</RadioButton>
                    <RadioButton name="itemsPerPage" value="24" v-model:checked="itemsPerPage">24 Product</RadioButton>
                    <RadioButton name="itemsPerPage" :value="filteredSpareParts.length" v-model:checked="itemsPerPage">
                        All Product</RadioButton>
                </template>
            </Dropdown>
        </div>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 my-2 text-sm font-bold text-green-900">
        <div v-for="sparePart in paginatedSpareParts" :key="sparePart.id">
            <CardView @click="showModalSparePartDetail(sparePart)" :name="sparePart.name"
                :price="formatCurrency(sparePart.price)">
                <template #img>
                    <img :src="sparePart.image_path" :alt="sparePart.name" class="h-40 w-full object-cover" />
                </template>
            </CardView>
        </div>
    </div>
    <div class="flex justify-center gap-4 items-center p-6">
        <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
        <span>{{ currentPage }} of {{ totalPages }}</span>
        <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
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
