<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    description: '',
});

const props = defineProps({
    categorySparePart: Object,
});

if (props.categorySparePart) {
    form.name = props.categorySparePart.name;
    form.description = props.categorySparePart.description;
}

const submitForm = () => {
    if (!props.categorySparePart) {
        form.post(route('store.category.spare.part'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: (errors) => {
                if (errors.name) {
                    alert('Category addition failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    } else {
        const categorySparePartId = props.categorySparePart.id;
        form.put(route('update.category.spare.part', { id: categorySparePartId }), {
            preserveScroll: true,
            onSuccess: () => form.data(),
            onError: (errors) => {
                if (errors.name) {
                    alert('Category update failed!');
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
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Name"
                        required autofocus />
                    <InputError class="mt-3" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel class="mt-3" for="description" value="Description" />
                    <textarea id="description" type="text"
                        class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                        v-model="form.description" placeholder="Description" required />
                    <InputError class="mt-3" :message="form.errors.description" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.categorySparePart ? 'Update Category Spare Part' : 'Add Category Spare Part' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.categorySparePart ? 'Category update successfully!' : 'Category added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>