<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    progresos: Array,
    totalModulos: Number,
    modulosCompletados: Number,
    porcentajeProgreso: Number
});
</script>

<template>
    <Head title="Mi Progreso - SABLE" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Mi Progreso de Aprendizaje
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Resumen general -->
                <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">{{ porcentajeProgreso }}%</div>
                            <div class="text-sm text-gray-600">Progreso General</div>
                        </div>
                    </div>
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <div class="text-3xl font-bold text-green-600 mb-2">{{ modulosCompletados }}</div>
                            <div class="text-sm text-gray-600">Módulos Completados</div>
                        </div>
                    </div>
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <div class="text-3xl font-bold text-gray-600 mb-2">{{ totalModulos }}</div>
                            <div class="text-sm text-gray-600">Total Módulos</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de progreso visual -->
                <div class="mb-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Progreso Visual</h3>
                        <div class="w-full bg-gray-200 rounded-full h-6 mb-4">
                            <div 
                                class="bg-gradient-to-r from-blue-500 to-green-500 h-6 rounded-full transition-all duration-500 flex items-center justify-center" 
                                :style="{ width: porcentajeProgreso + '%' }"
                            >
                                <span v-if="porcentajeProgreso > 15" class="text-white text-xs font-semibold">
                                    {{ porcentajeProgreso }}%
                                </span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            ¡Sigue así! Has completado {{ modulosCompletados }} de {{ totalModulos }} módulos.
                        </p>
                    </div>
                </div>

                <!-- Detalle por módulo -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Progreso Detallado por Módulo</h3>
                        
                        <div class="space-y-4">
                            <div 
                                v-for="progreso in progresos" 
                                :key="progreso.id_modulo"
                                class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-medium">
                                                {{ progreso.modulo.nivel }}
                                            </span>
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-900">
                                                    {{ progreso.modulo.titulo }}
                                                </h4>
                                                <p class="text-sm text-gray-600">
                                                    {{ progreso.modulo.descripcion }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4">
                                        <!-- Estado -->
                                        <div class="text-center">
                                            <div 
                                                v-if="progreso.estado === 'completado'"
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                            >
                                                ✓ Completado
                                            </div>
                                            <div 
                                                v-else
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                                            >
                                                📚 En Proceso
                                            </div>
                                        </div>
                                        
                                        <!-- Puntuación -->
                                        <div v-if="progreso.puntuacion" class="text-center">
                                            <div class="text-lg font-bold text-gray-900">
                                                {{ progreso.puntuacion }}%
                                            </div>
                                            <div class="text-xs text-gray-500">Puntuación</div>
                                        </div>
                                        
                                        <!-- Acciones -->
                                        <div>
                                            <Link 
                                                :href="route('modulos.show', progreso.modulo.id_modulo)"
                                                class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                            >
                                                <span v-if="progreso.estado === 'completado'">
                                                    Revisar
                                                </span>
                                                <span v-else>
                                                    Continuar
                                                </span>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Fecha de actualización -->
                                <div class="mt-3 text-xs text-gray-500">
                                    Última actualización: {{ new Date(progreso.updated_at).toLocaleDateString('es-ES', { 
                                        year: 'numeric', 
                                        month: 'long', 
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    }) }}
                                </div>
                            </div>
                        </div>

                        <!-- Estado si no hay progreso -->
                        <div v-if="progresos.length === 0" class="text-center py-12">
                            <div class="text-6xl mb-4">📚</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                ¡Comienza tu Aventura de Aprendizaje!
                            </h3>
                            <p class="text-gray-600 mb-6">
                                Aún no has comenzado ningún módulo. ¡Es hora de empezar!
                            </p>
                            <Link 
                                :href="route('modulos.index')"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Ver Módulos Disponibles
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Consejos motivacionales -->
                <div class="mt-8 bg-gradient-to-r from-blue-50 to-green-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="text-lg font-medium text-blue-900 mb-4">
                        💪 ¡Sigue Adelante!
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <h5 class="font-medium text-blue-800 mb-2">Consejos para el Éxito:</h5>
                            <ul class="text-blue-700 space-y-1">
                                <li>• Practica los comandos regularmente</li>
                                <li>• Completa las evaluaciones para consolidar conocimientos</li>
                                <li>• No tengas miedo de repetir módulos</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-medium text-green-800 mb-2">Tu Progreso:</h5>
                            <ul class="text-green-700 space-y-1">
                                <li v-if="porcentajeProgreso >= 80">• ¡Excelente! Estás muy cerca del final</li>
                                <li v-else-if="porcentajeProgreso >= 50">• ¡Muy bien! Vas por la mitad del camino</li>
                                <li v-else-if="porcentajeProgreso >= 25">• ¡Buen comienzo! Sigue así</li>
                                <li v-else>• ¡Es el momento perfecto para comenzar!</li>
                                <li>• Cada módulo completado es un logro</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
