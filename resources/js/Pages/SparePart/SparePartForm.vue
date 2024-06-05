<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    price: '',
});

const props = defineProps({
    sparePart: Object,
});

if (props.sparePart) {
    form.name = props.sparePart.name;
    form.price = props.sparePart.price;
}

const submitForm = () => {
    if (!props.sparePart) {
        form.post(route('store.spare.part'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: (errors) => {
                if (errors.name || errors.price) {
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
            onSuccess: () => form.data(),
            onError: (errors) => {
                if (errors.name || errors.price) {
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
                <div>
                    <InputLabel class="mt-3" for="name" value="Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Name"
                        required autofocus />
                    <InputError class="mt-3" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel class="mt-3" for="price" value="Price" />
                    <TextInput id="price" type="text" class="mt-1 block w-full" v-model="form.price" placeholder="Price"
                        required autofocus />
                    <InputError class="mt-3" :message="form.errors.price" />
                </div>
                <div>
                    <PrimaryButton class="mt-3">
                        {{ props.sparePart ? 'Update Spare Part' : 'Add Spare Part' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.sparePart ? 'Spare Part update successfully!' : 'Spare Part added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>