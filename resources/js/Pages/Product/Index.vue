<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    products: {
        type: Array,
        required: true,
    }
});

// console.log(props.categories)
</script>

<template>
    <AppLayout>
    <div>
      <h1>Liste des Produits</h1><br>
        <Link v-for="p in products" :key="p.id" :href="`/products/${p.id}`">
            <p>{{ p.label }}</p>
            <p>{{ p.description }}</p>
            <br>
        </Link>
    </div>
    </AppLayout>
</template>