<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

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
    <template #header>
      <h1>Accueil</h1>
    </template>

    <div>
      <h2>Liste des 5 premières catégories :</h2>
      <ul>
        <li v-for="category in limitedCategories" :key="category.id">
          <Link :href="`/categories/${category.id}`">{{ category.label }}</Link>
        </li>
      </ul>
    </div>
  </AppLayout>
</template>