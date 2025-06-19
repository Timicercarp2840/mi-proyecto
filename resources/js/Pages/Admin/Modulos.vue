<template>
    <Head title="Gestión de Módulos" />

    <AuthenticatedLayout>        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📚 Módulos y Evaluaciones
            </h2>
        </template>        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">Módulos y sus Evaluaciones</h3>
                            <Link 
                                :href="route('admin.modulos.create')"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Crear Módulo
                            </Link>
                        </div>                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nivel
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Título
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Evaluaciones
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="modulo in modulos" :key="modulo.id_modulo">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                Nivel {{ modulo.nivel }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="font-medium">{{ modulo.titulo }}</div>
                                            <div class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ modulo.descripcion?.substring(0, 80) }}...</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <div class="flex flex-col space-y-1">
                                                <span class="text-sm font-medium">{{ modulo.evaluaciones?.length || 0 }} evaluación(es)</span>
                                                <Link 
                                                    :href="route('admin.evaluaciones.create', modulo.id_modulo)"
                                                    class="text-green-600 hover:text-green-900 text-xs"
                                                >
                                                    + Agregar evaluación
                                                </Link>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <Link 
                                                    :href="route('admin.modulos.edit', modulo.id_modulo)"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                >
                                                    ✏️ Editar
                                                </Link>
                                                <button 
                                                    @click="eliminarModulo(modulo.id_modulo)"
                                                    class="text-red-600 hover:text-red-900"
                                                >
                                                    🗑️ Eliminar
                                                </button>
                                            </div>
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
    modulos: Array,
});

const eliminarModulo = (id) => {
    if (confirm('¿Estás seguro de que quieres eliminar este módulo?')) {
        router.delete(route('admin.modulos.destroy', id));
    }
};
</script>
