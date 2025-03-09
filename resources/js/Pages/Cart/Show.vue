<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    cart: {
        type: Object,
        required: true
    },
    total: {
        type: Number,
        required: true
    }
});

const total = ref(props.total);  // Référence pour le total
console.log(total)

// Recalcule le total chaque fois qu'il y a un changement dans le panier
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
</script>

<template>
    <AppLayout>

        <Head title="Mon Panier" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon Panier</h1>

                <div v-if="cart.product && cart.product.length > 0" class="bg-white rounded-lg shadow-md">
                    <!-- Items du panier -->
                    <div class="divide-y divide-gray-200">
                        <div v-for="item in cart.product" :key="item.id" class="p-6">
                            <div class="flex items-center space-x-4">
                                <img :src="item.cover_image" alt="" class="w-20 h-20 object-cover rounded">
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

                    <!-- Total -->
                    <div class="p-6 bg-gray-50 border-t">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold">Total</span>
                            <span class="text-2xl font-bold text-indigo-600">
                                {{ total }} €
                            </span>
                        </div>
                    </div>
                </div>


                <div v-else class="text-center py-12 bg-gray-50 rounded-lg">
                    <p class="text-gray-600">Votre panier est vide</p>
                    <Link href="/products" class="mt-4 inline-block text-indigo-600 hover:text-indigo-500">
                    Continuer mes achats →
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>