<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useRoute } from '../composables/useRoute.js';

const { route } = useRoute();

defineProps({
    modulos: Array,
    progreso: Object,
    stats: Object,
    usuario: Object
});
</script>

<template>
    <Head title="Dashboard - SABLE" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard - SABLE
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Estadísticas del progreso y gamificación -->
                <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm sm:rounded-lg text-white">
                        <div class="p-6">
                            <div class="flex items-center">
                                <span class="text-3xl mr-3">⚡</span>
                                <div>
                                    <h3 class="text-lg font-medium">XP Total</h3>
                                    <p class="text-2xl font-bold">{{ usuario?.xp_total || 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-hidden bg-gradient-to-br from-green-500 to-green-600 shadow-sm sm:rounded-lg text-white">
                        <div class="p-6">
                            <div class="flex items-center">
                                <span class="text-3xl mr-3">🎯</span>
                                <div>
                                    <h3 class="text-lg font-medium">Nivel</h3>
                                    <p class="text-2xl font-bold">{{ usuario?.nivel_actual || 1 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 shadow-sm sm:rounded-lg text-white">
                        <div class="p-6">
                            <div class="flex items-center">
                                <span class="text-3xl mr-3">📚</span>
                                <div>
                                    <h3 class="text-lg font-medium">Progreso</h3>
                                    <p class="text-2xl font-bold">{{ stats.porcentajeProgreso }}%</p>
                                    <p class="text-sm opacity-90">{{ stats.modulosCompletados }}/{{ stats.totalModulos }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-hidden bg-gradient-to-br from-yellow-500 to-orange-500 shadow-sm sm:rounded-lg text-white">
                        <div class="p-6">
                            <div class="flex items-center">
                                <span class="text-3xl mr-3">🏆</span>
                                <div>
                                    <h3 class="text-lg font-medium">Insignias</h3>
                                    <p class="text-2xl font-bold">{{ usuario?.insignias?.length || 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accesos rápidos gamificados -->
                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <Link :href="route('modulos.index')" class="group">
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg transition-all duration-200 group-hover:shadow-lg group-hover:scale-105">
                            <div class="p-6 text-center">
                                <span class="text-4xl mb-3 block">📚</span>
                                <h3 class="text-lg font-medium text-gray-900">Módulos</h3>
                                <p class="text-sm text-gray-600">Continúa tu aventura</p>
                            </div>
                        </div>
                    </Link>
                    
                    <Link :href="route('gamificacion.perfil')" class="group">
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg transition-all duration-200 group-hover:shadow-lg group-hover:scale-105">
                            <div class="p-6 text-center">
                                <span class="text-4xl mb-3 block">🎮</span>
                                <h3 class="text-lg font-medium text-gray-900">Mi Perfil Gamer</h3>
                                <p class="text-sm text-gray-600">Ve tus logros</p>
                            </div>
                        </div>
                    </Link>
                    
                    <Link :href="route('gamificacion.leaderboard')" class="group">
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg transition-all duration-200 group-hover:shadow-lg group-hover:scale-105">
                            <div class="p-6 text-center">
                                <span class="text-4xl mb-3 block">🏆</span>
                                <h3 class="text-lg font-medium text-gray-900">Clasificación</h3>
                                <p class="text-sm text-gray-600">Compite con otros</p>
                            </div>
                        </div>
                    </Link>
                    
                    <Link :href="route('gamificacion.perfil')" class="group">
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg transition-all duration-200 group-hover:shadow-lg group-hover:scale-105">
                            <div class="p-6 text-center">
                                <span class="text-4xl mb-3 block">🎮</span>
                                <h3 class="text-lg font-medium text-gray-900">Mi Perfil</h3>
                                <p class="text-sm text-gray-600">Progreso y configuración</p>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Desafíos Interactivos -->
                <div class="mb-6">
                    <h3 class="mb-4 text-xl font-bold text-gray-900">🎯 Desafíos Interactivos</h3>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <Link :href="route('desafios.terminal')" class="group">
                            <div class="overflow-hidden bg-gradient-to-br from-green-500 to-green-600 shadow-sm sm:rounded-lg transition-all duration-200 group-hover:shadow-lg group-hover:scale-105">
                                <div class="p-6 text-center text-white">
                                    <span class="text-4xl mb-3 block">🖥️</span>
                                    <h3 class="text-lg font-medium">Terminal Interactivo</h3>
                                    <p class="text-sm opacity-90">Nivel 1 - Comandos básicos</p>
                                </div>
                            </div>
                        </Link>
                        
                        <Link :href="route('desafios.filesystem')" class="group">
                            <div class="overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 shadow-sm sm:rounded-lg transition-all duration-200 group-hover:shadow-lg group-hover:scale-105">
                                <div class="p-6 text-center text-white">
                                    <span class="text-4xl mb-3 block">📁</span>
                                    <h3 class="text-lg font-medium">Sistema de Archivos</h3>
                                    <p class="text-sm opacity-90">Nivel 2 - Manipulación</p>
                                </div>
                            </div>
                        </Link>
                        
                        <Link :href="route('desafios.permisos')" class="group">
                            <div class="overflow-hidden bg-gradient-to-br from-orange-500 to-orange-600 shadow-sm sm:rounded-lg transition-all duration-200 group-hover:shadow-lg group-hover:scale-105">
                                <div class="p-6 text-center text-white">
                                    <span class="text-4xl mb-3 block">🔐</span>
                                    <h3 class="text-lg font-medium">Permisos</h3>
                                    <p class="text-sm opacity-90">Nivel 3 - Seguridad</p>
                                </div>
                            </div>
                        </Link>
                        
                        <Link :href="route('desafios.muro-comandos')" class="group">
                            <div class="overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 shadow-sm sm:rounded-lg transition-all duration-200 group-hover:shadow-lg group_hover:scale-105">
                                <div class="p-6 text-center text-white">
                                    <span class="text-4xl mb-3 block">🏆</span>
                                    <h3 class="text-lg font-medium">Muro de Comandos</h3>
                                    <p class="text-sm opacity-90">Comunidad</p>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>

                <!-- Barra de progreso -->
                <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Tu Progreso</h3>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div 
                                class="bg-blue-600 h-4 rounded-full transition-all duration-300" 
                                :style="{ width: stats.porcentajeProgreso + '%' }"
                            ></div>
                        </div>
                    </div>
                </div>

                <!-- Lista de módulos -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Módulos Disponibles</h3>
                        <div class="grid gap-4">
                            <div 
                                v-for="modulo in modulos" 
                                :key="modulo.id_modulo"
                                class="border rounded-lg p-4 hover:shadow-md transition-shadow"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-medium text-gray-900">
                                            Nivel {{ modulo.nivel }}: {{ modulo.titulo }}
                                        </h4>
                                        <p class="text-gray-600">{{ modulo.descripcion }}</p>
                                        <div class="mt-2">
                                            <span 
                                                v-if="progreso[modulo.id_modulo] === 'completado'"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                            >
                                                ✓ Completado
                                            </span>
                                            <span 
                                                v-else-if="progreso[modulo.id_modulo] === 'en_proceso'"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                                            >
                                                📚 En Proceso
                                            </span>
                                            <span 
                                                v-else
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                            >
                                                🔒 No Iniciado
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <Link 
                                            :href="route('modulos.show', modulo.id_modulo)"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        >
                                            Ver Módulo
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enlaces rápidos -->
                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Accesos Rápidos</h3>
                            <div class="space-y-2">
                                <Link 
                                    :href="route('modulos.index')"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md"
                                >
                                    📚 Ver Todos los Módulos
                                </Link>
                                <Link 
                                    :href="route('gamificacion.perfil')"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md"
                                >
                                    🎮 Mi Perfil y Progreso
                                </Link>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Bienvenido a SABLE</h3>
                            <p class="text-gray-600">
                                Sistema de Aprendizaje de Base Linux Educativa. 
                                Comienza tu viaje de aprendizaje explorando los módulos disponibles.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
