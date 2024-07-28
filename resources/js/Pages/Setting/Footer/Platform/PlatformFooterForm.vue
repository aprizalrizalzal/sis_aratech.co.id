<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    platform: '',
    description: '',
});

const props = defineProps({
    platformFooter: Object,
});

if (props.platformFooter) {
    form.platform = props.platformFooter.platform;
    form.description = props.platformFooter.description;
}

const submitForm = () => {
    if (!props.platformFooter) {
        form.post(route('store.platform.footer'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('platform', 'description'),
                    emit('addPlatformFooter');
            },
            onError: (errors) => {
                if (errors.platform) {
                    alert('addition failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else {
        const platformFooterId = props.platformFooter.id;
        form.put(route('update.platform.footer', { id: platformFooterId }), {
            preserveScroll: true,
            onSuccess: () => {
                form.data(),
                    emit('updatePlatformFooter');
            },
            onError: (errors) => {
                if (errors.platform) {
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
    'addPlatformFooter',
    'updatePlatformFooter'
]);

</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div>
                    <InputLabel for="platform" value="Platform" />
                    <TextInput id="platform" type="text" class="mt-1 block w-full" v-model="form.platform"
                        placeholder="platform" required autofocus />
                    <InputError class="mt-2" :message="form.errors.platform" />
                </div>
                <div>
                    <InputLabel for="description" value="Description" />
                    <textarea id="description" type="text"
                        class="mt-1 block w-full border-green-500 focus:border-green-500 focus:ring-green-500 rounded shadow"
                        v-model="form.description" placeholder="Description" required />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.platformFooter ? 'Update' : 'Save' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>