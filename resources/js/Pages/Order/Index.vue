<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    orders: {
        type: Object,
        required: true,
    }
});

</script>

<template>
    <AppLayout>

        <Head title="Mes commandes" />
        <div>
            <h1>Vos commandes</h1>

            <div v-if="orders.data.length">
                <ul>
                    <li v-for="order in orders.data" :key="order.id">
                        <p>Commande #{{ order.id }}</p>
                        <p>Statut : {{ order.status }}</p>
                        <p>Total : {{ order.total_amount }}€</p>
                        <p>Date : {{ order.created_at }}</p>
                    </li>
                </ul>
            </div>

            <div v-else>
                <p>Aucune commande trouvée.</p>
            </div>
        </div>
    </AppLayout>
</template>