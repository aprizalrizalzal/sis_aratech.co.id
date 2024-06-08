<script setup>
import { ref, computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomerIcon from '@/Components/Icon/CustomerIcon.vue';
import ImagesIcon from '@/Components/Icon/ImagesIcon.vue';
import DeviceTypeIcon from '@/Components/Icon/DeviceTypeIcon.vue';
import DeviceIcon from '@/Components/Icon/DeviceIcon.vue';
import ServiceIcon from '@/Components/Icon/ServiceIcon.vue';
import ServiceDetailIcon from '@/Components/Icon/ServiceDetailIcon.vue';
import SparePartIcon from '@/Components/Icon/SparePartIcon.vue';
import PartUsageIcon from '@/Components/Icon/PartUsageIcon.vue';
import Modal from '@/Components/Modal.vue';
import CardButton from '@/Components/CardButton.vue';
import CustomerForm from '@/Pages/Customer/CustomerForm.vue';
import DeviceTypeForm from '@/Pages/DeviceType/DeviceTypeForm.vue';
import CarouselForm from '@/Pages/Carousel/CarouselForm.vue';
import DeviceForm from '@/Pages/Device/DeviceForm.vue';
import ServiceForm from '@/Pages/Service/ServiceForm.vue';
import ServiceDetailForm from '@/Pages/ServiceDetail/ServiceDetailForm.vue';
import SparePartForm from '@/Pages/SparePart/SparePartForm.vue';
import PartUsageForm from '@/Pages/PartUsage/PartUsageForm.vue';
import DangerButton from '@/Components/DangerButton.vue';
import LineChart from '@/Components/LineChart.vue';

const showModalAddCarousel = ref(false);
const showModalAddCustomer = ref(false);
const showModalAddDeviceType = ref(false);
const showModalAddDevice = ref(false);
const showModalAddService = ref(false);
const showModalAddServiceDetail = ref(false);
const showModalAddSparePart = ref(false);
const showModalAddPartUsage = ref(false);

const props = defineProps({
  users: Array,
  customers: Array,
  carousels: Array,
  deviceTypes: Array,
  devices: Array,
  services: Array,
  serviceDetails: Array,
  spareParts: Array,
  partUsages: Array,
});

const dataChart = [
  props.users.length,
  props.deviceTypes.length,
  props.spareParts.length,
  props.carousels.length,
  props.customers.length,
  props.devices.length,
  props.services.length,
  props.serviceDetails.length,
  props.partUsages.length,
]

const { auth } = usePage().props;
const userRole = ref(auth.user.role);

const isSuperAdmin = computed(() => userRole.value === 'super admin');
const isAdmin = computed(() => userRole.value === 'admin');
const isTechnician = computed(() => userRole.value === 'technician');

</script>

<template>

  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-green-800 leading-tight">Dashboard</h2>
    </template>
    <div class="flex">
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Your main content here -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 p-4">
              <LineChart :dataChart="dataChart" />
              <div v-if="isSuperAdmin" class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-2 ">
                <CardButton @click="showModalAddDeviceType = true" title="Add Device Type"
                  description="Menambahkan jenis perangkat baru ke sistem."
                  :tags="['jenis perangkat', 'kategori', 'spesifikasi']">
                  <template #svg>
                    <DeviceTypeIcon width="128" height="128" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showModalAddSparePart = true" title="Add Spare Part"
                  description="Menambahkan suku cadang baru ke inventaris."
                  :tags="['suku cadang', 'inventaris', 'stok']">
                  <template #svg>
                    <SparePartIcon width="128" height="128" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showModalAddCarousel = true" title="Add Carousel"
                  description="Membuat karousel baru untuk item unggulan atau promosi."
                  :tags="['karousel', 'promosi', 'unggulan']">
                  <template #svg>
                    <ImagesIcon width="128" height="128" fill="#0f4d0f" />
                  </template>
                </CardButton>
              </div>
              <div v-if="isAdmin" class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-2">
                <CardButton @click="showModalAddCustomer = true" title="Add Customer"
                  description="Mendaftarkan pelanggan baru." :tags="['pelanggan', 'registrasi', 'kontak']">
                  <template #svg>
                    <CustomerIcon width="128" height="128" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showModalAddDevice = true" title="Add Device"
                  description="Menambahkan perangkat baru ke sistem." :tags="['perangkat', 'registrasi', 'inventaris']">
                  <template #svg>
                    <DeviceIcon width="128" height="128" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showModalAddService = true" title="Add Service"
                  description="Mencatat entri layanan baru." :tags="['layanan', 'entri', 'perbaikan']">
                  <template #svg>
                    <ServiceIcon width="128" height="128" fill="#0f4d0f" />
                  </template>
                </CardButton>
              </div>
              <div v-if="isTechnician" class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-2">
                <CardButton @click="showModalAddServiceDetail = true" title="Add Service Detail"
                  description="Menambahkan detail tambahan untuk layanan."
                  :tags="['detail layanan', 'catatan', 'spesifikasi']">
                  <template #svg>
                    <ServiceDetailIcon width="128" height="128" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showModalAddPartUsage = true" title="Add Part Usage"
                  description="Mendokumentasikan penggunaan suku cadang selama perbaikan."
                  :tags="['penggunaan suku cadang', 'dokumentasi', 'perbaikan']">
                  <template #svg>
                    <PartUsageIcon width="128" height="128" fill="#0f4d0f" />
                  </template>
                </CardButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <Modal v-model:show="showModalAddCarousel">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddCarousel = false">X</DangerButton>
      </div>
      <CarouselForm />
    </div>
  </Modal>
  <Modal v-model:show="showModalAddDeviceType">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddDeviceType = false">X</DangerButton>
      </div>
      <DeviceTypeForm />
    </div>
  </Modal>
  <Modal v-model:show="showModalAddSparePart">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddSparePart = false">X</DangerButton>
      </div>
      <SparePartForm />
    </div>
  </Modal>
  <Modal v-model:show="showModalAddCustomer">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddCustomer = false">X</DangerButton>
      </div>
      <CustomerForm />
    </div>
  </Modal>
  <Modal v-model:show="showModalAddDevice">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddDevice = false">X</DangerButton>
      </div>
      <DeviceForm :deviceTypes="deviceTypes" />
    </div>
  </Modal>
  <Modal v-model:show="showModalAddService">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddService = false">X</DangerButton>
      </div>
      <ServiceForm :customers="customers" :devices="devices" />
    </div>
  </Modal>
  <Modal v-model:show="showModalAddServiceDetail">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddServiceDetail = false">X</DangerButton>
      </div>
      <ServiceDetailForm :users="users" :services="services" />
    </div>
  </Modal>
  <Modal v-model:show="showModalAddPartUsage">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddPartUsage = false">X</DangerButton>
      </div>
      <PartUsageForm :serviceDetails="serviceDetails" :spareParts="spareParts" />
    </div>
  </Modal>
</template>
