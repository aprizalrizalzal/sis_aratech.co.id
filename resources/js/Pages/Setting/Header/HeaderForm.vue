<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

// Menggunakan useForm dari Inertia untuk mengelola state form
const form = useForm({
    image: null,
    company: '',
    description: '',
});

// Menggunakan ref untuk menyimpan URL preview gambar yang diunggah
const previewUrl = ref(null);

// Handler untuk mengubah file gambar dan menampilkan preview
const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file; // Mengatur nilai form.image dengan file yang dipilih
        previewUrl.value = URL.createObjectURL(file); // Membuat URL objek untuk preview gambar
    }
};

// Handler untuk mengirim form
const submitForm = () => {
    form.post(route('store.header'), {
        preserveScroll: true, // Menyimpan posisi scroll setelah submit
        onSuccess: (response) => {
            form.reset(); // Mereset form setelah berhasil
            previewUrl.value = null; // Menghapus preview URL
            // Mengatur URL gambar yang diunggah untuk ditampilkan jika perlu
            uploadedImageUrl.value = response.image_url;
        },
        onError: (errors) => {
            // Menangani error ketika ada kesalahan validasi
            if (errors.image || errors.company || errors.description) {
                alert('Header upload failed!');
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
                <!-- Input untuk memilih file gambar -->
                <div>
                    <InputLabel for="image" value="Icon" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <!-- Input untuk nama perusahaan -->
                <div>
                    <InputLabel for="company" value="Company Name" />
                    <TextInput id="company" type="text" v-model="form.company" class="mt-1 block w-full"
                        placeholder="Enter company name" />
                    <InputError :message="form.errors.company" />
                </div>
                <!-- Input untuk deskripsi perusahaan -->
                <div>
                    <InputLabel for="description" value="Description Company" />
                    <TextInput id="description" type="text" v-model="form.description" class="mt-1 block w-full"
                        placeholder="Enter description company" />
                    <InputError :message="form.errors.description" />
                </div>
                <!-- Preview gambar yang diunggah -->
                <div v-if="previewUrl" class="mt-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" company="Image Preview" class="w-full h-auto mt-2 rounded-md" />
                </div>
                <!-- Tombol untuk mengirim form -->
                <div>
                    <PrimaryButton class="mt-6 mb-3" :disabled="form.processing">
                        Add Header
                    </PrimaryButton>
                    <!-- Pesan berhasil jika form baru saja berhasil -->
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        Header added successfully!
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>

