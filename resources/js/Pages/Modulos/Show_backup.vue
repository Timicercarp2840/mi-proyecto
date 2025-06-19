<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    modulo: Object,
    progreso: Object
});

const marcarCompletado = () => {
    router.post(route('progreso.actualizar', props.modulo.id_modulo), {
        estado: 'completado'
    });
};
</script>

<template>
    <Head :title="`${modulo.titulo} - SABLE`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Nivel {{ modulo.nivel }}: {{ modulo.titulo }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">{{ modulo.descripcion }}</p>
                </div>
                <Link 
                    :href="route('modulos.index')"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    ← Volver a Módulos
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <!-- Estado del progreso -->
                <div class="mb-6">
                    <div 
                        v-if="progreso?.estado === 'completado'"
                        class="bg-green-50 border border-green-200 rounded-lg p-4"
                    >
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="text-green-400 text-xl">✅</span>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">
                                    ¡Módulo Completado!
                                </h3>
                                <p class="text-sm text-green-700 mt-1">
                                    Has completado este módulo exitosamente.
                                    <span v-if="progreso.puntuacion">
                                        Puntuación: {{ progreso.puntuacion }}%
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div 
                        v-else-if="progreso?.estado === 'en_proceso'"
                        class="bg-yellow-50 border border-yellow-200 rounded-lg p-4"
                    >
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="text-yellow-400 text-xl">📚</span>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    Módulo en Proceso
                                </h3>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Continúa aprendiendo para completar este módulo.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div 
                        v-else
                        class="bg-blue-50 border border-blue-200 rounded-lg p-4"
                    >
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="text-blue-400 text-xl">🎯</span>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">
                                    ¡Comienza tu Aprendizaje!
                                </h3>
                                <p class="text-sm text-blue-700 mt-1">
                                    Este es un nuevo módulo. ¡Vamos a comenzar!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido del módulo -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Contenido del Módulo
                        </h3>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 leading-relaxed">
                                {{ modulo.contenido }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Evaluaciones disponibles -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Evaluaciones
                        </h3>
                        <div v-if="modulo.evaluaciones && modulo.evaluaciones.length > 0">
                            <div 
                                v-for="evaluacion in modulo.evaluaciones" 
                                :key="evaluacion.id_eval"
                                class="border rounded-lg p-4 mb-4"
                            >
                                <h4 class="font-medium text-gray-900 mb-2">
                                    Evaluación del Módulo {{ modulo.nivel }}
                                </h4>
                                <p class="text-gray-600 text-sm mb-4">
                                    Pon a prueba tus conocimientos con esta evaluación interactiva.
                                </p>
                                <Link 
                                    :href="route('evaluaciones.tomar', evaluacion.id_eval)"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <span v-if="progreso?.estado === 'completado'">
                                        Repetir Evaluación
                                    </span>
                                    <span v-else>
                                        Tomar Evaluación
                                    </span>
                                </Link>
                            </div>
                        </div>
                        <div v-else class="text-gray-500 text-center py-8">
                            No hay evaluaciones disponibles para este módulo.
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="flex justify-between items-center">
                    <div>
                        <Link 
                            v-if="modulo.nivel > 1"
                            :href="route('modulos.show', modulo.id_modulo - 1)"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            ← Módulo Anterior
                        </Link>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button 
                            v-if="!progreso || progreso.estado !== 'completado'"
                            @click="marcarCompletado"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Marcar como Completado
                        </button>
                        
                        <Link 
                            :href="route('modulos.show', modulo.id_modulo + 1)"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Siguiente Módulo →
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
