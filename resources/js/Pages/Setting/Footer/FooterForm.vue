<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DropdownSelect from '@/Components/DropdownSelect.vue';

const props = defineProps({
    typeFooters: Array,
    platformFooters: Array,

    footerId: Number,
    footer: Object,
});

const form = useForm({
    image: null,
    type_footer_id: '',
    platform_footer_id: '',
    url: '',
    username: '',
    value: '',
});

if (props.footer) {
    form.image_path = props.footer.image_path;
    form.type_footer_id = props.footer.type_footer_id;
    form.platform_footer_id = props.footer.platform_footer_id;
    form.url = props.footer.url;
    form.username = props.footer.username;
    form.value = props.footer.value;
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
    if (props.footerId) {
        const footerId = props.footerId;
        form.post(route('update.footer.image', { id: footerId }), {
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
    } else if (!props.footer) {
        form.post(route('store.footer'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('image', 'url', 'username', 'value');
                previewUrl.value = null;
                emit('addFooter');
            },
            onError: (errors) => {
                if (errors.image || errors.type_footer_id || errors.platform_footer_id || errors.url || errors.username || errors.value) {
                    alert('addition failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else {
        const footerId = props.footer.id;
        form.put(route('update.footer', { id: footerId }), {
            preserveScroll: true,
            onSuccess: () => {
                form.data();
                emit('updateFooter');
            },
            onError: (errors) => {
                if (errors.type_footer_id || errors.platform_footer_id || errors.url || errors.username || errors.value) {
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
    'addFooter',
    'updateFooter'
]);

</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="space-y-4">
                <div v-if="!props.footer || !props.footer && props.footerId">
                    <InputLabel for="image" value="Image" />
                    <input type="file" id="image" @change="handleFileChange" class="mt-1 block w-full" required
                        autofocus />
                    <InputError :message="form.errors.image" />
                </div>
                <div v-if="!props.footerId">
                    <DropdownSelect id="type_footer_id" label="Type" :options="typeFooters" optionProperty="type"
                        valueProperty="id" v-model="form.type_footer_id"
                        :placeholder="props.footer ? props.footer.type_footer.type : 'Select Type'" />
                    <InputError class="mt-2" :message="form.errors.type_footer_id" />
                </div>

                <div v-if="!props.footerId">
                    <DropdownSelect id="platform_footer_id" label="Type" :options="platformFooters"
                        optionProperty="platform" valueProperty="id" v-model="form.platform_footer_id"
                        :placeholder="props.footer ? props.footer.platform_footer.platform : 'Select Platform'" />
                    <InputError class="mt-2" :message="form.errors.platform_footer_id" />
                </div>

                <div v-if="!props.footerId">
                    <InputLabel for="url" value="URL" />
                    <TextInput id="url" type="text" v-model="form.url" class="mt-1 block w-full" placeholder="https://"
                        required />
                    <InputError :message="form.errors.url" />
                </div>

                <div v-if="!props.footerId">
                    <InputLabel for="username" value="Username" />
                    <TextInput id="username" type="text" v-model="form.username" class="mt-1 block w-full"
                        placeholder="Email, Phone, Facebook, Instagram, etc..." required />
                    <InputError :message="form.errors.username" />
                </div>

                <div v-if="!props.footerId">
                    <InputLabel for="value" value="Value" />
                    <TextInput id="value" type="text" v-model="form.value" class="mt-1 block w-full"
                        placeholder="Email, Phone, Facebook, Instagram, etc..." required />
                    <InputError :message="form.errors.value" />
                </div>

                <div v-if="previewUrl" class="mt-4">
                    <p class="font-semibold">Preview:</p>
                    <img :src="previewUrl" company="Image Preview" class="w-full h-auto mt-2 rounded-md" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3" :disabled="form.processing">
                        {{ props.footer ? 'Update' : 'Save' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
