<script setup>
import CardView from '@/Components/CardView.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { ref, computed} from 'vue';

const props = defineProps({
    spareParts: Array,
});

const searchQuery = ref('');

const filteredSpareParts = computed(() => {
    if (!searchQuery.value) {
        return props.spareParts;
    }
    return props.spareParts.filter(sparePart =>
        sparePart.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        sparePart.price.toString().toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};
</script>

<template>
    <div class="flex justify-between items-center pt-4 pb-4 ">
        <div class="flex items-center">
            <h2 class=" flex font-semibold text-lg text-green-900 leading-tight flex-none px-2 py-4 ">
                <span class="hidden lg:block">ASLI Mandiri Computer-</span>
                <span>AMITech</span>
            </h2>
        </div>
        <div class="flex items-center">
            <SearchInput v-model:searchQuery="searchQuery" />
        </div>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 my-2 text-sm font-bold text-green-900">
        <CardView v-for="sparePart in filteredSpareParts" :key="sparePart" :name="sparePart.name"
            :price="formatCurrency(sparePart.price)">
            <template #img>
                <img :src="sparePart.image_path" :alt="sparePart.name">
            </template>
        </CardView>
    </div>
</template>