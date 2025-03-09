<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    orders: {
        type: Array,
        required: true,
    }
});

const getStatusColor = (status) => {
    switch (status) {
        case 'pending': return 'bg-yellow-100 text-yellow-800';
        case 'processing': return 'bg-blue-100 text-blue-800';
        case 'shipped': return 'bg-green-100 text-green-800';
        case 'delivered': return 'bg-green-100 text-green-800';
        case 'cancelled': return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
};

const getStatusLabel = (status) => {
    switch (status) {
        case 'pending': return 'En attente';
        case 'processing': return 'En traitement';
        case 'shipped': return 'Expédiée';
        case 'delivered': return 'Livrée';
        case 'cancelled': return 'Annulée';
        default: return status;
    }
};

console.log(props.orders)
</script>

<template>
    <AppLayout>
        <Head title="Mes commandes" />
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Mes commandes</h1>
                    <Link 
                        href="/products" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700"
                    >
                        Continuer mes achats
                    </Link>
                </div>

                <div v-if="orders.length > 0" class="space-y-4">
                    <div v-for="order in orders" :key="order.id" 
                        class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-200"
                    >
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">
                                        Commande #{{ order.id }}
                                    </h2>
                                    <p class="text-sm text-gray-500">
                                        Passée le {{ order.created_at }}
                                    </p>
                                </div>
                                <div :class="['px-3 py-1 rounded-full text-sm font-medium', getStatusColor(order.status)]">
                                    {{ getStatusLabel(order.status) }}
                                </div>
                            </div>

                            <div class="flex justify-between items-end">
                                <div class="space-y-1">
                                    <p class="text-gray-600">
                                        Adresse de livraison :
                                    </p>
                                    <p v-if="order.shippingadresse" class="text-sm text-gray-500">
                                        {{ order.shippingadresse.street }}<br>
                                        {{ order.shippingadresse.postcode }} {{ order.shippingadresse.city }}
                                    </p>
                                    <p v-else class="text-sm text-gray-500 text-red-500">
                                        Adresse de livraison non définie
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-indigo-600">
                                        {{ order.total_amount }} €
                                    </p>
                                    <Link 
                                        :href="route('orders.show', order.id)"
                                        class="inline-flex items-center mt-2 text-sm text-indigo-600 hover:text-indigo-500"
                                    >
                                        Voir les détails
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-12 bg-white rounded-lg shadow">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune commande</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Vous n'avez pas encore passé de commande.
                    </p>
                    <div class="mt-6">
                        <Link
                            href="/products"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                        >
                            Découvrir nos produits
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
