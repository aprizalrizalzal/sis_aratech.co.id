<script setup>
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,

    sparePart: Object,
    categorySpareParts: Array,
});

const getCategorySparePartName = (categorySparePartId) => {
    return props.categorySpareParts.find(categorySparePart => categorySparePart.id === categorySparePartId)?.name || 'Unknown Category';
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const formatDescription = (description) => {
    return description.replace(/\n/g, '<br>');
};
</script>

<template>
    <h1 class="text-green-900 font-bold my-4 text-center sm:text-lg text-md">{{ sparePart.name }}</h1>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-4">
        <div class="h-full">
            <img :src="sparePart.image_path" :alt="sparePart.name" class="rounded-md shadow-md">
        </div>
        <div class="text-start">
            <p class="text-green-600 text-sm/relaxed font-bold py-1 px-2 mb-2 rounded-md text-white bg-green-600">
                #{{ getCategorySparePartName(sparePart.category_spare_part_id) }}
            </p>
            <p class="text-gray-500 text-sm/relaxed overflow-hidden" v-html="formatDescription(sparePart.description)">
            </p>
            <p class="inline-block bg-green-600 py-1 px-2 rounded-md text-white mt-2">
                {{ formatCurrency(sparePart.price) }}
            </p>
        </div>
    </div>
</template>
