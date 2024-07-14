<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    type: '',
    description: '',
});

const props = defineProps({
    typeFooter: Object,
});

if (props.typeFooter) {
    form.type = props.typeFooter.type;
    form.description = props.typeFooter.description;
}

const submitForm = () => {
    if (!props.typeFooter) {
        form.post(route('store.type.footer'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: (errors) => {
                if (errors.type) {
                    alert('addition failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    } else {
        const typeFooterId = props.typeFooter.id;
        form.put(route('update.type.footer', { id: typeFooterId }), {
            preserveScroll: true,
            onSuccess: () => form.data(),
            onError: (errors) => {
                if (errors.type) {
                    alert('update failed!');
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
                    <InputLabel for="type" value="Type" />
                    <TextInput id="type" type="text" class="mt-1 block w-full" v-model="form.type" placeholder="type"
                        required autofocus />
                    <InputError class="mt-2" :message="form.errors.type" />
                </div>
                <div>
                    <InputLabel class="mt-2" for="description" value="Description" />
                    <textarea id="description" type="text"
                        class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                        v-model="form.description" placeholder="Description" required />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.typeFooter ? 'Update' : 'Save' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.typeFooter ? 'update successfully!' : 'added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>