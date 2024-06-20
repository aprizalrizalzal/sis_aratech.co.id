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
    if (!props.header) {
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
    } else{
        const headerId = props.header.id;
        form.put(route('update.header', { id: headerId }), {
            preserveScroll: true,
            onSuccess: (response) => {
                form.data();
                previewUrl.value = null;
                uploadedImageUrl.value = response.image_url;
            },
            onError: (errors) => {
                if (errors.image || errors.alt) {
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
                <div>
                    <InputLabel for="image" value="Icon" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <div>
                    <InputLabel for="company" value="Company Name" />
                    <TextInput id="company" type="text" v-model="form.company" class="mt-1 block w-full"
                        placeholder="Enter company name" />
                    <InputError :message="form.errors.company" />
                </div>
                <div>
                    <InputLabel for="description" value="Description Company" />
                    <textarea id="description" type="text" v-model="form.description" class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                        placeholder="Enter description company" />
                    <InputError :message="form.errors.description" />
                </div>
                <div v-if="previewUrl" class="mt-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" company="Image Preview" class="w-full h-auto mt-2 rounded-md" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3" :disabled="form.processing">
                        Add Header
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        Header added successfully!
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>

