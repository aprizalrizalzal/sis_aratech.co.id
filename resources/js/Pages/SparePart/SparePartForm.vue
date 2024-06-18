<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    image: null,
    price: '',
});

const props = defineProps({
    sparePart: Object,
});

if (props.sparePart) {
    form.name = props.sparePart.name;
    form.image_path = props.sparePart.image_path;
    form.price = props.sparePart.price;
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
    if (!props.sparePart) {
        form.post(route('store.spare.part'), {
            preserveScroll: true,
            onSuccess: (response) => {
                form.reset();
                previewUrl.value = null;
                uploadedImageUrl.value = response.image_url;
            },
            onError: (errors) => {
                if (errors.name || errors.image || errors.price) {
                    alert('Spare part addition failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    } else {
        const sparePartId = props.sparePart.id;
        form.put(route('update.spare.part', { id: sparePartId }), {
            preserveScroll: true,
            onSuccess: (response) => {
                form.data();
                previewUrl.value = null;
                uploadedImageUrl.value = response.image_url;
            },
            onError: (errors) => {
                if (errors.name || errors.image || errors.price) {
                    alert('Spare part update failed!');
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
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div>
                    <InputLabel class="mt-3" for="name" value="Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Name"
                        required autofocus />
                    <InputError class="mt-3" :message="form.errors.name" />
                </div>
                <div>
                    <div v-if="previewUrl" class="my-4">
                        <p class="font-semibold">Preview:</p>
                        <img :src="previewUrl" alt="Image Preview" class="w-full h-auto mt-2 rounded-md" />
                    </div>
                    <InputLabel for="image" value="Image" />
                    
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <div>
                    <InputLabel class="mt-3" for="price" value="Price" />
                    <TextInput id="price" type="text" class="mt-1 block w-full" v-model="form.price" placeholder="Price"
                        required autofocus />
                    <InputError class="mt-3" :message="form.errors.price" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3" :disabled="form.processing">
                        {{ props.sparePart ? 'Update Spare Part' : 'Add Spare Part' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.sparePart ? 'Spare Part updated successfully!' : 'Spare Part added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>
