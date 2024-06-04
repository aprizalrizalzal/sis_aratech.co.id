<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UserTable from '@/Pages/User/UserTable.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  users: {
    type: Array,
    required: true
  }
});

</script>

<template>

  <Head title="Users" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </template>
    <div class="flex">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Your main content here -->
            <UserTable :users="users" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
