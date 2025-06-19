<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import { useRoute } from '../composables/useRoute.js';

const { route } = useRoute();
const showingNavigationDropdown = ref(false);
const { isDark, toggleDarkMode } = useDarkMode();
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav
                class="border-b border-gray-100 bg-white dark:bg-gray-800 dark:border-gray-700"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </NavLink>
                                
                                <!-- Enlaces para estudiantes -->
                                <template v-if="$page.props.auth.user && $page.props.auth.user.rol === 'estudiante'">
                                    <NavLink
                                        :href="route('modulos.index')"
                                        :active="route().current('modulos.*')"
                                    >
                                        📚 Módulos
                                    </NavLink>
                                    
                                    <!-- Desafíos Libre -->
                                    <NavLink
                                        :href="route('desafios.libre')"
                                        :active="route().current('desafios.*')"
                                    >
                                        🎮 Desafíos Libre
                                    </NavLink>
                                    
                                    <!-- Gamificación -->
                                    <NavLink
                                        :href="route('gamificacion.leaderboard')"
                                        :active="route().current('gamificacion.leaderboard')"
                                    >
                                        🏆 Clasificación
                                    </NavLink>
                                </template>
                                
                                <!-- Enlaces para administradores -->
                                <template v-if="$page.props.auth.user && $page.props.auth.user.rol === 'administrador'">
                                    <NavLink
                                        :href="route('admin.modulos')"
                                        :active="route().current('admin.modulos*')"
                                    >
                                        📚 Módulos y Evaluaciones
                                    </NavLink>
                                    <NavLink
                                        :href="route('admin.desafios')"
                                        :active="route().current('admin.desafios*')"
                                    >
                                        🎮 Gestión Desafíos
                                    </NavLink>
                                    <NavLink
                                        :href="route('admin.usuarios')"
                                        :active="route().current('admin.usuarios*')"
                                    >
                                        👥 Gestión Usuarios
                                    </NavLink>
                                    <NavLink
                                        :href="route('admin.estadisticas')"
                                        :active="route().current('admin.estadisticas')"
                                    >
                                        📊 Estadísticas y Reportes
                                    </NavLink>
                                </template>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center sm:space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button
                                @click="toggleDarkMode"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                                title="Alternar modo oscuro"
                            >
                                <svg v-if="!isDark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <!-- Icono de luna (modo claro activo) -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <!-- Icono de sol (modo oscuro activo) -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </button>

                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium leading-4 text-gray-500 dark:text-gray-300 transition duration-150 ease-in-out hover:text-gray-700 dark:hover:text-gray-100 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user?.name || 'Usuario' }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('gamificacion.perfil')"
                                        >
                                            🎮 Mi Perfil
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            🚪 Cerrar Sesión
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger y Dark Mode Toggle -->
                        <div class="-me-2 flex items-center sm:hidden space-x-2">
                            <!-- Dark Mode Toggle Mobile -->
                            <button
                                @click="toggleDarkMode"
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300 focus:bg-gray-100 focus:text-gray-500 dark:focus:bg-gray-800 focus:outline-none"
                                title="Alternar modo oscuro"
                            >
                                <svg v-if="!isDark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <!-- Icono de luna (modo claro activo) -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <!-- Icono de sol (modo oscuro activo) -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </button>

                            <!-- Hamburger -->
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                        
                        <!-- Enlaces para estudiantes en móvil -->
                        <template v-if="$page.props.auth.user && $page.props.auth.user.rol === 'estudiante'">
                            <ResponsiveNavLink
                                :href="route('modulos.index')"
                                :active="route().current('modulos.*')"
                            >
                                📚 Módulos
                            </ResponsiveNavLink>
                            
                            <!-- Desafíos Libre -->
                            <ResponsiveNavLink
                                :href="route('desafios.libre')"
                                :active="route().current('desafios.*')"
                            >
                                🎮 Desafíos Libre
                            </ResponsiveNavLink>
                            
                            <!-- Gamificación -->
                            <ResponsiveNavLink
                                :href="route('gamificacion.leaderboard')"
                                :active="route().current('gamificacion.leaderboard')"
                            >
                                🏆 Clasificación
                            </ResponsiveNavLink>
                        </template>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        class="border-t border-gray-200 dark:border-gray-700 pb-1 pt-4 bg-white dark:bg-gray-800"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-gray-800 dark:text-gray-200"
                            >
                                {{ $page.props.auth.user?.name || 'Usuario' }}
                            </div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ $page.props.auth.user?.email || '' }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('gamificacion.perfil')">
                                🎮 Mi Perfil
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                🚪 Cerrar Sesión
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white dark:bg-gray-800 shadow dark:shadow-gray-700"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Flash Messages -->
            <div v-if="$page.props.flash.success || $page.props.flash.warning || $page.props.flash.error" class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <!-- Success Message -->
                <div v-if="$page.props.flash.success" class="mb-4 rounded-lg bg-green-50 border border-green-200 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-green-400 text-xl">🎉</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ $page.props.flash.success }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Warning Message -->
                <div v-if="$page.props.flash.warning" class="mb-4 rounded-lg bg-yellow-50 border border-yellow-200 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-yellow-400 text-xl">⚠️</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800">
                                {{ $page.props.flash.warning }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div v-if="$page.props.flash.error" class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-red-400 text-xl">❌</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                {{ $page.props.flash.error }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
