<template>
    <Head title="Gestión de Evaluaciones" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Evaluaciones
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">Evaluaciones del Sistema</h3>
                            <Link 
                                :href="route('admin.evaluaciones.create')"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Crear Evaluación
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Módulo
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nivel
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Preguntas
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="evaluacion in evaluaciones" :key="evaluacion.id_eval">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ evaluacion.id_eval }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ evaluacion.modulo?.titulo }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ evaluacion.modulo?.nivel }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ Array.isArray(evaluacion.contenido_eval) ? evaluacion.contenido_eval.length : 0 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <Link 
                                                :href="route('admin.evaluaciones.edit', evaluacion.id_eval)"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3"
                                            >
                                                Editar
                                            </Link>
                                            <button 
                                                @click="eliminarEvaluacion(evaluacion.id_eval)"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    evaluaciones: Array,
});

const eliminarEvaluacion = (id) => {
    if (confirm('¿Estás seguro de que quieres eliminar esta evaluación?')) {
        router.delete(route('admin.evaluaciones.destroy', id));
    }
};
</script>
