<script setup>
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,

    sparePart: Object,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};
</script>

<template>
    <div class="bg-gray-50 text-green-900/50 my-6">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-green-700 selection:text-white">
            <div class="relative w-full max-w-2xl lg:max-w-7xl">
                <main class="grid mt-4 mb-8">
                    <div class="flex overflow-x-auto m-auto">
                        <div
                            class="grid sm:grid-cols-2 grid-cols-1 justify-between items-stretch rounded-md overflow-hidden shadow-md bg-white hover:bg-green-50 focus:bg-green-50 active:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-50 focus:ring-offset-2 hover:ring-green-900/20 ring-1 ring-white/[0.05] transition ease-in-out duration-150 m-2 p-4">
                            <div class="h-full flex items-center justify-center p-2">
                                <img :src="sparePart.image_path" :alt="sparePart.name">
                            </div>
                            <div class="text-start sm:py-2 px-2">
                                <h1 class="text-green-900 font-bold mb-2">{{ sparePart.name }}</h1>
                                <p class="text-green-600 text-sm/relaxed font-bold">
                                    {{ sparePart.category }}
                                </p>
                                <p class="text-gray-500 text-sm/relaxed overflow-hidden">
                                    {{ sparePart.description }}
                                </p>
                                <p class="inline-block bg-green-600 p-1 rounded-md text-white mt-2">
                                    {{ formatCurrency(sparePart.price) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>
