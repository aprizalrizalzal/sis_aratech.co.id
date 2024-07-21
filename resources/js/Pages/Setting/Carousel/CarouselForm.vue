<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    image: null,
    alt: '',
});

const props = defineProps({
    carouselId: Number,
    carousel: Object,
});

if (props.carousel) {
    form.image_path = props.carousel.image_path;
    form.alt = props.carousel.alt;
}

const previewUrl = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};

const submitForm = () => {
    if (props.carouselId) {
        const carouselId = props.carouselId;
        form.post(route('update.carousel.image', { id: carouselId }), {
            preserveScroll: true,
            onSuccess: () => {
                form.data();
                previewUrl.value = null;
            },
            onError: (errors) => {
                if (errors.image) {
                    alert('update failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else if (!props.carousel) {
        form.post(route('store.carousel'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('image_path', 'alt');
                previewUrl.value = null;
                emit('addCarousel');
            },
            onError: (errors) => {
                if (errors.image || errors.alt) {
                    alert('addition failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else {
        const carouselId = props.carousel.id;
        form.put(route('update.carousel', { id: carouselId }), {
            preserveScroll: true,
            onSuccess: () => {
                form.data();
                emit('updateCarousel');
            },
            onError: (errors) => {
                if (errors.alt) {
                    alert('update failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    }
};

const emit = defineEmits([
    'addCarousel',
    'updateCarousel'
]);

</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="space-y-4">
                <div v-if="!props.carousel && !props.carousel || props.carouselId">
                    <InputLabel for="image" value="Image" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <div v-if="!props.carouselId">
                    <InputLabel for="alt" value="Image Alt Text" />
                    <TextInput id="alt" type="text" v-model="form.alt" class="mt-1 block w-full"
                        placeholder="Enter alt text" required autofocus />
                    <InputError :message="form.errors.alt" />
                </div>
                <div v-if="previewUrl" class="mt-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" alt="Image Preview" class="w-full h-auto mt-2 rounded-sm" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3" :disabled="form.processing">
                        {{ props.carousel ? 'Update' : 'Save' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
