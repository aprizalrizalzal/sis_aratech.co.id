<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CardButton from '@/Components/CardButton.vue';
import ImagesIcon from '@/Components/Icon/ImagesIcon.vue';
import Modal from '@/Components/Modal.vue';
import HeaderForm from '@/Pages/Setting/Header/HeaderForm.vue';
import CarouselForm from '@/Pages/Setting/Carousel/CarouselForm.vue';
import FooterForm from '@/Pages/Setting/Footer/FooterForm.vue';
import DangerButton from '@/Components/DangerButton.vue';
import CarouselTable from './Carousel/CarouselTable.vue';
import FooterTable from './Footer/FooterTable.vue';
import HeaderTable from './Header/HeaderTable.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
  carousels: Array
});

const showModalAddHeader = ref(false);
const showModalAddCarousel = ref(false);
const showModalAddFooter = ref(false);

</script>

<template>

  <Head title="Setting" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
          <h2 class="font-bold my-4">Setting Header</h2>
          <HeaderTable :headers="$page.props.headers" />
          <div class="flex flex-col my-2 items-start">
            <PrimaryButton v-if="!$page.props.headers || $page.props.headers.length === 0"
              @click="showModalAddHeader = true" class="w-full">Add Header
            </PrimaryButton>
          </div>
        </div>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
          <h2 class="font-bold my-4">Setting Carousel</h2>
          <div class="flex flex-col my-2 items-start">
            <PrimaryButton @click="showModalAddCarousel = true" class="w-full">Add Carousel
            </PrimaryButton>
          </div>
          <CarouselTable :carousels="props.carousels" />
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
          <h2 class="font-bold my-4">Setting Footer</h2>
          <FooterTable :footers="$page.props.footers" />
          <div class="flex flex-col my-2 items-start">
            <PrimaryButton @click="showModalAddFooter = true" class="w-full">Add Footer
            </PrimaryButton>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <Modal v-model:show="showModalAddHeader">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddHeader = false">X</DangerButton>
      </div>
      <HeaderForm />
    </div>
  </Modal>

  <Modal v-model:show="showModalAddCarousel">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddCarousel = false">X</DangerButton>
      </div>
      <CarouselForm />
    </div>
  </Modal>

  <Modal v-model:show="showModalAddFooter">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddFooter = false">X</DangerButton>
      </div>
      <FooterForm />
    </div>
  </Modal>
</template>
