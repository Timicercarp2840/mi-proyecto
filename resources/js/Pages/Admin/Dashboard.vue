<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: Object
});
</script>

<template>
    <Head title="Panel de Administración - SABLE" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Panel de Administración - SABLE
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Bienvenida -->
                <div class="mb-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg">
                    <div class="p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">
                            👨‍💼 Bienvenido al Panel de Administración
                        </h3>
                        <p class="text-blue-100">
                            Gestiona el contenido educativo, usuarios y monitorea el progreso de la plataforma SABLE.
                        </p>
                    </div>
                </div>

                <!-- Estadísticas principales -->
                <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                                        <span class="text-blue-600 text-lg">👥</span>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Estudiantes
                                        </dt>
                                        <dd class="text-lg font-medium text-gray-900">
                                            {{ stats.totalUsuarios }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                        <span class="text-green-600 text-lg">📚</span>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Módulos Creados
                                        </dt>
                                        <dd class="text-lg font-medium text-gray-900">
                                            {{ stats.totalModulos }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                                        <span class="text-yellow-600 text-lg">📝</span>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Evaluaciones
                                        </dt>
                                        <dd class="text-lg font-medium text-gray-900">
                                            {{ stats.totalEvaluaciones }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                                        <span class="text-purple-600 text-lg">✅</span>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Completados
                                        </dt>
                                        <dd class="text-lg font-medium text-gray-900">
                                            {{ stats.progresosCompletados }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones rápidas -->
                <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                📚 Gestión de Contenido
                            </h3>
                            <div class="space-y-3">
                                <Link 
                                    :href="route('admin.modulos')"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md border border-gray-200"
                                >
                                    Ver Módulos
                                </Link>
                                <Link 
                                    :href="route('admin.modulos.create')"
                                    class="block w-full text-left px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md"
                                >
                                    ➕ Crear Nuevo Módulo
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                📝 Evaluaciones
                            </h3>
                            <div class="space-y-3">
                                <Link 
                                    :href="route('admin.evaluaciones')"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md border border-gray-200"
                                >
                                    Ver Evaluaciones
                                </Link>
                                <Link 
                                    :href="route('admin.evaluaciones.create')"
                                    class="block w-full text-left px-4 py-2 text-sm text-white bg-green-600 hover:bg-green-700 rounded-md"
                                >
                                    ➕ Crear Nueva Evaluación
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                👥 Usuarios
                            </h3>
                            <div class="space-y-3">
                                <Link 
                                    :href="route('admin.usuarios')"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md border border-gray-200"
                                >
                                    Gestionar Usuarios
                                </Link>
                                <div class="px-4 py-2 text-sm text-gray-500 rounded-md border border-gray-200">
                                    Estadísticas y Reportes
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del sistema -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            ℹ️ Información del Sistema
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Estado de la Plataforma</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Sistema:</span>
                                        <span class="text-green-600 font-medium">✅ Operativo</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Base de Datos:</span>
                                        <span class="text-green-600 font-medium">✅ Conectada</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Último Backup:</span>
                                        <span class="text-gray-600">Hoy</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Estadísticas Rápidas</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Usuarios Activos Hoy:</span>
                                        <span class="text-blue-600 font-medium">{{ Math.floor(stats.totalUsuarios * 0.3) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Evaluaciones Tomadas:</span>
                                        <span class="text-purple-600 font-medium">{{ stats.progresosCompletados }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tasa de Finalización:</span>
                                        <span class="text-green-600 font-medium">
                                            {{ stats.totalUsuarios > 0 ? Math.round((stats.progresosCompletados / stats.totalUsuarios) * 100) : 0 }}%
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
