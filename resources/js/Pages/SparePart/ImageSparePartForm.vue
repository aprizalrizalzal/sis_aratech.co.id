<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ButtonImage from '@/Components/ButtonImage.vue';
import EraserIcon from '@/Components/Icon/EraserIcon.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    sparePart: Object,
});

const form = useForm({
    id: null,
    spare_part_id: '',
    image: null,
});

const confirmingImageSparePartDeletion = ref(false);
const imageSuccessfullyAdded = ref(false);

const confirmImageSparePartDeletion = (imageSparePartId) => {
    confirmingImageSparePartDeletion.value = true;
    form.id = imageSparePartId;
};

if (props.sparePart) {
    const sparePartId = props.sparePart.id;
    form.spare_part_id = sparePartId;
}

const previewUrl = ref(null);
const uploadedImageUrl = ref(null);
const imageSpareParts = ref(props.sparePart.image_spare_parts || []);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};

const submitForm = () => {
    form.post(route('store.image.spare.part.image'), {
        preserveScroll: true,
        onSuccess: (response) => {
            form.data();
            previewUrl.value = null;
            uploadedImageUrl.value = response.image_url;
            imageSpareParts.value.push({ uploadedImageUrl }); // Update the image list
            imageSuccessfullyAdded.value = true; // Set success message
            setTimeout(() => imageSuccessfullyAdded.value = false, 3000);
        },
        onError: (errors) => {
            if (errors.image) {
                alert('addition failed!');
            } else {
                console.error('An error occurred:', errors);
            }
        }
    });
};

const deleteImageSparePart = () => {
    form.delete(route('destroy.image.spare.part.image'), {
        preserveScroll: true,
        onSuccess: () => {
            imageSpareParts.value = imageSpareParts.value.filter(imageSparePart => imageSparePart.id !== form.id); // Remove the deleted imageSparePart from the list
            form.reset();
            closeModal();
        },
        onError: (errors) => {
            if (errors) {
                console.error('An error occurred:', errors);
            } else {
                const errorMessages = Object.values(errors).flat();
                alert(`${errorMessages}`);
            }
        }
    });
};

watch(() => props.sparePart.image_spare_parts, (newImages) => {
    imageSpareParts.value = newImages;
});

const closeModal = () => {
    confirmingImageSparePartDeletion.value = false;
};

</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div v-if="props.sparePart" class="hidden">
                    <InputLabel for="spare_part_id" value="Spare Part ID" />
                    <TextInput id="spare_part_id" type="number" class="mt-1 block w-full" v-model="form.spare_part_id" placeholder="Spare Part ID"
                    required />
                    <InputError class="mt-2" :message="form.errors.spare_part_id" />
                </div>
                <div>
                    <InputLabel for="image" value="Image" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <div v-if="previewUrl" class="my-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" alt="Image Preview" class="w-full h-auto mt-2 rounded-md" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                    <span v-if="imageSuccessfullyAdded" class="text-green-500 ml-4">
                        added successfully!
                    </span>
                </div>
            </form>

            <div v-if="imageSpareParts.length"class="mt-6">
                <p class="font-semibold text-center">Existing Images</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 mt-4">
                    <div v-for="(imageSparePart, index) in imageSpareParts" :key="index" class="relative">
                        <img :src="imageSparePart.image_path" alt="Image Spare Part" class="w-full h-auto rounded-md" />
                        {{ imageSparePart.id }}
                        <ButtonImage @click="confirmImageSparePartDeletion(imageSparePart.id)" class="absolute top-1 right-1 inline-flex items-center p-0.5 bg-white border border-red-600 rounded-md font-semibold text-xs text-red-800 tracking-widest shadow-sm hover:bg-red-50 focus:outline-none focus:ring-1 focus:ring-red-800 disabled:opacity-25 transition ease-in-out duration-150"><EraserIcon /></ButtonImage>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Modal :show="confirmingImageSparePartDeletion">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your Image Spare Part?
            </h2>
            <p class="mt-1 text-sm text-green-600">
                Once your Image Spare Part is deleted, all of its resources and data will be permanently deleted.
            </p>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteImageSparePart">
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
