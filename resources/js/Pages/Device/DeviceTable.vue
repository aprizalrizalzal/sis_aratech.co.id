<script setup>
import DeviceForm from '@/Pages/Device/DeviceForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import ModalForm from '@/Components/ModalForm.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  devices: {
    type: Array,
    required: true
  }
});

const showingModelDeviceUpdate = ref(false);
const selectedDevice = ref(null);
const selectedDeviceType = ref(null);

const showModalDeviceUpdate = (device) => {
  selectedDevice.value = device;
  selectedDeviceType.value = device.device_type;
  showingModelDeviceUpdate.value = true;
};

const confirmingDeviceDeletion = ref(false);

const form = useForm({
  id: null,
});

const confirmDeviceDeletion = (deviceId) => {
  confirmingDeviceDeletion.value = true;
  form.id = deviceId;
};

const deleteDevice = () => {
  form.delete(route('destroy.device'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: (errors) => {
      if (errors) {
        closeModal();
      } else {
        console.error('There was an error!', errors);
      }
    }
  });
};

const closeModal = () => {
  confirmingDeviceDeletion.value = false;
};
</script>

<style scoped>
/* Tambahkan beberapa styling dasar untuk tabel */
th,
td {
  padding: 12px;
  text-align: left;
}

th {
  background-color: #256125;
  color: white;
}

td {
  border-bottom: 1px solid #e2e8f0;
}
</style>

<template>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white border-collapse">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">#</th>
          <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Device Type</th>
          <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Model</th>
          <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Serial Number</th>
          <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(device, index) in devices" :key="device.id" class="hover:bg-gray-100">
          <td class="py-2 px-4 border-b border-gray-300">{{ index + 1 }}</td>
          <td class="py-2 px-4 border-b border-gray-300">{{ device.device_type.type_name }}</td>
          <td class="py-2 px-4 border-b border-gray-300">{{ device.model }}</td>
          <td class="py-2 px-4 border-b border-gray-300">{{ device.serial_number }}</td>
          <td class="py-2 px-4 border-b border-gray-300">
            <SecondaryButton @click="showModalDeviceUpdate(device)" class="m-2">Update</SecondaryButton>
            <DangerButton @click="confirmDeviceDeletion(device.id)" class="m-2">Delete</DangerButton>
          </td>
        </tr>
      </tbody>
    </table>
    <ModalForm v-model:show="showingModelDeviceUpdate">
      <div class="m-6">
        <div class="flex justify-end">
          <DangerButton @click="showingModelDeviceUpdate = false">X</DangerButton>
        </div>
        <DeviceForm :device="selectedDevice" :deviceType="selectedDeviceType" />
      </div>
    </ModalForm>
    <Modal :show="confirmingDeviceDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-green-900">
          Are you sure you want to delete your Device?
        </h2>

        <p class="mt-1 text-sm text-green-600">
          Once your Device is deleted, all of its resources and data will be permanently deleted.
        </p>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

          <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="deleteDevice">
            Delete Device
          </DangerButton>
        </div>
      </div>
    </Modal>

  </div>
</template>