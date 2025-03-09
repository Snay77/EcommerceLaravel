<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    product: {
        type: Object,  // La catégorie est passée comme un objet
        required: true,
    },
    currentCartQuantity: {
        type: Number,
        default: 0,
    }
});

const quantity = ref(1)



// console.log(props.product);

const addToCart = () => {
    const totalQuantity = props.currentCartQuantity + quantity.value;

    if (totalQuantity > props.product.stock) {
        alert("La quantité totale demandée dépasse le stock disponible.");
        return;
    }

    router.post(route('cart.add', { product: props.product.slug }), {
        quantity: quantity.value
    },
        {
            preserveScroll: true,
            onSuccess: () => {
                alert("Produit ajouté au panier")
            },
            onError: (errors) => {
                if (errors.quantity) {
                    alert(errors.quantity)
                }
            }
        })
}
</script>

<template>
    <AppLayout>

        <Head :title="product.label" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Bouton retour -->
                <div class="mb-6">
                    <Link href="/products" class="text-indigo-600 hover:text-indigo-500 flex items-center gap-2">
                    ← Retour aux produits
                    </Link>
                </div>

                <!-- Détails du produit -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="md:flex">
                        <!-- Image du produit -->
                        <div class="md:w-1/2">
                            <img src="https://media.istockphoto.com/id/1401806376/fr/photo/bmw-m3-bleue.jpg?s=612x612&w=0&k=20&c=hebH5hQR9UZpUzWFkE5Fz5qZbxlS_bwFCL5IoOGbSiE="
                                alt="Image du produit" class="w-full h-96 object-cover" />
                        </div>

                        <!-- Informations du produit -->
                        <div class="p-8 md:w-1/2">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ product.label }}</h1>

                            <div class="mb-6">
                                <p class="text-gray-600 text-lg leading-relaxed">{{ product.description }}</p>
                            </div>

                            <div class="flex justify-between items-center mb-8">
                                <div class="text-2xl font-bold text-indigo-600">{{ product.price }} €</div>
                                <div class="text-gray-600">
                                    Stock: <span class="font-semibold">{{ product.stock }}</span>
                                </div>
                            </div>

                            <!-- Sélection de la quantité -->
                            <div class="mb-4">
                                <label for="quantity" class="block text-gray-700 font-semibold mb-2">Quantité</label>
                                <input type="number" id="quantity" v-model="quantity" :max="product.stock" :min="1" class="border rounded px-3 py-2 w-20" />
                                <p class="text-sm text-gray-500 mt-1">Stock disponible: {{ product.stock }}</p>
                                <p class="text-sm text-gray-500 mt-1">Dans le panier: {{ currentCartQuantity }}</p>
                            </div>

                            <!-- Bouton Ajouter au panier -->
                            <button @click="addToCart()"
                                class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-500 transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                                Ajouter au panier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>