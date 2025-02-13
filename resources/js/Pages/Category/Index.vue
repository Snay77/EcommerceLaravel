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
    <div>
      <h1>Liste des Catégories</h1><br>
        <Link v-for="c in categories" :key="c.id" :href="`/categories/${c.id}`">
            <p>{{ c.label }}</p>
            <p>{{ c.description }}</p>
            <br>
        </Link>
    </div>
    </AppLayout>
</template>