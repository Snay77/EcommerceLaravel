<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    }
});

// console.log(props.categories)
</script>

<template>
    <AppLayout>
        <Head title="Liste des Catégories" />
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Liste des Catégories</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <Link 
                        v-for="c in categories" 
                        :key="c.id" 
                        :href="route('categories.show', { category: c.slug})"
                        class="block bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300"
                    >
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ c.label }}</h2>
                            <p class="text-gray-600 mb-4">{{ c.description }}</p>
                            
                            <div class="mt-4">
                                <span class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 transition-colors duration-200">
                                    Voir la catégorie →
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>