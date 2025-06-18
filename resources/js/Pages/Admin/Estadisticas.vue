<template>
    <Head title="Estadísticas y Reportes" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📊 Estadísticas y Reportes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <!-- Estadísticas Generales -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">📈 Resumen General</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">👥</span>
                                    <div>
                                        <p class="text-blue-600 dark:text-blue-400 text-sm font-medium">Estudiantes</p>
                                        <p class="text-2xl font-bold text-blue-800 dark:text-blue-200">{{ stats.totalUsuarios }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">📚</span>
                                    <div>
                                        <p class="text-green-600 dark:text-green-400 text-sm font-medium">Módulos</p>
                                        <p class="text-2xl font-bold text-green-800 dark:text-green-200">{{ stats.totalModulos }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">📝</span>
                                    <div>
                                        <p class="text-purple-600 dark:text-purple-400 text-sm font-medium">Evaluaciones</p>
                                        <p class="text-2xl font-bold text-purple-800 dark:text-purple-200">{{ stats.totalEvaluaciones }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">🎮</span>
                                    <div>
                                        <p class="text-yellow-600 dark:text-yellow-400 text-sm font-medium">Desafíos</p>
                                        <p class="text-2xl font-bold text-yellow-800 dark:text-yellow-200">{{ stats.totalDesafios }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">✅</span>
                                <div>
                                    <p class="text-indigo-600 dark:text-indigo-400 text-sm font-medium">Progresos Completados</p>
                                    <p class="text-2xl font-bold text-indigo-800 dark:text-indigo-200">{{ stats.progresosCompletados }}</p>
                                    <p class="text-sm text-indigo-600 dark:text-indigo-400 mt-1">
                                        Tasa de completación: {{ Math.round((stats.progresosCompletados / (stats.totalUsuarios * stats.totalModulos)) * 100) || 0 }}%
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas por Módulo -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">📊 Rendimiento por Módulo</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Módulo
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Total Inscritos
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Completados
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            % Completación
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Progreso
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="modulo in estadisticasModulos" :key="modulo.id_modulo">
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="font-medium">{{ modulo.titulo }}</div>
                                            <div class="text-gray-500 dark:text-gray-400">Nivel {{ modulo.nivel }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ modulo.progresos_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ modulo.completados }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ getCompletionPercentage(modulo) }}%
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div 
                                                    class="bg-green-600 h-2 rounded-full transition-all duration-300" 
                                                    :style="{ width: getCompletionPercentage(modulo) + '%' }"
                                                ></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Usuarios Más Activos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">🏆 Top 10 Estudiantes Más Activos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div v-for="(usuario, index) in usuariosActivos" :key="usuario.id" 
                                 class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ index + 1 }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">{{ usuario.name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ usuario.email }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ usuario.progresos_count }} módulos
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones de Exportación -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">📥 Exportar Reportes</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded inline-flex items-center">
                                <span class="mr-2">📊</span>
                                Exportar Estadísticas Generales
                            </button>
                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded inline-flex items-center">
                                <span class="mr-2">👥</span>
                                Exportar Lista de Usuarios
                            </button>
                            <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded inline-flex items-center">
                                <span class="mr-2">📈</span>
                                Exportar Progreso Detallado
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    stats: Object,
    estadisticasModulos: Array,
    usuariosActivos: Array,
});

const getCompletionPercentage = (modulo) => {
    if (modulo.progresos_count === 0) return 0;
    return Math.round((modulo.completados / modulo.progresos_count) * 100);
};
</script>
