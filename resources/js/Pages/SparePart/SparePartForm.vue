<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DropdownSelect from '@/Components/DropdownSelect.vue';

const form = useForm({
    name: '',
    image: null,
    category_spare_part_id: '',
    description: '',
    price: '',
});

const props = defineProps({
    categorySpareParts: Array,

    sparePartId: Number,
    sparePart: Object,
});

const getCategorySparePartName = (categorySparePartId) => {
    return props.categorySpareParts.find(categorySparePart => categorySparePart.id === categorySparePartId)?.name || 'Unknown Category';
};

if (props.sparePart) {
    form.image_path = props.sparePart.image_path;
    form.name = props.sparePart.name;
    form.category_spare_part_id = props.sparePart.category_spare_part_id;
    form.price = props.sparePart.price;
    form.description = props.sparePart.description;
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
    if (props.sparePartId) {
        const sparePartId = props.sparePartId;
        form.post(route('update.spare.part.image', { id: sparePartId }), {
            preserveScroll: true,
            onSuccess: (response) => {
                form.data();
                previewUrl.value = null;
                uploadedImageUrl.value = response.image_url;
            },
            onError: (errors) => {
                if (errors.image) {
                    alert('Spare part image update failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    } else if (!props.sparePart) {
        form.post(route('store.spare.part'), {
            preserveScroll: true,
            onSuccess: (response) => {
                form.reset();
                previewUrl.value = null;
                uploadedImageUrl.value = response.image_url;
            },
            onError: (errors) => {
                if (errors.image || errors.name || errors.category_spare_part_id || errors.description || errors.price) {
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
            onSuccess: () => {
                form.data();
            },
            onError: (errors) => {
                if (errors.name || errors.category_spare_part_id || errors.description || errors.price) {
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
                <div v-if="!props.sparePart || !props.sparePart && props.sparePartId">
                    <InputLabel for="image" value="Image" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <div v-if="!props.sparePartId">
                    <InputLabel class="mt-3" for="name" value="Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Name"
                        required autofocus />
                    <InputError class="mt-3" :message="form.errors.name" />
                </div>
                <div v-if="!props.sparePartId">
                    <InputLabel class="mt-3" for="category_spare_part_id" value="Category" />
                    <div class="flex items-center justify-between">
                        <div v-if="props.sparePart" class="me-4 w-full">
                            <span>{{ getCategorySparePartName(props.sparePart.category_spare_part_id) }}</span>
                        </div>
                        <DropdownSelect id="category_spare_part_id" optionProperty="name" valueProperty="id"
                            :options="categorySpareParts" v-model="form.category_spare_part_id"
                            placeholder="Select Category" class="w-full" />
                        <InputError class="mt-3" :message="form.errors.category_spare_part_id" />
                    </div>
                </div>
                <div v-if="!props.sparePartId">
                    <InputLabel class="mt-3" for="description" value="Description" />
                    <textarea id="description" type="text"
                        class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                        v-model="form.description" placeholder="Description" required />
                    <InputError class="mt-3" :message="form.errors.description" />
                </div>
                <div v-if="!props.sparePartId">
                    <InputLabel class="mt-3" for="price" value="Price" />
                    <TextInput id="price" type="text" class="mt-1 block w-full" v-model="form.price" placeholder="Price"
                        required />
                    <InputError class="mt-3" :message="form.errors.price" />
                </div>
                <div v-if="previewUrl" class="my-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" alt="Image Preview" class="w-full h-auto mt-2 rounded-md" />
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
