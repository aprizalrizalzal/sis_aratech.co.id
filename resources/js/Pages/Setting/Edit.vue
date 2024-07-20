<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import HeaderForm from './Header/HeaderForm.vue';
import CarouselForm from './Carousel/CarouselForm.vue';
import FooterForm from './Footer/FooterForm.vue';
import NoteForm from './Note/NoteForm.vue';
import DangerButton from '@/Components/DangerButton.vue';
import CarouselTable from './Carousel/CarouselTable.vue';
import FooterTable from './Footer/FooterTable.vue';
import HeaderTable from './Header/HeaderTable.vue';
import NoteTable from './Note/NoteTable.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ButtonImage from '@/Components/ButtonImage.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ToolsIcon from '@/Components/Icon/ToolsIcon.vue'

const props = defineProps({
  carousels: Array,
  typeFooters: Array,
  platformFooters: Array,
});

const showModalAddHeader = ref(false);
const showModalAddCarousel = ref(false);
const showModalAddNote = ref(false);
const showModalAddFooter = ref(false);

const showingModalAddHeaderSuccessfully = ref(false);

const showModalAddHeaderSuccessfully = () => {
  showModalAddHeader.value = false;
  showingModalAddHeaderSuccessfully.value = true;
};

const closeModalAddHeaderSuccessfully = () => {
  showingModalAddHeaderSuccessfully.value = false;
};

const showingModalAddCarouselSuccessfully = ref(false);

const showModalAddCarouselSuccessfully = () => {
  showModalAddCarousel.value = false;
  showingModalAddCarouselSuccessfully.value = true;
};

const closeModalAddCarouselSuccessfully = () => {
  showingModalAddCarouselSuccessfully.value = false;
};

const showingModalAddNoteSuccessfully = ref(false);

const showModalAddNoteSuccessfully = () => {
  showModalAddNote.value = false;
  showingModalAddNoteSuccessfully.value = true;
};

const closeModalAddNoteSuccessfully = () => {
  showingModalAddNoteSuccessfully.value = false;
};

const showingModalAddFooterSuccessfully = ref(false);

const showModalAddFooterSuccessfully = () => {
  showModalAddFooter.value = false;
  showingModalAddFooterSuccessfully.value = true;
};

const closeModalAddFooterSuccessfully = () => {
  showingModalAddFooterSuccessfully.value = false;
};

const closeModal = () => {
  showModalAddHeader.value = false;
  showModalAddCarousel.value = false;
  showModalAddNote.value = false;
  showModalAddFooter.value = false;
};

</script>

<template>

  <Head title="Setting" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
          <h2 class="font-bold my-4 text-green-600">Header</h2>
          <HeaderTable :headers="$page.props.headers" />
          <div class="flex flex-col my-2 items-start">
            <SecondaryButton v-if="!$page.props.headers || $page.props.headers.length === 0"
              @click="showModalAddHeader = true" class="w-full">Add Header
            </SecondaryButton>
          </div>
        </div>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
          <h2 class="font-bold my-4 text-green-600">Carousels</h2>
          <CarouselTable :carousels="props.carousels" />
          <div class="flex flex-col my-2 items-start">
            <SecondaryButton @click="showModalAddCarousel = true" class="w-full">Add Carousel
            </SecondaryButton>
          </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
          <h2 class="font-bold my-4 text-green-600">Notes</h2>
          <NoteTable :notes="$page.props.notes" />
          <div class="flex flex-col my-2 items-start">
            <SecondaryButton @click="showModalAddNote = true" class="w-full">Add Note
            </SecondaryButton>
          </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
          <div class="flex items-center gap-4">
            <div class="relative">
              <Dropdown align="left" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button type="button"
                      class="inline-flex items-center py-4 border border-transparent text-md leading-4 font-bold rounded-md text-green-600 bg-white hover:text-green-800 focus:outline-none transition ease-in-out duration-150">
                      Footers&nbsp;
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                          d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                      </svg>
                    </button>
                  </span>
                </template>

                <template #content>
                  <DropdownLink :href="route('show.type.footer')">Type</DropdownLink>
                  <DropdownLink :href="route('show.platform.footer')">Platform</DropdownLink>
                </template>
              </Dropdown>
            </div>
          </div>
          <FooterTable :footers="$page.props.footers" :typeFooters="typeFooters" :platformFooters="platformFooters" />
          <div class="flex flex-col my-2 items-start">
            <SecondaryButton @click="showModalAddFooter = true" class="w-full">Add Footer
            </SecondaryButton>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <Modal :show="showModalAddHeader">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Header</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <HeaderForm @addHeader="showModalAddHeaderSuccessfully"/>
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddHeaderSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Header</span>
        <DangerButton @click="closeModalAddHeaderSuccessfully">X</DangerButton>
      </div>
        <hr class="mt-4 mb-2 border-green-100">
        <p class="my-4 text-sm text-green-600">
          Header Add Successful!
        </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddHeaderSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showModalAddCarousel">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Carousel</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <CarouselForm @addCarousel="showModalAddCarouselSuccessfully"/>
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddCarouselSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Carousel</span>
        <DangerButton @click="closeModalAddCarouselSuccessfully">X</DangerButton>
      </div>
        <hr class="mt-4 mb-2 border-green-100">
        <p class="my-4 text-sm text-green-600">
          Carousel Add Successful!
        </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddCarouselSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showModalAddNote">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Note</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <NoteForm @addNote="showModalAddNoteSuccessfully"/>
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddNoteSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Note</span>
        <DangerButton @click="closeModalAddNoteSuccessfully">X</DangerButton>
      </div>
        <hr class="mt-4 mb-2 border-green-100">
        <p class="my-4 text-sm text-green-600">
          Note Add Successful!
        </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddNoteSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showModalAddFooter">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Footer</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <FooterForm :typeFooters="typeFooters" :platformFooters="platformFooters" @addFooter="showModalAddFooterSuccessfully"/>
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddFooterSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Footer</span>
        <DangerButton @click="closeModalAddFooterSuccessfully">X</DangerButton>
      </div>
        <hr class="mt-4 mb-2 border-green-100">
        <p class="my-4 text-sm text-green-600">
          Footer Add Successful!
        </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddFooterSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>
</template>
