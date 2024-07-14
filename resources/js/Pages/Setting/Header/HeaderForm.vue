<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    image: null,
    company: '',
    description: '',
});

const props = defineProps({
    headerId: Number,
    header: Object,
});

if (props.header) {
    form.image_path = props.header.image_path;
    form.company = props.header.company;
    form.description = props.header.description;
}

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
    if (props.headerId) {
        const headerId = props.headerId;
        form.post(route('update.header.image', { id: headerId }), {
            preserveScroll: true,
            onSuccess: (response) => {
                form.data();
                previewUrl.value = null;
                uploadedImageUrl.value = response.image_url;
            },
            onError: (errors) => {
                if (errors.image) {
                    alert('Header update image failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    } else if (!props.header) {
        form.post(route('store.header'), {
            preserveScroll: true,
            onSuccess: (response) => {
                form.reset();
                previewUrl.value = null;
                uploadedImageUrl.value = response.image_url;
            },
            onError: (errors) => {
                if (errors.image || errors.company || errors.description) {
                    alert('Header upload failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    } else {
        const headerId = props.header.id;
        form.put(route('update.header', { id: headerId }), {
            preserveScroll: true,
            onSuccess: () => {
                form.data();
            },
            onError: (errors) => {
                if (errors.company || errors.description) {
                    alert('Header update failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    }
};

</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="space-y-4">
                <div v-if="!props.header && !props.header || props.headerId">
                    <InputLabel for="image" value="Image" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <div v-if="!props.headerId">
                    <InputLabel for="company" value="Company Name" />
                    <TextInput id="company" type="text" v-model="form.company" class="mt-1 block w-full"
                        placeholder="Company name" required autofocus />
                    <InputError :message="form.errors.company" />
                </div>
                <div v-if="!props.headerId">
                    <InputLabel for="description" value="Description Company" />
                    <textarea id="description" type="text" v-model="form.description"
                        class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                        placeholder="Description company or address" autofocus />
                    <InputError :message="form.errors.description" />
                </div>
                <div v-if="previewUrl" class="mt-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" company="Image Preview" class="w-full h-auto mt-2 rounded-md" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3" :disabled="form.processing">
                        {{ props.header ? 'Update Header' : 'Save Header' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.header ? 'Header updated successfully!' : 'Header added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>
