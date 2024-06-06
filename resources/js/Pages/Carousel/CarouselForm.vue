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

const previewUrl = ref(null);
const uploadedImageUrl = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};

const submitForm = () => {
    form.post(route('store.carousel'), {
        preserveScroll: true,
        onSuccess: (response) => {
            form.reset();
            previewUrl.value = null;
            uploadedImageUrl.value = response.image_url;
        },
        onError: (errors) => {
            if (errors.image || errors.alt) {
                alert('Image upload failed!');
            } else {
                console.error('An error occurred:', errors);
            }
        }
    });
};
</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="space-y-4">
                <div>
                    <InputLabel for="image" value="Upload Image" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <div>
                    <InputLabel for="alt" value="Image Alt Text" />
                    <TextInput id="alt" type="text" v-model="form.alt" class="mt-1 block w-full"
                        placeholder="Enter alt text" />
                    <InputError :message="form.errors.alt" />
                </div>
                <div v-if="previewUrl" class="mt-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" alt="Image Preview" class="w-full h-auto mt-2 rounded-md" />
                </div>
                <div>
                    <PrimaryButton class="mt-3" :disabled="form.processing">
                        Upload Image
                    </PrimaryButton><span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        Image uploaded successfully!
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>
