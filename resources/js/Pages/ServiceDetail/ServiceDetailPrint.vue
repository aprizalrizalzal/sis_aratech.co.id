<script setup>
const props = defineProps({
    service: Object,
});
</script>
<template id="print-template">
    <table class="table-auto w-full">
        <tbody>
            <tr>
                <td class="py-2 px-4 border bg-green-50 border-green-50 text-center" >
                    Service Code
                </td>
                <td class="py-2 px-4 border bg-green-50 border-green-50 text-center" >
                    {{ service.service_code }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Customers
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.customer.name }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Phone
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.customer.phone }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Model
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.device.model }}
                </td>
            </tr>
            <tr class="font-bold text-red-900">
                <td class="py-2 px-4 border border-green-50 text-center">
                    Serial Number
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.device.serial_number }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Date Received
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.date_received }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Items Brought
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.items_brought }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Estimated Completion
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.estimated_completion }}
                </td>
            </tr>
            <tr class="font-bold text-red-900">
                <td class="py-2 px-4 border border-green-50 text-center">
                    Status
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.status }}
                </td>
            </tr>
        </tbody>
    </table>
</template>
