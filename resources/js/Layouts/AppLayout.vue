<script setup>
import { ref, computed } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
    title: String,
});

// const cartItemCount = ref(5);

const showingNavigationDropdown = ref(false);
const page = usePage();
const auth = computed(() => page.props.auth || { user: null });
const isAuthenticated = computed(() => auth.value.user !== null);

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div>

        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')">
                                <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('home')" :active="route().current('home')">
                                    Accueil
                                </NavLink>
                                <NavLink :href="route('categories')" :active="route().current('categories')">
                                    Catégories
                                </NavLink>
                                <NavLink :href="route('products')" :active="route().current('products')">
                                    Produits
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Non connecté -->
                            <template v-if="!isAuthenticated">
                                <Link :href="route('login')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                Se connecter
                                </Link>
                                <Link :href="route('register')"
                                    class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                S'inscrire
                                </Link>
                            </template>

                            <!-- Connecté -->
                            <template v-else>
                                <div class="ms-3 relative flex items-center">
                                    <Link :href="route('addresses.index')">
                                        Adresse
                                    </Link>
                                    <!-- Panier -->
                                    <Link :href="route('cart.show')"
                                        class="text-gray-500 hover:text-gray-700 mr-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: rgba(0, 0, 0, 1);">
                                        <path
                                            d="M21.822 7.431A1 1 0 0 0 21 7H7.333L6.179 4.23A1.994 1.994 0 0 0 4.333 3H2v2h2.333l4.744 11.385A1 1 0 0 0 10 17h8c.417 0 .79-.259.937-.648l3-8a1 1 0 0 0-.115-.921z">
                                        </path>
                                        <circle cx="10.5" cy="19.5" r="1.5"></circle>
                                        <circle cx="17.5" cy="19.5" r="1.5"></circle>
                                    </svg>

                                    <!-- Bulle rectangulaire avec le nombre d'articles -->
                                    <!-- <span v-if="cartItemCount > 0"
                                        class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-md ml-2">
                                        {{ cartItemCount }}
                                    </span> -->
                                    </Link>

                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="
                                                $page.props.jetstream
                                                    .managesProfilePhotos
                                            "
                                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="size-8 rounded-full object-cover" :src="$page.props.auth.user
                                                    .profile_photo_url
                                                    " :alt="$page.props.auth.user
                                                        .name
                                                        " />
                                            </button>

                                            <span v-else class="inline-flex rounded-md">
                                                <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                    {{
                                                        $page.props.auth.user
                                                            .name
                                                    }}

                                                    <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Gérer le compte
                                            </div>

                                            <DropdownLink :href="route('profile.show')">
                                                Profil
                                            </DropdownLink>

                                            <div class="border-t border-gray-200" />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <DropdownLink as="button">
                                                    Déconnexion
                                                </DropdownLink>
                                            </form>
                                        </template>
                                    </Dropdown>
                                </div>
                            </template>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                @click="
                                    showingNavigationDropdown =
                                    !showingNavigationDropdown
                                    ">
                                <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                            Accueil
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('categories')" :active="route().current('categories')">
                            Catégories
                        </ResponsiveNavLink>
                    </div>

                    <!-- Non connecté (Mobile) -->
                    <template v-if="!isAuthenticated">
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="space-y-1">
                                <ResponsiveNavLink :href="route('login')" :active="route().current('login')">
                                    Se connecter
                                </ResponsiveNavLink>
                                <ResponsiveNavLink :href="route('register')" :active="route().current('register')">
                                    S'inscrire
                                </ResponsiveNavLink>
                            </div>
                        </div>
                    </template>

                    <!-- Connecté (Mobile) -->
                    <template v-else>
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <div v-if="
                                    $page.props.jetstream
                                        .managesProfilePhotos
                                " class="shrink-0 me-3">
                                    <img class="size-10 rounded-full object-cover" :src="$page.props.auth.user
                                        .profile_photo_url
                                        " :alt="$page.props.auth.user.name" />
                                </div>

                                <div>
                                    <div class="font-medium text-base text-gray-800">
                                        {{ $page.props.auth.user.name }}
                                    </div>
                                    <div class="font-medium text-sm text-gray-500">
                                        {{ $page.props.auth.user.email }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink :href="route('profile.show')"
                                    :active="route().current('profile.show')">
                                    Profil
                                </ResponsiveNavLink>

                                <!-- Authentication -->
                                <form method="POST" @submit.prevent="logout">
                                    <ResponsiveNavLink as="button">
                                        Déconnexion
                                    </ResponsiveNavLink>
                                </form>
                            </div>
                        </div>
                    </template>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>