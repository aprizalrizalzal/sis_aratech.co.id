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

const showingModalAddCustomer = ref(false);
const showingModalAddDeviceType = ref(false);
const showingModalAddDevice = ref(false);
const showingModalAddService = ref(false);
const showingModalAddServiceDetail = ref(false);
const showingModalAddSparePart = ref(false);
const showingModalAddPartUsage = ref(false);

const props = defineProps({
  users: Array,
  deviceTypes: Array,

  categorySpareParts: Array,

  spareParts: Array,

  customers: Array,
  devices: Array,

  statusWarrantyServices: Array,
  statusServices: Array,

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

const serviceByUserId = computed(() => {
  return props.services.filter(service => service.customer.user_id === userId.value);
});

const searchQuery = ref('');

const filteredServices = computed(() => {
  if (!searchQuery.value) {
    return serviceByUserId.value;
  }
  return serviceByUserId.value.filter(service =>
    service.service_code.toLowerCase().includes(searchQuery.value.toLowerCase())
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

const filteredDateServices = computed(() => {
  let services = filteredServices.value;

  if (start_date.value || end_date.value) {
    services = services.filter(service => {
      const createdAt = new Date(service.created_at);
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

  return services;
});

const serviceDetailByServiceCode = computed(() => {
  // Ambil service_code dari hasil pertama dari serviceByUserId.value (jika ada)
  const serviceCode = serviceByUserId.value.length > 0 ? serviceByUserId.value[0].service_code : null;

  if (serviceCode) {
    // Filter serviceDetails berdasarkan service_code yang diambil dari serviceByUserId
    return props.serviceDetails.filter(serviceDetail => serviceDetail.service.service_code === serviceCode);
  } else {
    return [];
  }
});

const serviceDetail = serviceDetailByServiceCode.value[0];

const partUsagesByServiceDetailId = computed(() => {
  // Ambil service_detail_code dari hasil pertama dari serviceDetailByServiceCode.value (jika ada)
  const serviceDetailId = serviceDetailByServiceCode.value.length > 0 ? serviceDetailByServiceCode.value[0].id : null;

  if (serviceDetailId) {
    // Filter partUsages berdasarkan service_detail_code yang diambil dari serviceDetailByServiceCode
    return props.partUsages.filter(partUsage => partUsage.service_detail_id === serviceDetailId);
  } else {
    return [];
  }
});

const partUsages = partUsagesByServiceDetailId.value;

const serviceDetailTotal = computed(() => {
  const sparePartsTotal = partUsages.reduce((total, partUsage) => {
    const price = parseFloat(partUsage.spare_part.price);
    return total + (isNaN(price) ? 0 : price);
  }, 0);

  const coast = parseFloat(serviceDetail.cost);

  const total = sparePartsTotal + coast

  return total;
});

const showingModalServiceDetailByServiceCode = ref(false);
const selectedServiceCode = ref(null);

const showModalServiceDetailByServiceCode = (service) => {
  selectedServiceCode.value = service.service_code;
  showingModalServiceDetailByServiceCode.value = true;
};

const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedServices = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredDateServices.value.slice(start, end);
});

const totalPages = computed(() => {
  return Math.ceil(filteredDateServices.value.length / itemsPerPage);
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

const showingModalAddDeviceTypeSuccessfully = ref(false);

const showModalAddDeviceTypeSuccessfully = () => {
  showingModalAddDeviceType.value = false;
  showingModalAddDeviceTypeSuccessfully.value = true;
};

const closeModalAddDeviceTypeSuccessfully = () => {
  showingModalAddDeviceTypeSuccessfully.value = false;
};

const showingModalAddSparePartSuccessfully = ref(false);

const showModalAddSparePartSuccessfully = () => {
  showingModalAddSparePart.value = false;
  showingModalAddSparePartSuccessfully.value = true;
};

const closeModalAddSparePartSuccessfully = () => {
  showingModalAddSparePartSuccessfully.value = false;
};

const showingModalAddCustomerSuccessfully = ref(false);

const showModalAddCustomerSuccessfully = () => {
  showingModalAddCustomer.value = false;
  showingModalAddCustomerSuccessfully.value = true;
};

const closeModalAddCustomerSuccessfully = () => {
  showingModalAddCustomerSuccessfully.value = false;
};

const showingModalAddDeviceSuccessfully = ref(false);

const showModalAddDeviceSuccessfully = () => {
  showingModalAddDevice.value = false;
  showingModalAddDeviceSuccessfully.value = true;
};

const closeModalAddDeviceSuccessfully = () => {
  showingModalAddDeviceSuccessfully.value = false;
};

const showingModalAddServiceSuccessfully = ref(false);

const showModalAddServiceSuccessfully = () => {
  showingModalAddService.value = false;
  showingModalAddServiceSuccessfully.value = true;
};

const closeModalAddServiceSuccessfully = () => {
  showingModalAddServiceSuccessfully.value = false;
};

const showingModalAddServiceDetailSuccessfully = ref(false);

const showModalAddServiceDetailSuccessfully = () => {
  showingModalAddServiceDetail.value = false;
  showingModalAddServiceDetailSuccessfully.value = true;
};

const closeModalAddServiceDetailSuccessfully = () => {
  showingModalAddServiceDetailSuccessfully.value = false;
};

const showingModalAddPartUsageSuccessfully = ref(false);

const showModalAddPartUsageSuccessfully = () => {
  showingModalAddPartUsage.value = false;
  showingModalAddPartUsageSuccessfully.value = true;
};

const closeModalAddPartUsageSuccessfully = () => {
  showingModalAddPartUsageSuccessfully.value = false;
};

const closeModal = () => {
  showingModalAddDeviceType.value = false;
  showingModalAddSparePart.value = false;
  showingModalAddCustomer.value = false;
  showingModalAddDevice.value = false;
  showingModalAddService.value = false;
  showingModalAddServiceDetail.value = false;
  showingModalAddPartUsage.value = false;
  showingModalServiceDetailByServiceCode.value = false;
};
</script>

<template>

  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center gap-4 px-2">
        <div class="flex items-center">
          <h2 class="font-semibold text-green-800 leading-tight flex-none px-2 py-4">Dashboard</h2>
        </div>
        <div v-if="!isSuperAdmin && !isAdmin && !isUser" class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for Service Code" />
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
                <CardButton @click="showingModalAddDeviceType = true" title="Add Device Type"
                  description="Menambahkan jenis perangkat baru ke sistem."
                  :tags="['jenis perangkat', 'kategori', 'spesifikasi']">
                  <template #svg>
                    <DisplayIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showingModalAddSparePart = true" title="Add Spare Part"
                  description="Menambahkan suku cadang baru ke inventaris."
                  :tags="['suku cadang', 'inventaris', 'stok']">
                  <template #svg>
                    <SparePartIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
              </div>
              <hr v-if="isSuperAdmin">
              <div v-if="isAdmin" class="grid grid-cols-1 sm:grid-cols-3 gap-4 m-4">
                <CardButton @click="showingModalAddCustomer = true" title="Add Customer"
                  description="Mendaftarkan pelanggan baru." :tags="['pelanggan', 'registrasi', 'kontak']">
                  <template #svg>
                    <CustomerIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showingModalAddDevice = true" title="Add Device"
                  description="Menambahkan perangkat baru ke sistem." :tags="['perangkat', 'registrasi', 'inventaris']">
                  <template #svg>
                    <LaptopIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showingModalAddService = true" title="Add Service"
                  description="Mencatat entri layanan baru." :tags="['layanan', 'entri', 'perbaikan']">
                  <template #svg>
                    <ServiceIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
              </div>
              <hr v-if="isAdmin">
              <div v-if="isUser" class="grid grid-cols-1 sm:grid-cols-3 gap-4 m-4">
                <CardButton @click="showingModalAddServiceDetail = true" title="Add Service Detail"
                  description="Menambahkan detail tambahan untuk layanan."
                  :tags="['detail layanan', 'catatan', 'spesifikasi']">
                  <template #svg>
                    <ServiceDetailIcon width="32" height="32" fill="#0f4d0f" />
                  </template>
                </CardButton>
                <CardButton @click="showingModalAddPartUsage = true" title="Add Part Usage"
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
                    <DateTimePicker :key="datePickerKeys.startDate" id="start_date_line_chart" label="Start Date"
                      v-model="start_date_line_chart" placeholder="Select Start Date Time" />
                    <DateTimePicker :key="datePickerKeys.endDate" id="end_date_line_chart" label="End Date"
                      v-model="end_date_line_chart" placeholder="Select End Date Time" />
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
                      <DateTimePicker :key="datePickerKeys.startDate" id="start_date" label="Start Date"
                        v-model="start_date" placeholder="Select Start Date Time" />
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
                          <th class="py-4 px-4 border-b border-green-300 bg-green-300">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(service, index) in paginatedServices" :key="service.id" class="hover:bg-green-50">
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{ (currentPage - 1) *
                              itemsPerPage +
                              index + 1 }}</td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.service_code
                            }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{ service.customer.user.name }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{ service.customer.user.email }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.customer.phone
                            }}</td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{ service.customer.address }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.device.device_type.type_name }}</td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.device.model }}</td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.device.serial_number }}</td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.status_warranty_service.status }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.date_received
                            }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.estimated_completion }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.problem_description }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{
                              service.items_brought
                            }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            {{ service.status_service.status
                            }}
                          </td>
                          <td
                            class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                            <SecondaryButton v-if="serviceDetail" @click="showModalServiceDetailByServiceCode(service)"
                             >
                              Detail
                            </SecondaryButton>
                            <p v-else class="m-2 text-green-900">
                              Contact admin
                            </p>
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

  <Modal :show="showingModalAddDeviceType">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Device Type</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <DeviceTypeForm @addDeviceType="showModalAddDeviceTypeSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddDeviceTypeSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Device Type</span>
        <DangerButton @click="closeModalAddDeviceTypeSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <p class="my-4 text-sm text-green-600">
        Adding Device Type Successfully!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddDeviceTypeSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showingModalAddSparePart">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Spare Part</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <SparePartForm :categorySpareParts="categorySpareParts" @addSparePart="showModalAddSparePartSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddSparePartSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Spare Part</span>
        <DangerButton @click="closeModalAddSparePartSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <p class="my-4 text-sm text-green-600">
        Adding Spare Parts Successfully!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddSparePartSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showingModalAddCustomer">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Customer</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <CustomerForm @addCustomer="showModalAddCustomerSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddCustomerSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Customer</span>
        <DangerButton @click="closeModalAddCustomerSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <p class="my-4 text-sm text-green-600">
        Adding Customer Successfully!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddCustomerSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showingModalAddDevice">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Device</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <DeviceForm :deviceTypes="deviceTypes" @addDevice="showModalAddDeviceSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddDeviceSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Device</span>
        <DangerButton @click="closeModalAddDeviceSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <p class="my-4 text-sm text-green-600">
        Adding Device Successfully!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddDeviceSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showingModalAddService">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Service</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <ServiceForm :customers="customers" :devices="devices" :statusWarrantyServices="statusWarrantyServices"
        :statusServices="statusServices" @addService="showModalAddServiceSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddServiceSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Service</span>
        <DangerButton @click="closeModalAddServiceSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <p class="my-4 text-sm text-green-600">
        Adding Service Successfully!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddServiceSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showingModalAddServiceDetail">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Service Detail</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <ServiceDetailForm :users="users" :services="services" :statusServices="statusServices"
        @addServiceDetail="showModalAddServiceDetailSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddServiceDetailSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Service Detail</span>
        <DangerButton @click="closeModalAddServiceDetailSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <p class="my-4 text-sm text-green-600">
        Adding Service Detail Successfully!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddServiceDetailSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showingModalAddPartUsage">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Part Usage</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <PartUsageForm :serviceDetails="serviceDetails" :spareParts="spareParts"
        @addPartUsage="showModalAddPartUsageSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddPartUsageSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Part Usage</span>
        <DangerButton @click="closeModalAddPartUsageSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <p class="my-4 text-sm text-green-600">
        Adding Part Usage Successfully!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddPartUsageSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

  <Modal :show="showingModalServiceDetailByServiceCode">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Service Details</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <table class="table-auto w-full my-2">
        <tbody>
          <tr class="font-bold bg-green-50">
            <td class=" text-green-900"> Service Detail Code </td>
            <td> {{ serviceDetail.service_detail_code }} </td>
          </tr>
          <tr>
            <td class="text-green-900">Email Technician </td>
            <td> {{ serviceDetail.user.email }} </td>
          </tr>
          <tr class="font-bold bg-green-50 ">
            <td class=" text-green-900">Service Code </td>
            <td>{{ serviceDetail.service.service_code }} </td>
          </tr>
          <tr>
            <td class=" text-green-900">Name</td>
            <td>{{ serviceDetail.service.customer.user.name }} </td>
          </tr>
          <tr>
            <td class=" text-green-900">Email / Phone</td>
            <td>{{ serviceDetail.service.customer.user.email }}<span> / </span>{{
              serviceDetail.service.customer.phone }} </td>
          </tr>
          <tr>
            <td class=" text-green-900">Address </td>
            <td>{{ serviceDetail.service.customer.address }} </td>
          </tr>
          <tr>
            <td class=" text-green-900">Device Type / Model</td>
            <td>{{ serviceDetail.service.device.device_type.type_name }}<span> / </span>{{
              serviceDetail.service.device.model }}</td>
          </tr>
          <tr>
            <td class=" text-green-900">Serial Number / Warranty Status </td>
            <td>{{ serviceDetail.service.device.serial_number }}<span> / </span>{{
              serviceDetail.service.status_warranty_service.status }} </td>
          </tr>
          <tr>
            <td class=" text-green-900">Date Received / Estimated Completion </td>
            <td>{{ serviceDetail.service.date_received }}<span> / </span>{{
              serviceDetail.service.estimated_completion }} </td>
          </tr>
          <tr>
            <td class=" text-green-900">Problem Description </td>
            <td>{{ serviceDetail.service.problem_description }} </td>
          </tr>
          <tr>
            <td class=" text-green-900">Items Brought </td>
            <td>{{ serviceDetail.service.items_brought }} </td>
          </tr>
          <tr class="font-bold bg-green-50">
            <td class=" text-green-900">Status </td>
            <td>{{ serviceDetail.service.status_service.status }} </td>
          </tr>
          <tr>
            <td class="text-green-900"> Repair Description </td>
            <td> {{ serviceDetail.repair_description }} </td>
          </tr>
          <tr class="font-bold bg-green-50">
            <td class="text-green-900"> Spare Part</td>
            <td class="text-green-900"> Price</td>
          </tr>
          <tr v-for="(partUsage, index) in partUsages" :key="partUsage.id">
            <td class="text-green-900"> {{ index + 1 }}. {{ partUsage.spare_part.name }} </td>
            <td class="text-green-900"> {{ formatCurrency(partUsage.spare_part.price) }} </td>
          </tr>
          <tr class="font-bold bg-green-50">
            <td class="text-green-900"> Cost </td>
            <td> {{ formatCurrency(serviceDetail.cost) }} </td>
          </tr>
          <tr class="font-bold">
            <td class="text-green-900"> Total </td>
            <td> {{ formatCurrency(serviceDetailTotal) }} </td>
          </tr>
        </tbody>
      </table>
      <hr>
      <div id="footer" class="my-2 text-sm/relaxed">
        <p><span class="font-bold text-green-900">Cost</span> adalah biaya jasa service. <span
            class="font-bold text-green-900">Total</span> mencakup biaya jasa dan biaya tambahan untuk Spare Part
          yang diganti jika ada.</p>
      </div>

    </div>
  </Modal>
</template>

<style scoped>
/* Custom scrollbar style for overflow-x-auto */
.overflow-x-auto::-webkit-scrollbar {
  display: none;
}

.overflow-x-auto {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
