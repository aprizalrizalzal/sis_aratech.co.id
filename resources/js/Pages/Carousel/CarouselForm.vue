<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    url: '',
});

const props = defineProps({
    url: Object,
});

if (props.url) {
    form.url = props.url.url;
}

const submitForm = () => {
    if (!props.url) {
        form.post(route('store.image.url'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: (errors) => {
                if (errors.url) {
                    alert('Image Url addition failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    } else {
        const urlId = props.url.id;
        form.put(route('update.image.url', { id: urlId }), {
            preserveScroll: true,
            onSuccess: () => form.data(),
            onError: (errors) => {
                if (errors.url) {
                    alert('Image Url update failed!');
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
                    <InputLabel for="url" value="Type Name" />
                    <TextInput id="url" type="text" class="mt-1 block w-full" v-model="form.url" placeholder="Type Name"
                        required autofocus />
                    <InputError class="mt-3" :message="form.errors.url" />
                </div>
                <div>
                    <PrimaryButton class="mt-3">
                        {{ props.url ? 'Update Image Url' : 'Add Image Url' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.url ? 'Image Url update successfully!' : 'Image Url added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>