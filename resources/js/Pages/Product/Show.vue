<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    product: {
        type: Object,  // La catégorie est passée comme un objet
        required: true,
    }
});

// console.log(props.product);
</script>

<template>
  <AppLayout>
  <div>
    <h1>Détails du Produits</h1>
    <br>
    <div>
      <h2>Nom : {{ product.label }}</h2>
      <p>Description : {{ product.description }}</p>
    <br>
    <Link href="/products">Retour à la liste des catégories</Link>
    </div>
  </div>
  </AppLayout>
</template>