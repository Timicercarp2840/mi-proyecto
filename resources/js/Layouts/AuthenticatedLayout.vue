<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import DarkModeToggle from '@/Components/DarkModeToggle.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav
                class="border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
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
                                <template v-if="$page.props.auth.user && $page.props.auth.user.rol === 'estudiante'">                                <NavLink
                                    :href="route('modulos.index')"
                                    :active="route().current('modulos.*')"
                                >
                                    📚 Módulos
                                </NavLink>
                                
                                <!-- Enlace directo a Desafío Libre -->
                                <NavLink
                                    :href="route('desafio-libre.index')"
                                    :active="route().current('desafio-libre.*') || route().current('desafios.*')"
                                >
                                    🎯 Desafío Libre
                                </NavLink>
                                </template>
                                
                                <!-- Enlaces para administradores -->
                                <template v-if="$page.props.auth.user && $page.props.auth.user.rol === 'administrador'">
                                    <NavLink
                                        :href="route('admin.modulos')"
                                        :active="route().current('admin.modulos*')"
                                    >
                                        Gestión Módulos
                                    </NavLink>
                                    <NavLink
                                        :href="route('admin.evaluaciones')"
                                        :active="route().current('admin.evaluaciones*')"
                                    >
                                        Gestión Evaluaciones
                                    </NavLink>
                                    <NavLink
                                        :href="route('admin.usuarios')"
                                        :active="route().current('admin.usuarios*')"
                                    >
                                        Gestión Usuarios
                                    </NavLink>
                                    <NavLink
                                        :href="route('admin.desafios')"
                                        :active="route().current('admin.desafios*')"
                                    >
                                        Gestión Desafíos
                                    </NavLink>
                                </template>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <DarkModeToggle />
                            
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium leading-4 text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
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
                                            :href="route('perfil.unificado')"
                                        >
                                            👤 Mi Perfil Completo
                                        </DropdownLink>
                                        
                                        <div class="border-t border-gray-100 dark:border-gray-600"></div>
                                        
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Cerrar Sesión
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden space-x-2">
                            <!-- Dark Mode Toggle para móvil -->
                            <DarkModeToggle />
                            
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 dark:text-gray-500 transition duration-150 ease-in-out hover:bg-gray-100 dark:hover:bg-gray-900 hover:text-gray-500 dark:hover:text-gray-400 focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 focus:outline-none"
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
                    class="sm:hidden"
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
                            
                            <!-- Enlace directo a Desafío Libre en móvil -->
                            <ResponsiveNavLink
                                :href="route('desafio-libre.index')"
                                :active="route().current('desafio-libre.*') || route().current('desafios.*')"
                            >
                                🎯 Desafío Libre
                            </ResponsiveNavLink>
                        </template>
                        
                        <!-- Enlaces para administradores en móvil -->
                        <template v-if="$page.props.auth.user && $page.props.auth.user.rol === 'administrador'">
                            <ResponsiveNavLink
                                :href="route('admin.modulos')"
                                :active="route().current('admin.modulos*')"
                            >
                                Gestión Módulos
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('admin.evaluaciones')"
                                :active="route().current('admin.evaluaciones*')"
                            >
                                Gestión Evaluaciones
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('admin.usuarios')"
                                :active="route().current('admin.usuarios*')"
                            >
                                Gestión Usuarios
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('admin.desafios')"
                                :active="route().current('admin.desafios*')"
                            >
                                Gestión Desafíos
                            </ResponsiveNavLink>
                        </template>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        class="border-t border-gray-200 dark:border-gray-600 pb-1 pt-4"
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
                            <ResponsiveNavLink :href="route('perfil.unificado')">
                                👤 Mi Perfil Completo
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Cerrar Sesión
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white dark:bg-gray-800 shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Flash Messages -->
            <div v-if="$page.props.flash.success || $page.props.flash.warning || $page.props.flash.error" class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <!-- Success Message -->
                <div v-if="$page.props.flash.success" class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-green-400 text-xl">🎉</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                {{ $page.props.flash.success }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Warning Message -->
                <div v-if="$page.props.flash.warning" class="mb-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/50 border border-yellow-200 dark:border-yellow-700 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-yellow-400 text-xl">⚠️</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                {{ $page.props.flash.warning }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div v-if="$page.props.flash.error" class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-red-400 text-xl">❌</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800 dark:text-red-200">
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
