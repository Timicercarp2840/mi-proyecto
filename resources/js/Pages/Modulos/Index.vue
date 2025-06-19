<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    modulos: Array,
    progreso: Object
});
</script>

<template>
    <Head title="Módulos - SABLE" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Módulos de Aprendizaje
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Explora todos los módulos del curso de Linux
                    </h3>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div 
                        v-for="modulo in modulos" 
                        :key="modulo.id_modulo"
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300"
                    >
                        <div class="p-6">
                            <!-- Nivel y estado -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    Nivel {{ modulo.nivel }}
                                </span>
                                <span 
                                    v-if="progreso[modulo.id_modulo] === 'completado'"
                                    class="text-green-600 text-xl"
                                    title="Completado"
                                >
                                    ✅
                                </span>
                                <span 
                                    v-else-if="progreso[modulo.id_modulo] === 'en_proceso'"
                                    class="text-yellow-600 text-xl"
                                    title="En Proceso"
                                >
                                    📚
                                </span>
                                <span 
                                    v-else
                                    class="text-gray-400 text-xl"
                                    title="No Iniciado"
                                >
                                    🔒
                                </span>
                            </div>

                            <!-- Título y descripción -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ modulo.titulo }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ modulo.descripcion }}
                            </p>

                            <!-- Estado detallado -->
                            <div class="mb-4">
                                <div 
                                    v-if="progreso[modulo.id_modulo] === 'completado'"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                >
                                    ✓ Completado
                                </div>
                                <div 
                                    v-else-if="progreso[modulo.id_modulo] === 'en_proceso'"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                                >
                                    📚 En Proceso
                                </div>
                                <div 
                                    v-else
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                >
                                    🔒 No Iniciado
                                </div>
                            </div>

                            <!-- Botón de acción -->
                            <Link 
                                :href="route('modulos.show', modulo.id_modulo)"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <span v-if="progreso[modulo.id_modulo] === 'completado'">
                                    Revisar Módulo
                                </span>
                                <span v-else-if="progreso[modulo.id_modulo] === 'en_proceso'">
                                    Continuar
                                </span>
                                <span v-else>
                                    Comenzar
                                </span>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="text-lg font-medium text-blue-900 mb-2">
                        💡 Consejos para el Aprendizaje
                    </h4>
                    <ul class="text-blue-800 text-sm space-y-1">
                        <li>• Completa los módulos en orden secuencial para mejor comprensión</li>
                        <li>• Practica los comandos en un entorno Linux real</li>
                        <li>• Completa las evaluaciones para verificar tu progreso</li>
                        <li>• No dudes en revisar módulos anteriores si necesitas refrescar conceptos</li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
