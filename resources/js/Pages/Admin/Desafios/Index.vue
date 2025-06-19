<template>
    <Head title="Gestión de Desafíos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Gestión de Desafíos
                </h2>
                <Link :href="route('admin.desafios.create')" 
                      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    ➕ Crear Desafío
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Estadísticas -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-blue-50 dark:bg-blue-900/50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">
                                    Total Desafíos
                                </h3>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">
                                    {{ desafios.length }}
                                </p>
                            </div>
                            <div class="bg-green-50 dark:bg-green-900/50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">
                                    Activos
                                </h3>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-300">
                                    {{ desafios.filter(d => d.activo).length }}
                                </p>
                            </div>
                            <div class="bg-yellow-50 dark:bg-yellow-900/50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200">
                                    Terminal
                                </h3>
                                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-300">
                                    {{ desafios.filter(d => d.tipo === 'terminal').length }}
                                </p>
                            </div>
                            <div class="bg-purple-50 dark:bg-purple-900/50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-200">
                                    Sistema Archivos
                                </h3>
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-300">
                                    {{ desafios.filter(d => d.tipo === 'filesystem').length }}
                                </p>
                            </div>
                        </div>

                        <!-- Tabla de desafíos -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Desafío
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tipo
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nivel
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            XP
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Completados
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                    <tr v-for="desafio in desafios" :key="desafio.id_desafio">
                                        <td class="px-6 py-4">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ desafio.titulo }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ desafio.descripcion.substring(0, 100) }}...
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="getTipoClass(desafio.tipo)">
                                                {{ getTipoIcon(desafio.tipo) }} {{ getTipoLabel(desafio.tipo) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            Nivel {{ desafio.nivel }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ desafio.xp_recompensa }} XP
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="desafio.activo ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300'">
                                                {{ desafio.activo ? '✅ Activo' : '❌ Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ desafio.progresos_desafio?.length || 0 }} usuarios
                                        </td>
                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <Link :href="route('admin.desafios.edit', desafio.id_desafio)"
                                                  class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                ✏️ Editar
                                            </Link>
                                            <Link :href="route('admin.desafios.toggle', desafio.id_desafio)"
                                                  method="patch"
                                                  class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300">
                                                {{ desafio.activo ? '🚫 Desactivar' : '✅ Activar' }}
                                            </Link>
                                            <Link :href="route('admin.desafios.asignar', desafio.id_desafio)"
                                                  method="post"
                                                  class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                👥 Asignar a Todos
                                            </Link>                                            <Link :href="route('admin.desafios.destroy', desafio.id_desafio)"
                                                  method="delete"
                                                  class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                                  @click="(e) => { if (!confirm('¿Estás seguro de eliminar este desafío?')) e.preventDefault() }">
                                                🗑️ Eliminar
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-if="desafios.length === 0" 
                             class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <p class="text-xl">📝 No hay desafíos creados aún.</p>
                            <p class="mt-2">Crea tu primer desafío para comenzar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    desafios: Array
})

const getTipoIcon = (tipo) => {
    const icons = {
        terminal: '🖥️',
        filesystem: '📁',
        permisos: '🔐',
        general: '🎯'
    }
    return icons[tipo] || '📝'
}

const getTipoLabel = (tipo) => {
    const labels = {
        terminal: 'Terminal',
        filesystem: 'Archivos',
        permisos: 'Permisos',
        general: 'General'
    }
    return labels[tipo] || 'Otro'
}

const getTipoClass = (tipo) => {
    const classes = {
        terminal: 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
        filesystem: 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
        permisos: 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300',
        general: 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
    }
    return classes[tipo] || 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
}
</script>
