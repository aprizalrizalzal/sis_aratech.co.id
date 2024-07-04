<script setup>
import { ref, computed, watchEffect } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomerIcon from '@/Components/Icon/CustomerIcon.vue';
import DisplayIcon from '@/Components/Icon/DisplayIcon.vue';
import LaptopIcon from '@/Components/Icon/LaptopIcon.vue';
import ServiceIcon from '@/Components/Icon/ServiceIcon.vue';
import ServiceDetailIcon from '@/Components/Icon/ServiceDetailIcon.vue';
import SparePartIcon from '@/Components/Icon/SparePartIcon.vue';
import PartUsageIcon from '@/Components/Icon/PartUsageIcon.vue';
import Modal from '@/Components/Modal.vue';
import CardButton from '@/Components/CardButton.vue';
import CustomerForm from '@/Pages/Customer/CustomerForm.vue';
import DeviceTypeForm from '@/Pages/DeviceType/DeviceTypeForm.vue';
import DeviceForm from '@/Pages/Device/DeviceForm.vue';
import ServiceForm from '@/Pages/Service/ServiceForm.vue';
import ServiceDetailForm from '@/Pages/ServiceDetail/ServiceDetailForm.vue';
import SparePartForm from '@/Pages/SparePart/SparePartForm.vue';
import PartUsageForm from '@/Pages/PartUsage/PartUsageForm.vue';
import DangerButton from '@/Components/DangerButton.vue';
import LineChart from '@/Components/LineChart.vue';
import SearchInput from '@/Components/SearchInput.vue';
import DateTimePicker from '@/Components/DateTimePicker.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const showModalAddCustomer = ref(false);
const showModalAddDeviceType = ref(false);
const showModalAddDevice = ref(false);
const showModalAddService = ref(false);
const showModalAddServiceDetail = ref(false);
const showModalAddSparePart = ref(false);
const showModalAddPartUsage = ref(false);

const props = defineProps({
  users: Array,
  deviceTypes: Array,
  spareParts: Array,
  customers: Array,
  devices: Array,
  services: Array,
  serviceDetails: Array,
  partUsages: Array,
});

const { auth } = usePage().props;
const userId = ref(auth.user.id);
const roles = ref(auth.roles);
const hasRole = (role) => roles.value.includes(role);

const isSuperAdmin = computed(() => hasRole('super-admin'));
const isAdmin = computed(() => hasRole('admin'));
const isUser = computed(() => hasRole('user'));

const start_date_line_chart = ref('');
const end_date_line_chart = ref('');

const defaultStartDate = new Date();
defaultStartDate.setDate(defaultStartDate.getDate() - 30);
const defaultEndDate = new Date();

// Add unique keys for DateTimePickers
const datePickerKeys = ref({
    startDate: 0,
    endDate: 0,
});

const resetDateLineChartFilters = () => {
  start_date_line_chart.value = defaultStartDate;
  end_date_line_chart.value = defaultEndDate;

  // Update the keys to force re-render
  datePickerKeys.value.startDate += 1;
  datePickerKeys.value.endDate += 1;
};

start_date_line_chart.value = defaultStartDate;
end_date_line_chart.value = defaultEndDate;

let filteredDateLineChart = ref({});
let lableCharts = ref([
  'Users',
  'Device Types',
  'Spare Parts',
  'Customers',
  'Devices',
  'Services',
  'Service Details',
  'Part Usages'
]);

const updateLableCharts = () => {
  if (isSuperAdmin.value) {
    lableCharts.value = [
      'Users',
      'Device Types',
      'Spare Parts',
      'Customers',
      'Devices',
      'Services',
      'Service Details',
      'Part Usages'
    ];
  } else if (isAdmin.value) {
    lableCharts.value = [
      'Customers',
      'Devices',
      'Services',
      'Service Details',
    ];
  } else if (isUser.value) {
    lableCharts.value = [
      'Services',
      'Service Details',
      'Part Usages'
    ];
  } else {
    // Default to the original labelCharts if no role matches
    lableCharts.value = [
      'Users',
      'Device Types',
      'Spare Parts',
      'Customers',
      'Devices',
      'Services',
      'Service Details',
      'Part Usages'
    ];
  }
};
let dataCharts = ref([]);

const computeFilteredDateLineChart = () => {
  let filteredDataLineChart = {};

  if (start_date_line_chart.value && end_date_line_chart.value) {
    // Filter untuk semua entitas
    filteredDataLineChart = {
      users: props.users.filter(user => {
        const createdDate = new Date(user.created_at);
        const start = new Date(start_date_line_chart.value);
        const end = new Date(end_date_line_chart.value);
        return createdDate >= start && createdDate <= end;
      }),
      deviceTypes: props.deviceTypes.filter(deviceType => {
        const createdDate = new Date(deviceType.created_at);
        const start = new Date(start_date_line_chart.value);
        const end = new Date(end_date_line_chart.value);
        return createdDate >= start && createdDate <= end;
      }),
      spareParts: props.spareParts.filter(sparePart => {
        const createdDate = new Date(sparePart.created_at);
        const start = new Date(start_date_line_chart.value);
        const end = new Date(end_date_line_chart.value);
        return createdDate >= start && createdDate <= end;
      }),
      customers: props.customers.filter(customer => {
        const createdDate = new Date(customer.created_at);
        const start = new Date(start_date_line_chart.value);
        const end = new Date(end_date_line_chart.value);
        return createdDate >= start && createdDate <= end;
      }),
      devices: props.devices.filter(device => {
        const createdDate = new Date(device.created_at);
        const start = new Date(start_date_line_chart.value);
        const end = new Date(end_date_line_chart.value);
        return createdDate >= start && createdDate <= end;
      }),
      services: props.services.filter(service => {
        const createdDate = new Date(service.created_at);
        const start = new Date(start_date_line_chart.value);
        const end = new Date(end_date_line_chart.value);
        return createdDate >= start && createdDate <= end;
      }),
      serviceDetails: props.serviceDetails.filter(serviceDetail => {
        const createdDate = new Date(serviceDetail.created_at);
        const start = new Date(start_date_line_chart.value);
        const end = new Date(end_date_line_chart.value);
        return createdDate >= start && createdDate <= end;
      }),
      partUsages: props.partUsages.filter(partUsage => {
        const createdDate = new Date(partUsage.created_at);
        const start = new Date(start_date_line_chart.value);
        const end = new Date(end_date_line_chart.value);
        return createdDate >= start && createdDate <= end;
      }),
    };
  } else {
    // Jika tidak ada rentang tanggal yang dipilih, gunakan semua data
    filteredDataLineChart = {
      users: props.users,
      deviceTypes: props.deviceTypes,
      spareParts: props.spareParts,
      customers: props.customers,
      devices: props.devices,
      services: props.services,
      serviceDetails: props.serviceDetails,
      partUsages: props.partUsages,
    };
  }

  // Return array with lengths of filtered data for each category
  return filteredDataLineChart;
};

const updateDataCharts = () => {
  if (isSuperAdmin.value) {
    dataCharts.value = [
      filteredDateLineChart.value.users.length, // Users
      filteredDateLineChart.value.deviceTypes.length, // Device Types
      filteredDateLineChart.value.spareParts.length, // Spare Parts
      filteredDateLineChart.value.customers.length, // Customers
      filteredDateLineChart.value.devices.length, // Devices
      filteredDateLineChart.value.services.length, // Services
      filteredDateLineChart.value.serviceDetails.length, // Service Details
      filteredDateLineChart.value.partUsages.length, // Part Usages
    ];
  } else if (isAdmin.value) {
    dataCharts.value = [
      filteredDateLineChart.value.customers.length, // Customers
      filteredDateLineChart.value.devices.length, // Devices
      filteredDateLineChart.value.services.length, // Services
      filteredDateLineChart.value.serviceDetails.length, // Service Details
    ];
  } else if (isUser.value) {
    dataCharts.value = [
      filteredDateLineChart.value.services.length, // Services
      filteredDateLineChart.value.serviceDetails.length, // Service Details
      filteredDateLineChart.value.partUsages.length, // Part Usages
    ];
  } else {
    // Default to empty data charts array if no role matches
    dataCharts.value = [];
  }
};

watchEffect(() => {
  filteredDateLineChart.value = computeFilteredDateLineChart();
  updateLableCharts();
  updateDataCharts();
});

const customerUserIdServiceDetails = computed(() => {
  return props.serviceDetails.filter(serviceDetail => serviceDetail.service.customer.user_id === userId.value);
});

const serviceDetailIdPartUsages = computed(() => {
  return props.partUsages.filter(partUsage => partUsage.service_detail_id === 2);
});

const searchQuery = ref('');

const filteredServiceDetails = computed(() => {
  if (!searchQuery.value) {
    return customerUserIdServiceDetails.value;
  }
  return customerUserIdServiceDetails.value.filter(serviceDetail =>
    serviceDetail.service_detail_code.toString().toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.user.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.service_code.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.customer.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.customer.user.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.customer.phone.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.customer.address.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.device.device_type.type_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.device.model.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.device.serial_number.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.status_warranty.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.date_received.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.estimated_completion.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.problem_description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.items_brought.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.status.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.repair_description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||

    serviceDetail.cost.toString().toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.notes.toString().toLowerCase().includes(searchQuery.value.toLowerCase()) 
  );
});

const start_date = ref('');
const end_date = ref('');

start_date.value = defaultStartDate;
end_date.value = defaultEndDate;

const resetDateFilters = () => {
    start_date.value = defaultStartDate;
    end_date.value = defaultEndDate;

    // Update the keys to force re-render
    datePickerKeys.value.startDate += 1;
    datePickerKeys.value.endDate += 1;
};

const filteredDateServiceDetails = computed(() => {
  let serviceDetails = filteredServiceDetails.value;

  if (start_date.value || end_date.value) {
    serviceDetails = serviceDetails.filter(serviceDetail => {
      const createdAt = new Date(serviceDetail.created_at);
      const start = start_date.value ? new Date(start_date.value) : null;
      const end = end_date.value ? new Date(end_date.value) : null;

      if (start && end) {
        return createdAt >= start && createdAt <= end;
      } else if (start) {
        return createdAt >= start;
      } else if (end) {
        return createdAt <= end;
      }

      return true;
    });
  }

  return serviceDetails;
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const serviceDetailTotal = computed(() => {
    const sparePartsTotal = serviceDetailIdPartUsages.value.reduce((total, partUsage) => {
      const price = parseFloat(partUsage.spare_part.price);
      return total + (isNaN(price) ? 0 : price);
    }, 0);

    const serviceCost = customerUserIdServiceDetails.value.reduce((total, serviceDetail) => {
      const coast = parseFloat(serviceDetail.cost);
      return total + (isNaN(coast) ? 0 : coast);
    }, 0);

    const total = sparePartsTotal + serviceCost

    return total;
});

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedServiceDetails = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredDateServiceDetails.value.slice(start, end);
});

const totalPages = computed(() => {
  return Math.ceil(filteredDateServiceDetails.value.length / itemsPerPage);
});

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};
</script>

<template>

  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-lg text-green-800 leading-tight flex-none px-2 py-4">Dashboard</h2>
        </div>
        <div v-if="!isSuperAdmin && !isAdmin && !isUser" class="flex items-center">
          <SearchInput v-model:searchQuery="searchQuery" />
        </div>
      </div>

    </template>
    <div class="flex">
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="overflow-hidden sm:rounded-md">
            <!-- Your main content here -->
            <div class="grid grid-cols-1 gap-4 items-center">
              <div v-if="isSuperAdmin" class="grid grid-cols-1 sm:grid-cols-3 gap-4 m-4">
                <CardButton @click="showModalAddDeviceType = true" title="Add Device Type"
                  description="Menambahkan jenis perangkat baru ke sistem."
                  :tags="['jenis perangkat', 'kategori', 'spesifikasi']">
                  <template #svg>
                    <DisplayIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showModalAddSparePart = true" title="Add Spare Part"
                  description="Menambahkan suku cadang baru ke inventaris."
                  :tags="['suku cadang', 'inventaris', 'stok']">
                  <template #svg>
                    <SparePartIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
              </div>
              <hr v-if="isSuperAdmin">
              <div v-if="isAdmin" class="grid grid-cols-1 sm:grid-cols-3 gap-4 m-4">
                <CardButton @click="showModalAddCustomer = true" title="Add Customer"
                  description="Mendaftarkan pelanggan baru." :tags="['pelanggan', 'registrasi', 'kontak']">
                  <template #svg>
                    <CustomerIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showModalAddDevice = true" title="Add Device"
                  description="Menambahkan perangkat baru ke sistem." :tags="['perangkat', 'registrasi', 'inventaris']">
                  <template #svg>
                    <LaptopIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showModalAddService = true" title="Add Service"
                  description="Mencatat entri layanan baru." :tags="['layanan', 'entri', 'perbaikan']">
                  <template #svg>
                    <ServiceIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
              </div>
              <hr v-if="isAdmin">
              <div v-if="isUser" class="grid grid-cols-1 sm:grid-cols-3 gap-4 m-4">
                <CardButton @click="showModalAddServiceDetail = true" title="Add Service Detail"
                  description="Menambahkan detail tambahan untuk layanan."
                  :tags="['detail layanan', 'catatan', 'spesifikasi']">
                  <template #svg>
                    <ServiceDetailIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showModalAddPartUsage = true" title="Add Part Usage"
                  description="Mendokumentasikan penggunaan suku cadang selama perbaikan."
                  :tags="['penggunaan suku cadang', 'dokumentasi', 'perbaikan']">
                  <template #svg>
                    <PartUsageIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
              </div>
              <hr v-if="isUser">
              <div v-if="isSuperAdmin || isAdmin || isUser"
                class="flex flex-col gap-2 px-8 items-center bg-white shadow-md rounded-md p-4 my-4 ">
                <div class="flex w-full gap-2 justify-between overflow-x-auto">
                  <div class="flex items-center gap-2 bg-white">
                    <DateTimePicker :key="datePickerKeys.startDate" id="start_date_line_chart" label="Start Date" v-model="start_date_line_chart"
                          placeholder="Select Start Date Time" />
                      <DateTimePicker :key="datePickerKeys.endDate" id="end_date_line_chart" label="End Date" v-model="end_date_line_chart"
                          placeholder="Select End Date Time" />
                  </div>
                  <div class="my-auto me-2">
                    <PrimaryButton @click="resetDateLineChartFilters"><span class="py-1 px-3">Reset</span>
                    </PrimaryButton>
                  </div>
                </div>
                <LineChart :lableCharts="lableCharts" :dataCharts="dataCharts" />
              </div>
              <div v-if="!isSuperAdmin && !isAdmin && !isUser" class="bg-white shadow-md rounded-md p-4 my-4">
                <div class="overflow-x-auto">
                  <div class="flex w-full gap-2 justify-between my-4">
                    <div class="flex items-center gap-2 bg-white">
                      <DateTimePicker :key="datePickerKeys.startDate" id="start_date" label="Start Date" v-model="start_date"
                          placeholder="Select Start Date Time" />
                      <DateTimePicker :key="datePickerKeys.endDate" id="end_date" label="End Date" v-model="end_date"
                          placeholder="Select End Date Time" />
                    </div>
                    <div class="my-auto">
                      <PrimaryButton @click="resetDateFilters"><span class="py-1 px-3">Reset</span></PrimaryButton>
                    </div>
                  </div>
                  <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border-collapse">
                        <thead>
                            <tr>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Detail Code</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Email Technician</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Code</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Name</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Email</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Phone</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Address</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Device Type</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Model</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Serial Number</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Warranty Status</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Date Received</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Estimated Completion</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Problem Description </th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Items Brought </th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Status</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Repair Description</th>
                                <!-- <th class="py-4 px-4 border-b border-green-300 bg-green-300">Spare Part</th> -->
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Cost</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300">Notes</th>
                                <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(serviceDetail, index) in paginatedServiceDetails" :key="serviceDetail.id"
                                class="hover:bg-green-50">
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                                    index + 1 }}</td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service_detail_code }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.user.email }}</td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.service_code }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">
                                    {{ serviceDetail.service.customer.user.name }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">
                                    {{ serviceDetail.service.customer.user.email }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.customer.phone
                                    }}</td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">
                                    {{ serviceDetail.service.customer.address }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{
                                  serviceDetail.service.device.device_type.type_name }}</td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{
                                    serviceDetail.service.device.model }}</td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{
                                    serviceDetail.service.device.serial_number }}</td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.status_warranty }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.date_received }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.estimated_completion }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.problem_description }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.items_brought }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.status }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.repair_description }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ formatCurrency(serviceDetail.cost) }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.notes }}
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">
                                    <a :href="route('service.detail.print', { service_detail_code: serviceDetail.service_detail_code })"
                                        target="_blank"
                                        class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Print
                                    </a>
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">
                                    <SecondaryButton @click="showModalServiceDetailUpdate(serviceDetail)" class="m-2">Update
                                    </SecondaryButton>
                                </td>
                                <td class="py-2 px-4 border-b border-green-300 text-center">
                                    <DangerButton @click="confirmServiceDetailDeletion(serviceDetail.id)" class="m-2">Delete
                                    </DangerButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                  <div class="flex justify-center gap-4 items-center p-6">
                    <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
                    <span>Page {{ currentPage }} of {{ totalPages }}</span>
                    <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

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
