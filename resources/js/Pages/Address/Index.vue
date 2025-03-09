<script setup>
import { ref } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';


const { addresses } = usePage().props;

const editingAddress = ref(null);
const addingNewAddress = ref(false);


const form = useForm({
    street: '',
    postcode: '',
    city: '',
    is_default: false,
});

const editAddress = (address) => {
    editingAddress.value = address;
    form.street = address.street;
    form.postcode = address.postcode;
    form.city = address.city;
    form.is_default = address.is_default;
};

const updateAddress = () => {
    form.put(route('addresses.update', { address: editingAddress.value.id }), {
        onSuccess: () => {
            editingAddress.value = null;
            window.location.reload();
        },
    });
};

const submitAddress = () => {
    form.post(route('addresses.store'), {
        onSuccess: () => {
            form.reset();
            addingNewAddress.value = false;
            window.location.reload();
        },
    });
};

const toggleAddAddressForm = () => {
    addingNewAddress.value = !addingNewAddress.value;
};

const deleteAddress = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette adresse ?')) {
        form.delete(route('addresses.delete', { address: id }), {
            onSuccess: () => {
                window.location.reload();
            },
        });
    }
};

const closeAddForm = () => {
    addingNewAddress.value = false;
    form.reset();
};

const closeEditForm = () => {
    editingAddress.value = null;
    form.reset();
};
</script>

<template>
    <AppLayout>
        <Head title="Liste des Addresses" />
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Mes adresses</h1>
                        <button 
                            @click="toggleAddAddressForm" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md transition duration-150 ease-in-out"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Ajouter une adresse
                        </button>
                    </div>

                    <!-- Liste des adresses -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div 
                            v-for="address in addresses" 
                            :key="address.id" 
                            :class="[
                                'relative p-6 rounded-lg border-2 transition-all duration-200',
                                address.is_default 
                                    ? 'border-indigo-500 bg-indigo-50' 
                                    : 'border-gray-200 hover:border-gray-300 bg-white'
                            ]"
                        >
                            <!-- Adresse par défaut -->
                            <div 
                                v-if="address.is_default" 
                                class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-indigo-600 text-white text-xs px-3 py-1 rounded-full"
                            >
                                Adresse par défaut
                            </div>

                            <!-- Contenu de l'adresse -->
                            <div class="mt-2">
                                <p class="text-lg font-semibold text-gray-900">{{ address.street }}</p>
                                <p class="text-gray-600">{{ address.postcode }} {{ address.city }}</p>
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 flex justify-end space-x-2">
                                <!-- Bouton éditer -->
                                <button 
                                    @click="editAddress(address)"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors duration-200"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <!-- Bouton supprimer -->
                                <button 
                                    @click="deleteAddress(address.id)"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors duration-200"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Message si aucune adresse -->
                    <div v-if="!addresses.length" class="text-center py-12">
                        <p class="text-gray-500">Vous n'avez pas encore ajouté d'adresse.</p>
                    </div>

                    <!-- Formulaire pour ajouter une nouvelle adresse -->
                    <div v-if="addingNewAddress" class="mt-6 bg-gray-50 p-6 rounded-lg relative">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Ajouter une nouvelle adresse</h2>
                            <button 
                                @click="closeAddForm" 
                                class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-200 transition-colors duration-200"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
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

                    <!-- Formulaire pour mettre à jour une adresse -->
                    <div v-if="editingAddress" class="mt-6 bg-gray-50 p-6 rounded-lg relative">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Modifier l'adresse</h2>
                            <button 
                                @click="closeEditForm" 
                                class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-200 transition-colors duration-200"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
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
            </div>
        </div>
    </AppLayout>
</template>