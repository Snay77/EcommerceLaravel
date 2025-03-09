<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    products: {
        type: Object,
        required: true,
    }
});

const quantity = 1;

const addToCart = (product) => {
    if (product.stock < quantity) {
        alert("Quantité non disponible en stock !");
        return;
    }

    router.post(route('cart.add', { product: product.slug }), {
        quantity: quantity
    },
    {
        preserveScroll: true,
        onSuccess: () => {
            alert("Produit ajouté au panier");
        },
        onError: (errors) => {
            if (errors.quantity) {
                alert(errors.quantity);
            }
        }
    });
}

// console.log(props.categories)
</script>

<template>
    <AppLayout>
        <Head title="Liste des Produits" />
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Liste des Produits</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="p in products" 
                        :key="p.id" 
                        class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden"
                    >
                        <div                         >
                            <img 
                                src="https://media.istockphoto.com/id/1401806376/fr/photo/bmw-m3-bleue.jpg?s=612x612&w=0&k=20&c=hebH5hQR9UZpUzWFkE5Fz5qZbxlS_bwFCL5IoOGbSiE="
                                alt="Image du produit"
                                class="w-full h-48 object-cover"
                            />
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ p.label }}</h2>
                                <p class="text-gray-600 mb-4">{{ p.description }}</p>
                                <div class="flex justify-between items-center">
                                    <p class="text-lg font-bold text-indigo-600">{{ p.price }} €</p>
                                    <p class="text-sm text-gray-500">Stock: {{ p.stock }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Boutons d'action -->
                        <div class="px-6 pb-6 space-y-2">
                            <Link 
                                :href="route('product.show', { product: p.slug})"
                                class="w-full block text-center text-indigo-600 py-2 px-4 rounded-lg border-2 border-indigo-600 hover:bg-indigo-50 transition-colors duration-200"
                            >
                                Voir le produit →
                            </Link>

                            <button @click="addToCart(p)"
                                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-500 transition-colors duration-200 flex items-center justify-center gap-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
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