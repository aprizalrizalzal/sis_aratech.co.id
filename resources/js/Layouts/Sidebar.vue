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
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  isVisible: {
    type: Boolean,
    default: false,
  },
  userRole: String,
});
</script>

<template>
  <div :class="{ hidden: !isVisible, block: isVisible }"
    class="fixed flex flex-col top-0 left-0 w-60 bg-green-800 text-white h-full transition-transform duration-300">
    <div class="fixed flex flex-col top-0 left-0 w-60 bg-white h-full border-r">
      <div class="flex items-center justify-left p-4 h-16 border-b">
        <Link :href="route('welcome')">
        <ApplicationLogo class="block h-9 w-auto fill-current" />
        </Link>
        <div class="p-4 text-sm flex items-center text-black font-bold">
          <span>SIService-AMITech</span>
        </div>
      </div>
      <div class="overflow-y-auto overflow-x-hidden flex-grow">
        <ul class="flex flex-col">
          <SidebarLink :href="route('dashboard')" :active="route().current('dashboard')" label="Dashboard">
            <DashboardIcon />
          </SidebarLink>

          <div class="">
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
          </div>

          <div class="">
            <SidebarLink :href="route('show.customers')" :active="route().current('show.customers')" label="Customers">
              <CustomerIcon />
            </SidebarLink>

            <SidebarLink :href="route('show.devices')" :active="route().current('show.devices')" label="Devices">
              <DeviceIcon />
            </SidebarLink>

            <SidebarLink :href="route('show.services')" :active="route().current('show.services')" label="Services">
              <ServiceIcon />
            </SidebarLink>
          </div>

          <div class="">
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
</template>