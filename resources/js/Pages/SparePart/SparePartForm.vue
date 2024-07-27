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
    pieces: '',
    price: '',
    description: '',
});

const props = defineProps({
    categorySpareParts: Array,

    sparePartId: Number,
    sparePart: Object,
});

if (props.sparePart) {
    form.image_path = props.sparePart.image_path;
    form.name = props.sparePart.name;
    form.category_spare_part_id = props.sparePart.category_spare_part_id;
    form.pieces = props.sparePart.pieces;
    form.price = props.sparePart.price;
    form.description = props.sparePart.description;
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
    if (props.sparePartId) {
        const sparePartId = props.sparePartId;
        form.post(route('update.spare.part.image', { id: sparePartId }), {
            preserveScroll: true,
            onSuccess: () => {
                form.data();
                previewUrl.value = null;
                emit('updateImageSparePart');
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
    } else if (!props.sparePart) {
        form.post(route('store.spare.part'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('image', 'name', 'description', 'pieces', 'price');
                previewUrl.value = null;
                emit('addSparePart');
            },
            onError: (errors) => {
                if (errors.image || errors.name || errors.category_spare_part_id || errors.description || errors.pieces || errors.price) {
                    alert('addition failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else {
        const sparePartId = props.sparePart.id;
        form.put(route('update.spare.part', { id: sparePartId }), {
            preserveScroll: true,
            onSuccess: () => {
                form.data();
                emit('updateSparePart');
            },
            onError: (errors) => {
                if (errors.name || errors.category_spare_part_id || errors.description || errors.pieces || errors.price) {
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
    'updateImageSparePart',
    'addSparePart',
    'updateSparePart'
]);
</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div v-if="!props.sparePart || !props.sparePart && props.sparePartId">
                    <InputLabel for="image" value="Cover" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <div v-if="!props.sparePartId">
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Name"
                        required autofocus />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div v-if="!props.sparePartId">
                    <DropdownSelect id="category_spare_part_id" label="Category" optionProperty="name"
                        valueProperty="id" :options="categorySpareParts" v-model="form.category_spare_part_id"
                        :placeholder='props.sparePart ? props.sparePart.category_spare_part.name : "Select Category"'
                        class="w-full" />
                    <InputError class="mt-2" :message="form.errors.category_spare_part_id" />
                </div>
                <div v-if="!props.sparePartId">
                    <InputLabel for="pieces" value="Pieces" />
                    <TextInput id="pieces" type="text" inputmode="numeric" class="mt-1 block w-full" v-model="form.pieces"
                        placeholder="Pieces" required />
                    <InputError class="mt-2" :message="form.errors.pieces" />
                </div>
                <div v-if="!props.sparePartId">
                    <InputLabel for="price" value="Price" />
                    <TextInput id="price" type="text" inputmode="numeric" class="mt-1 block w-full" v-model="form.price"
                        placeholder="Price" required />
                    <InputError class="mt-2" :message="form.errors.price" />
                </div>
                <div v-if="!props.sparePartId">
                    <InputLabel for="description" value="Description" />
                    <textarea id="description" type="text"
                        class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded shadow"
                        v-model="form.description" placeholder="Description" required />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div v-if="previewUrl" class="my-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" alt="Image Preview" class="w-full h-auto mt-2 rounded" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3" :disabled="form.processing">
                        {{ props.sparePart ? 'Update' : 'Save' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
