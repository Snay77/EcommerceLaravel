<script setup>
import { ref } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';


// Accéder aux données passées par Inertia
const { addresses } = usePage().props;

const editingAddress = ref(null);
const addingNewAddress = ref(false);


// Formulaire de mise à jour
const form = useForm({
    street: '',
    postcode: '',
    city: '',
    is_default: false,
});

// Fonction pour charger l'adresse à éditer dans le formulaire
const editAddress = (address) => {
    editingAddress.value = address;
    form.street = address.street;
    form.postcode = address.postcode;
    form.city = address.city;
    form.is_default = address.is_default;
};

// Fonction pour mettre à jour l'adresse
const updateAddress = () => {
    form.put(route('addresses.update', { address: editingAddress.value.id }), {
        onSuccess: () => {
            editingAddress.value = null; // Réinitialiser après succès
            window.location.reload();
        },
    });
};

// Fonction pour soumettre le formulaire
const submitAddress = () => {
    form.post(route('addresses.store'), {
        onSuccess: () => {
            // Réinitialiser le formulaire après succès
            form.reset();
            addingNewAddress.value = false; // Masquer le formulaire après soumission
            window.location.reload();
        },
    });
};

// Fonction pour afficher/masquer le formulaire d'ajout
const toggleAddAddressForm = () => {
    addingNewAddress.value = !addingNewAddress.value;
};

const deleteAddress = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette adresse ?')) {
        form.delete(route('addresses.delete', { address: id }), {
            onSuccess: () => {
                // Optionnel: rafraîchir la page après suppression
                window.location.reload();
            },
        });
    }
};
</script>

<template>
    <AppLayout>

        <Head title="Liste des Addresses" />
        <div>
            <h1 class="text-2xl font-semibold">Mes adresses</h1>

            <!-- Bouton pour ajouter une nouvelle adresse -->
            <button @click="toggleAddAddressForm" class="mt-4 bg-green-500 text-white px-6 py-2 rounded-md">
                Ajouter une nouvelle adresse
            </button>

            <!-- Formulaire pour ajouter une nouvelle adresse -->
            <div v-if="addingNewAddress" class="mt-6">
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

                            <!-- Bouton crayon pour la mise à jour -->
                            <button @click="editAddress(address)" class="text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="m16 2.012 3 3L16.713 7.3l-3-3zM4 14v3h3l8.299-8.287-3-3zm0 6h16v2H4z">
                                    </path>
                                </svg>
                            </button>
                            <!-- Bouton pour définir par défaut -->
                            <button @click="setDefaultAddress(address.id)" class="text-green-500 ml-2">
                                Mettre l'adresse par défaut
                            </button>
                            <!-- Bouton de suppression -->
                            <form @submit.prevent="deleteAddress(address.id)" method="POST" class="inline">
                                <button type="submit" class="text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path
                                            d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm4 12H8v-9h2v9zm6 0h-2v-9h2v9zm.618-15L15 2H9L7.382 4H3v2h18V4z">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <div v-else>
                    <p>Aucune adresse enregistrée.</p>
                </div>
            </div>

            <!-- Formulaire pour mettre à jour une adresse -->
            <div v-if="editingAddress" class="mt-6">
                <h2 class="text-xl font-semibold">Modifier l'adresse</h2>
                <form @submit.prevent="updateAddress" class="mt-4 space-y-4">
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
                        Mettre à jour l'adresse
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>