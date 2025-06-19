<template>
    <Head title="Desafío Libre" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🎯 Desafío Libre
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        
                        <!-- Descripción -->
                        <div class="mb-8 text-center">
                            <h3 class="text-2xl font-bold mb-4">Elige tu desafío</h3>
                            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                                Selecciona una de las siguientes opciones para poner a prueba tus habilidades 
                                con la línea de comandos y el sistema operativo.
                            </p>
                        </div>

                        <!-- Grid de opciones -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Terminal Interactivo -->
                            <div class="group cursor-pointer transform transition-all duration-200 hover:scale-105">
                                <Link 
                                    :href="route('desafios.terminal')"
                                    class="block p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl border border-blue-200 dark:border-blue-700 hover:shadow-lg transition-all duration-200"
                                >
                                    <div class="text-center">
                                        <div class="text-4xl mb-4">🖥️</div>
                                        <h4 class="text-xl font-semibold mb-2 text-blue-800 dark:text-blue-200">
                                            Terminal Interactivo
                                        </h4>
                                        <p class="text-blue-600 dark:text-blue-300 text-sm">
                                            Practica comandos básicos y avanzados en un entorno simulado.
                                            Perfecto para dominar la línea de comandos.
                                        </p>
                                    </div>
                                </Link>
                            </div>

                            <!-- Sistema de Archivos -->
                            <div class="group cursor-pointer transform transition-all duration-200 hover:scale-105">
                                <Link 
                                    :href="route('desafios.filesystem')"
                                    class="block p-6 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl border border-green-200 dark:border-green-700 hover:shadow-lg transition-all duration-200"
                                >
                                    <div class="text-center">
                                        <div class="text-4xl mb-4">📁</div>
                                        <h4 class="text-xl font-semibold mb-2 text-green-800 dark:text-green-200">
                                            Sistema de Archivos
                                        </h4>
                                        <p class="text-green-600 dark:text-green-300 text-sm">
                                            Explora y manipula archivos y directorios. Aprende navegación 
                                            y gestión del sistema de archivos.
                                        </p>
                                    </div>
                                </Link>
                            </div>

                            <!-- Permisos -->
                            <div class="group cursor-pointer transform transition-all duration-200 hover:scale-105">
                                <Link 
                                    :href="route('desafios.permisos')"
                                    class="block p-6 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl border border-purple-200 dark:border-purple-700 hover:shadow-lg transition-all duration-200"
                                >
                                    <div class="text-center">
                                        <div class="text-4xl mb-4">🔐</div>
                                        <h4 class="text-xl font-semibold mb-2 text-purple-800 dark:text-purple-200">
                                            Permisos
                                        </h4>
                                        <p class="text-purple-600 dark:text-purple-300 text-sm">
                                            Domina el sistema de permisos Unix/Linux. Aprende chmod, 
                                            chown y gestión de usuarios y grupos.
                                        </p>
                                    </div>
                                </Link>
                            </div>

                            <!-- Muro de Comandos -->
                            <div class="group cursor-pointer transform transition-all duration-200 hover:scale-105">
                                <Link 
                                    :href="route('desafios.muro-comandos')"
                                    class="block p-6 bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-xl border border-amber-200 dark:border-amber-700 hover:shadow-lg transition-all duration-200"
                                >
                                    <div class="text-center">
                                        <div class="text-4xl mb-4">🏆</div>
                                        <h4 class="text-xl font-semibold mb-2 text-amber-800 dark:text-amber-200">
                                            Muro de Comandos
                                        </h4>
                                        <p class="text-amber-600 dark:text-amber-300 text-sm">
                                            Comparte tus comandos favoritos y descubre nuevos comandos 
                                            útiles de la comunidad.
                                        </p>
                                    </div>
                                </Link>
                            </div>

                        </div>

                        <!-- Estadísticas opcionales -->
                        <div class="mt-8 text-center">
                            <div class="inline-flex items-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                                <span>💡 4 categorías de desafíos</span>
                                <span>⚡ Dificultad progresiva</span>
                                <span>🎖️ Sistema de puntuación</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>
