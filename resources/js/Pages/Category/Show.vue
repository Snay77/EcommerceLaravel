<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    category: {
        type: Object,  // La catégorie est passée comme un objet
        required: true,
    }
});

// console.log(props.category);
</script>

<template>
  <AppLayout>
  <div>
    <h1>Détails de la Catégorie</h1>
    <br>
    <div>
      <h2>Nom : {{ category.label }}</h2>
      <p>Description : {{ category.description }}</p>
    <br>
    <Link href="/categories">Retour à la liste des catégories</Link>
    </div>
  </div>
  </AppLayout>
</template>