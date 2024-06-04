<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import CustomerIcon from '@/Components/Icon/CustomerIcon.vue';
import DeviceTypeIcon from '@/Components/Icon/DeviceTypeIcon.vue';
import DeviceIcon from '@/Components/Icon/DeviceIcon.vue';
import ServiceIcon from '@/Components/Icon/ServiceIcon.vue';
import ServiceDetailIcon from '@/Components/Icon/ServiceDetailIcon.vue';
import SparePartIcon from '@/Components/Icon/SparePartIcon.vue';
import PartUsageIcon from '@/Components/Icon/PartUsageIcon.vue';
import ModalForm from '@/Components/ModalForm.vue';
import CustomerForm from '@/Pages/Customer/CustomerForm.vue';
import DeviceTypeForm from '@/Pages/DeviceType/DeviceTypeForm.vue';
import DeviceForm from '@/Pages/Device/DeviceForm.vue';
import ServiceForm from '@/Pages/Service/ServiceForm.vue';
import ServiceDetailForm from '@/Pages/ServiceDetail/ServiceDetailForm.vue';
import SparePartForm from '@/Pages/SparePart/SparePartForm.vue';
import PartUsageForm from '@/Pages/PartUsage/PartUsageForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import LineChart from '@/Components/LineChart.vue';

const showModalAddCustomer = ref(false);
const showModalAddDeviceType = ref(false);
const showModalAddDevice = ref(false);
const showModalAddService = ref(false);
const showModalAddServiceDetail = ref(false);
const showModalAddSparePart = ref(false);
const showModalAddPartUsage = ref(false);

const props = defineProps({
  users: {
    type: Array,
    required: true
  },
  customers: {
    type: Array,
    required: true
  },
  deviceTypes: {
    type: Array,
    required: true
  },
  devices: {
    type: Array,
    required: true
  },
  services: {
    type: Array,
    required: true
  },
  serviceDetails: {
    type: Array,
    required: true
  },
  spareParts: {
    type: Array,
    required: true
  },
  partUsages: {
    type: Array,
    required: true
  }
});

</script>

<template>

  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>
    <div class="flex">
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Your main content here -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 p-4">
              <LineChart />
              <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <PrimaryButton @click="showModalAddDeviceType = true">
                  <DeviceTypeIcon /><span class="mx-2">Add Device Type </span>
                </PrimaryButton>
                <PrimaryButton @click="showModalAddSparePart = true">
                  <SparePartIcon /><span class="mx-2">Add Spare Part </span>
                </PrimaryButton>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <PrimaryButton @click="showModalAddCustomer = true">
                  <CustomerIcon /><span class="mx-2">Add Customer </span>
                </PrimaryButton>
                <PrimaryButton @click="showModalAddDevice = true">
                  <DeviceIcon /><span class="mx-2">Add Device </span>
                </PrimaryButton>
                <PrimaryButton @click="showModalAddService = true">
                  <ServiceIcon /><span class="mx-2">Add Service </span>
                </PrimaryButton>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <PrimaryButton @click="showModalAddServiceDetail = true">
                  <ServiceDetailIcon /><span class="mx-2">Add Service Detail </span>
                </PrimaryButton>
                <PrimaryButton @click="showModalAddPartUsage = true">
                  <PartUsageIcon /><span class="mx-2">Add Part Usage </span>
                </PrimaryButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <ModalForm v-model:show="showModalAddDeviceType">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddDeviceType = false">X</DangerButton>
      </div>
      <DeviceTypeForm />
    </div>
  </ModalForm>
  <ModalForm v-model:show="showModalAddSparePart">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddSparePart = false">X</DangerButton>
      </div>
      <SparePartForm />
    </div>
  </ModalForm>
  <ModalForm v-model:show="showModalAddCustomer">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddCustomer = false">X</DangerButton>
      </div>
      <CustomerForm />
    </div>
  </ModalForm>
  <ModalForm v-model:show="showModalAddDevice">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddDevice = false">X</DangerButton>
      </div>
      <DeviceForm :deviceTypes="deviceTypes" />
    </div>
  </ModalForm>
  <ModalForm v-model:show="showModalAddService">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddService = false">X</DangerButton>
      </div>
      <ServiceForm :customers="customers" :devices="devices" />
    </div>
  </ModalForm>
  <ModalForm v-model:show="showModalAddServiceDetail">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddServiceDetail = false">X</DangerButton>
      </div>
      <ServiceDetailForm :users="users" :services="services" />
    </div>
  </ModalForm>
  <ModalForm v-model:show="showModalAddPartUsage">
    <div class="m-6">
      <div class="flex justify-end">
        <DangerButton @click="showModalAddPartUsage = false">X</DangerButton>
      </div>
      <PartUsageForm :serviceDetails="serviceDetails" :spareParts="spareParts" />
    </div>
  </ModalForm>
</template>
