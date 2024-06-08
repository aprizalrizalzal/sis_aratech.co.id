<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import DashboardIcon from '@/Components/Icon/DashboardIcon.vue';
import UserIcon from '@/Components/Icon/UserIcon.vue';
import CustomerIcon from '@/Components/Icon/CustomerIcon.vue';
import DeviceTypeIcon from '@/Components/Icon/DeviceTypeIcon.vue';
import DeviceIcon from '@/Components/Icon/DeviceIcon.vue';
import ServiceIcon from '@/Components/Icon/ServiceIcon.vue';
import ServiceDetailIcon from '@/Components/Icon/ServiceDetailIcon.vue';
import SparePartIcon from '@/Components/Icon/SparePartIcon.vue';
import PartUsageIcon from '@/Components/Icon/PartUsageIcon.vue';
import SidebarLink from '@/Components/SidebarLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import ImagesIcon from '@/Components/Icon/ImagesIcon.vue';

const props = defineProps({
  isVisible: {
    type: Boolean,
    default: false,
  }
});

const { auth } = usePage().props;
const userRole = ref(auth.user.role);

const isSuperAdmin = computed(() => userRole.value === 'super admin');
const isAdmin = computed(() => userRole.value === 'admin');
const isTechnician = computed(() => userRole.value === 'technician');
</script>

<template>
  <Transition enter-active-class="transition ease-out duration-150" enter-from-class="-translate-x-full"
    enter-to-class="translate-x-0" leave-active-class="transition ease-in duration-150" leave-from-class="translate-x-0"
    leave-to-class="-translate-x-full">
    <div v-show="isVisible" class="fixed flex flex-col top-0 left-0 w-60 bg-green-800 text-white h-full">
      <div class="fixed flex flex-col top-0 left-0 w-60 bg-white h-full border-r">
        <div class="flex items-center justify-left p-4 h-16 border-b">
          <Link :href="route('welcome.show.carousel')">
          <ApplicationLogo class="block h-9 w-auto fill-current" />
          </Link>
          <div class="p-4 text-sm flex items-center text-black font-bold">
            <Link :href="route('welcome.show.carousel')">
              <span>SIService-AMITech</span>
          </Link>
          </div>
        </div>
        <div class="overflow-y-auto overflow-x-hidden flex-grow">
          <ul class="flex flex-col">
            <SidebarLink :href="route('dashboard')" :active="route().current('dashboard')" label="Dashboard">
              <DashboardIcon />
            </SidebarLink>
            <div v-if="isSuperAdmin">
              <SidebarLink :href="route('show.users')" :active="route().current('show.users')" label="Users">
                <UserIcon />
              </SidebarLink>

              <SidebarLink :href="route('show.device.types')" :active="route().current('show.device.types')"
                label="Device Types">
                <DeviceTypeIcon />
              </SidebarLink>

              <SidebarLink :href="route('show.spare.parts')" :active="route().current('show.spare.parts')"
                label="Spare Parts">
                <SparePartIcon />
              </SidebarLink>

              <SidebarLink :href="route('show.carousels')" :active="route().current('show.carousels')"
                label="Carousels">
                <ImagesIcon />
              </SidebarLink>
            </div>

            <div v-if="isAdmin">
              <SidebarLink :href="route('show.customers')" :active="route().current('show.customers')"
                label="Customers">
                <CustomerIcon />
              </SidebarLink>

              <SidebarLink :href="route('show.devices')" :active="route().current('show.devices')" label="Devices">
                <DeviceIcon />
              </SidebarLink>

              <SidebarLink :href="route('show.services')" :active="route().current('show.services')" label="Services">
                <ServiceIcon />
              </SidebarLink>
            </div>

            <div v-if="isTechnician">
              <SidebarLink :href="route('show.service.details')" :active="route().current('show.service.details')"
                label="Service Details">
                <ServiceDetailIcon />
              </SidebarLink>

              <SidebarLink :href="route('show.part.usages')" :active="route().current('show.part.usages')"
                label="Part Usages">
                <PartUsageIcon />
              </SidebarLink>
            </div>
          </ul>
        </div>
      </div>
    </div>
  </Transition>
</template>
