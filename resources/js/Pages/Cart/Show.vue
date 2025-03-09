<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    cart: {
        type: Object,
        required: true
    },
    total: {
        type: Number,
        required: true
    },
    defaultAddress: {
        type: Object,
        required: false,
        default: null
    }
});

const total = ref(props.total);
console.log(total)

watch(() => props.cart, (newCart) => {
    total.value = newCart.product.reduce((sum, item) => sum + (item.pivot.quantity * item.price), 0);
}, { deep: true });

const updateQuantity = (item, quantity) => {
    router.put(route('cart.update', { item: item.slug }), {
        quantity: quantity
    }, {
        preserveScroll: true
    });
};

const removeItem = (item) => {
    if (confirm('Êtes-vous sûr de vouloir retirer ce produit du panier ?')) {
        router.delete(route('cart.remove', { item: item.slug }), {
            preserveScroll: true
        });
    }
};

const createOrder = () => {
    router.post(route('orders.store'), {}, {
        preserveScroll: true,
        onSuccess: () => {
        }
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Mon Panier" />
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon Panier</h1>

                <!-- Contenu du panier -->
                <div v-if="cart && cart.product && cart.product.length > 0" class="space-y-6">
                    <!-- Adresse de livraison -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">Adresse de livraison</h2>
                        
                        <div v-if="defaultAddress" class="mb-4">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="font-medium">{{ defaultAddress.street }}</p>
                                <p class="text-gray-600">{{ defaultAddress.postcode }} {{ defaultAddress.city }}</p>
                            </div>
                            <Link 
                                :href="route('addresses.index')"
                                class="mt-2 inline-flex text-sm text-indigo-600 hover:text-indigo-500"
                            >
                                Changer d'adresse →
                            </Link>
                        </div>
                        
                        <div v-else class="text-center py-6 bg-gray-50 rounded-lg">
                            <p class="text-gray-600 mb-4">Aucune adresse de livraison définie</p>
                            <Link 
                                :href="route('addresses.index')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition duration-150 ease-in-out"
                            >
                                Ajouter une adresse
                            </Link>
                        </div>
                    </div>

                    <!-- Liste des produits -->
                    <div class="bg-white rounded-lg shadow-md">
                        <!-- Items du panier -->
                        <div class="divide-y divide-gray-200">
                            <div v-for="item in cart.product" :key="item.id" class="p-6">
                                <div class="flex items-center space-x-4">
                                    <img :src="item.cover_image || 'https://media.istockphoto.com/id/1401806376/fr/photo/bmw-m3-bleue.jpg?s=612x612&w=0&k=20&c=hebH5hQR9UZpUzWFkE5Fz5qZbxlS_bwFCL5IoOGbSiE='" alt="" class="w-20 h-20 object-cover rounded">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold">{{ item.label }}</h3>
                                        <p class="text-gray-600">{{ item.price }} €</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center border rounded">
                                            <button @click="updateQuantity(item, item.pivot.quantity - 1)"
                                                class="px-3 py-1 hover:bg-gray-100"
                                                :disabled="item.pivot.quantity <= 1">-</button>
                                            <span class="px-3 py-1">{{ item.pivot.quantity }}</span>
                                            <button @click="updateQuantity(item, item.pivot.quantity + 1)"
                                                class="px-3 py-1 hover:bg-gray-100"
                                                :disabled="item.pivot.quantity >= item.stock">+</button>
                                        </div>
                                        <button @click="removeItem(item)" class="text-red-600 hover:text-red-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total et Bouton de de commande -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-semibold">Total</span>
                            <span class="text-2xl font-bold text-indigo-600">
                                {{ total }} €
                            </span>
                        </div>

                        <button 
                            @click="createOrder"
                            class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-500 transition-colors duration-200 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!defaultAddress"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ defaultAddress ? 'Finaliser la commande' : 'Veuillez ajouter une adresse' }}
                        </button>
                    </div>
                </div>

                <!-- Message panier vide -->
                <div v-else class="text-center py-12 bg-white rounded-lg shadow-md">
                    <div class="mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Votre panier est vide</h2>
                    <p class="text-gray-600 mb-6">Découvrez nos produits et commencez vos achats</p>
                    <Link 
                        href="/products"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition duration-150 ease-in-out"
                    >
                        Voir nos produits
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>