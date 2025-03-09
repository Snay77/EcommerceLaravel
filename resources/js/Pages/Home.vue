<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    }
});

const limitedCategories = props.categories.slice(0, 5);
</script>

<template>
    <AppLayout>
        <Head title="Accueil" />

        <!-- Hero Section -->
        <div class="relative h-screen">
            <!-- Image de fond -->
            <div class="absolute inset-0 w-full h-full">
                <img 
                    class="w-full h-full object-cover" 
                    src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1567&q=80" 
                    alt="Voiture de luxe"
                >
                <!-- Overlay semi-transparent -->
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            </div>

            <!-- Contenu -->
            <div class="relative z-10 h-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
                    <div class="max-w-2xl">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <span class="block">Bienvenue chez</span>
                            <span class="block text-indigo-400">E-Commerce Auto</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl md:mt-5 md:text-xl">
                            Découvrez notre sélection exclusive de pièces automobiles de haute qualité. Des composants essentiels aux accessoires de personnalisation.
                        </p>
                        <div class="mt-5 sm:mt-8">
                            <Link 
                                href="/products" 
                                class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10"
                            >
                                Voir nos produits
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Nos avantages</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Pourquoi nous choisir ?
                    </p>
                </div>

                <div class="mt-10">
                    <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                        <!-- Feature 1 -->
                        <div class="relative">
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Livraison rapide</p>
                            <p class="mt-2 ml-16 text-base text-gray-500">
                                Livraison en 24/48h sur toute la France métropolitaine.
                            </p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="relative">
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Garantie qualité</p>
                            <p class="mt-2 ml-16 text-base text-gray-500">
                                Tous nos produits sont garantis et certifiés d'origine.
                            </p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="relative">
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Service client premium</p>
                            <p class="mt-2 ml-16 text-base text-gray-500">
                                Une équipe d'experts à votre écoute 7j/7.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-indigo-700">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Prêt à commencer ?</span>
                    <span class="block">Commencez vos achats dès maintenant.</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-indigo-200">
                    Découvrez notre large gamme de produits et profitez de nos offres exclusives.
                </p>
                <Link href="/products" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto">
                    Voir le catalogue
                </Link>
            </div>
        </div>
    </AppLayout>
</template>