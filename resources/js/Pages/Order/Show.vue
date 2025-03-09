<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    order: {
        type: Object,
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
</script>

<template>
    <AppLayout>
        <Head title="Détails de la commande" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Commande #{{ order.id }}</h1>
                    <Link 
                        href="/orders"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700"
                    >
                        Retour aux commandes
                    </Link>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Passée le {{ order.created_at }}</p>
                            </div>
                            <div :class="['px-3 py-1 rounded-full text-sm font-medium', getStatusColor(order.status)]">
                                {{ getStatusLabel(order.status) }}
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h2 class="text-xl font-semibold">Produits commandés</h2>
                                <ul class="space-y-2 mt-2">
                                    <li v-for="product in order.product" :key="product.id" class="flex justify-between">
                                        <div class="space-x-4">
                                            <span class="font-medium">{{ product.name }}</span>
                                            <span class="text-gray-500">x {{ product.pivot.quantity }}</span>
                                        </div>
                                        <span class="font-semibold">{{ product.pivot.price }} €</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-6">
                                <h2 class="text-xl font-semibold">Adresse de livraison</h2>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Adresse : {{ order.shippingadresse.street }}</p>
                                    <p class="text-sm text-gray-500">Code postal : {{ order.shippingadresse.postcode }}</p>
                                    <p class="text-sm text-gray-500">Ville : {{ order.shippingadresse.city }}</p>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between items-center">
                                <div>
                                    <p class="text-lg font-semibold">Total : {{ order.total_amount }} €</p>
                                </div>
                                <Link 
                                    :href="route('orders.index')" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700"
                                >
                                    Retourner à la liste des commandes
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
