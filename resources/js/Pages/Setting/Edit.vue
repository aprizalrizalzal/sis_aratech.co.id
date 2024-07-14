<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import HeaderForm from '@/Pages/Setting/Header/HeaderForm.vue';
import CarouselForm from '@/Pages/Setting/Carousel/CarouselForm.vue';
import FooterForm from '@/Pages/Setting/Footer/FooterForm.vue';
import DangerButton from '@/Components/DangerButton.vue';
import CarouselTable from './Carousel/CarouselTable.vue';
import FooterTable from './Footer/FooterTable.vue';
import HeaderTable from './Header/HeaderTable.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
  carousels: Array,
  typeFooters: Array,
  platformFooters: Array,
});

const showModalAddHeader = ref(false);
const showModalAddCarousel = ref(false);
const showModalAddFooter = ref(false);

const closeModal = () => {
  showModalAddHeader.value = false;
  showModalAddCarousel.value = false;
  showModalAddFooter.value = false;
};

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
            <SecondaryButton v-if="!$page.props.headers || $page.props.headers.length === 0"
              @click="showModalAddHeader = true" class="w-full">Add Header
            </SecondaryButton>
          </div>
        </div>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
          <h2 class="font-bold my-4">Setting Carousel</h2>
          <CarouselTable :carousels="props.carousels" />
          <div class="flex flex-col my-2 items-start">
            <SecondaryButton @click="showModalAddCarousel = true" class="w-full">Add Carousel
            </SecondaryButton>
          </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
          <h2 class="font-bold my-4">Setting Footer</h2>
          <FooterTable :footers="$page.props.footers" :typeFooters="typeFooters" :platformFooters="platformFooters" />
          <div class="flex flex-col my-2 items-start">
            <SecondaryButton @click="showModalAddFooter = true" class="w-full">Add Footer
            </SecondaryButton>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <Modal :show="showModalAddHeader" @close="closeModal">
    <div class="m-6">
      <div class="flex justify-between items-center">
        <span class="font-bold text-center w-full">Add Header</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <HeaderForm />
    </div>
  </Modal>

  <Modal :show="showModalAddCarousel" @close="closeModal">
    <div class="m-6">
      <div class="flex justify-between items-center">
        <span class="font-bold text-center w-full">Add Carousel</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <CarouselForm />
    </div>
  </Modal>

  <Modal :show="showModalAddFooter" @close="closeModal">
    <div class="m-6">
      <div class="flex justify-between items-center">
        <span class="font-bold text-center w-full">Add Footer</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <FooterForm :typeFooters="typeFooters" :platformFooters="platformFooters" />
    </div>
  </Modal>
</template>
