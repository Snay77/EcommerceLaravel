<script setup>
import { ref } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';


// Accéder aux données passées par Inertia
const { addresses } = usePage().props;

// Formulaire pour ajouter une nouvelle adresse
const form = useForm({
    street: '',
    postcode: '',
    city: '',
    is_default: false,
});

// Fonction pour soumettre le formulaire
const submitAddress = () => {
    form.post(route('addresses.store'), {
        onSuccess: () => {
            // Réinitialiser le formulaire après succès
            form.reset();
        }
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Liste des Addresses" />
        <div>
            <h1 class="text-2xl font-semibold">Mes adresses</h1>

            <!-- Liste des adresses -->
            <div class="mt-6">
                <div v-if="addresses.length > 0">
                    <ul class="space-y-4">
                        <li v-for="address in addresses" :key="address.id" class="border p-4 rounded-md">
                            <div>
                                <strong>{{ address.street }}</strong><br>
                                {{ address.city }}, {{ address.postcode }}<br>
                                <span v-if="address.is_default" class="text-green-500">Adresse par défaut</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div v-else>
                    <p>Aucune adresse enregistrée.</p>
                </div>
            </div>

            <!-- Formulaire pour ajouter une adresse -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold">Ajouter une nouvelle adresse</h2>
                <form @submit.prevent="submitAddress" class="mt-4 space-y-4">
                    <div>
                        <label for="street" class="block text-sm font-medium text-gray-700">Rue</label>
                        <input type="text" id="street" v-model="form.street"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
                    </div>
                    <div>
                        <label for="postcode" class="block text-sm font-medium text-gray-700">Code postal</label>
                        <input type="number" id="postcode" v-model="form.postcode"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                        <input type="text" id="city" v-model="form.city"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
                    </div>
                    <div>
                        <label for="is_default" class="inline-flex items-center mt-2">
                            <input type="checkbox" id="is_default" v-model="form.is_default" class="mr-2" />
                            <span>Définir comme adresse par défaut</span>
                        </label>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-md">
                        Ajouter l'adresse
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
