<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    sparePart: Object,
});

const imageSpareParts = ref(props.sparePart.image_spare_parts || []);
const initialImage = ref(props.sparePart.image_path);
const selectedImage = ref(initialImage.value);

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const formatDescription = (description) => {
    return description.replace(/\n/g, '<br>');
};

const selectImage = (imagePath) => {
    selectedImage.value = (selectedImage.value === imagePath) ? initialImage.value : imagePath;
};

watch(() => props.sparePart.image_path, (newValue) => {
    initialImage.value = newValue;
    selectedImage.value = newValue;
});
</script>

<template>
    <h1 class="text-green-900 font-bold my-4 text-center sm:text-lg text-md">{{ sparePart.name }}</h1>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-4">
        <div class="h-full">
            <img :src="selectedImage" :alt="sparePart.name" class="rounded-md shadow-md">
            <div v-if="imageSpareParts.length" class="mt-6">
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 mt-4">
                    <div v-for="(imageSparePart, index) in imageSpareParts" :key="index" class="relative">
                        <img 
                            :src="imageSparePart.image_path" 
                            alt="Image Spare Part" 
                            class="w-full h-auto rounded-md cursor-pointer" 
                            @click="selectImage(imageSparePart.image_path)" 
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="text-start">
            <p class="text-green-600 text-sm/relaxed font-bold py-1 px-2 mb-2 rounded-md text-white bg-green-600">
                <span>Category </span>#{{ sparePart.category_spare_part.name }}
            </p>
            <p class="text-green-900 text-sm/relaxed font-bold mb-2">
                <span>Pieces </span>{{ sparePart.pieces }}
            </p>
            <hr>
            <p class="text-gray-500 text-sm/relaxed overflow-hidden" v-html="formatDescription(sparePart.description)">
            </p>
            <hr>
            <p class="inline-block bg-green-600 py-1 px-2 rounded-md text-white mt-2">
                {{ formatCurrency(sparePart.price) }}
            </p>
        </div>
    </div>
</template>

<style scoped>
.relative {
    position: relative;
}

.cursor-pointer {
    cursor: pointer;
}
</style>

