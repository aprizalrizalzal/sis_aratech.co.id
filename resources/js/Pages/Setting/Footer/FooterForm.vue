<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DropdownSelect from '@/Components/DropdownSelect.vue';

const form = useForm({
    image: null,
    type: '',
    platform: '',
    url: '',
    username: '',
    value: '',
});

const typeOptions = ref([
    { id: '1', name: 'Contact' },
    { id: '2', name: 'Social Media' },
    { id: '3', name: 'App Download' },
]);

const props = defineProps({
    footer: Object,
});

if (props.footer) {
    form.image_path = props.footer.image_path;
    form.type = props.footer.type;
    form.platform = props.footer.platform;
    form.url = props.footer.url;
    form.username = props.footer.username;
    form.value = props.footer.value;
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
    if (!props.footer) {
        form.post(route('store.footer'), {
            preserveScroll: true,
            onSuccess: (response) => {
                form.reset();
                previewUrl.value = null;
                uploadedImageUrl.value = response.image_url;
            },
            onError: (errors) => {
                if (errors.image || errors.type || errors.platform || errors.url || errors.username || errors.value) {
                    alert('Footer upload failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    } else {
        const footerId = props.footer.id;
        form.put(route('update.footer', { id: footerId }), {
            preserveScroll: true,
            onSuccess: (response) => {
                form.data();
                previewUrl.value = null;
                uploadedImageUrl.value = response.image_url;
            },
            onError: (errors) => {
                if (errors.image || errors.type || errors.platform || errors.url || errors.username || errors.value) {
                    alert('Footer update failed!');
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
                    <InputLabel for="image" value="Image" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" />
                    <InputError :message="form.errors.image" />
                </div>
                <div>
                    <DropdownSelect id="type" label="Type" :options="typeOptions" optionProperty="name"
                        valueProperty="name" v-model="form.type"
                        :placeholder="props.footer ? props.footer.type : 'Select type'" />
                    <InputError class="mt-3" :message="form.errors.type" />
                </div>

                <div>
                    <InputLabel for="platform" value="Platform" />
                    <TextInput id="platform" type="text" v-model="form.platform" class="mt-1 block w-full"
                        placeholder="Gmail, Facebook, Instagram, etc..." autofocus />
                    <InputError :message="form.errors.platform" />
                </div>

                <div>
                    <InputLabel for="url" value="URL" />
                    <TextInput id="url" type="text" v-model="form.url" class="mt-1 block w-full" placeholder="https://"
                        autofocus />
                    <InputError :message="form.errors.url" />
                </div>

                <div>
                    <InputLabel for="username" value="Username" />
                    <TextInput id="username" type="text" v-model="form.username" class="mt-1 block w-full"
                        placeholder="Facebook, Instagram, etc..." autofocus />
                    <InputError :message="form.errors.username" />
                </div>

                <div>
                    <InputLabel for="value" value="Value" />
                    <TextInput id="value" type="text" v-model="form.value" class="mt-1 block w-full"
                        placeholder="Email, Facebook, Instagram, etc..." autofocus />
                    <InputError :message="form.errors.value" />
                </div>

                <div v-if="previewUrl" class="mt-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" company="Image Preview" class="w-full h-auto mt-2 rounded-md" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3" :disabled="form.processing">
                        {{ props.footer ? 'Update Footer' : 'Add Footer' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.footer ? 'Footer updated successfully!' : 'Footer added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>
