<template>
    <Head title="Gestión de Desafíos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🎮 Gestión de Desafíos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">Desafíos Interactivos</h3>
                            <Link 
                                :href="route('admin.desafios.create')"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center"
                            >
                                <span class="mr-2">➕</span>
                                Crear Desafío
                            </Link>
                        </div>

                        <!-- Filtros -->
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Filtrar por tipo:</label>
                                <select v-model="filtroTipo" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700">
                                    <option value="">Todos los tipos</option>
                                    <option value="terminal">Terminal</option>
                                    <option value="filesystem">Sistema de Archivos</option>
                                    <option value="permisos">Permisos</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Filtrar por nivel:</label>
                                <select v-model="filtroNivel" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700">
                                    <option value="">Todos los niveles</option>
                                    <option value="1">Principiante</option>
                                    <option value="2">Intermedio</option>
                                    <option value="3">Avanzado</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Estado:</label>
                                <select v-model="filtroEstado" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700">
                                    <option value="">Todos</option>
                                    <option value="true">Activos</option>
                                    <option value="false">Inactivos</option>
                                </select>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Título
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
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="desafio in desafiosFiltrados" :key="desafio.id_desafio">
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="font-medium">{{ desafio.titulo }}</div>
                                            <div class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ desafio.descripcion.substring(0, 80) }}...</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="getTipoClasses(desafio.tipo)">
                                                {{ getTipoEmoji(desafio.tipo) }} {{ getTipoTexto(desafio.tipo) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="getNivelClasses(desafio.nivel)">
                                                {{ getNivelTexto(desafio.nivel) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <span class="font-medium">{{ desafio.xp_recompensa }} XP</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                  :class="desafio.activo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'">
                                                {{ desafio.activo ? '✅ Activo' : '❌ Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <Link 
                                                    :href="route('admin.desafios.edit', desafio.id_desafio)"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                >
                                                    ✏️ Editar
                                                </Link>
                                                <button 
                                                    @click="toggleEstado(desafio)"
                                                    class="text-yellow-600 hover:text-yellow-900"
                                                >
                                                    {{ desafio.activo ? '⏸️ Desactivar' : '▶️ Activar' }}
                                                </button>
                                                <button 
                                                    @click="eliminarDesafio(desafio.id_desafio)"
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

                        <div v-if="desafiosFiltrados.length === 0" class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">No se encontraron desafíos con los filtros aplicados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    desafios: Array,
});

const filtroTipo = ref('');
const filtroNivel = ref('');
const filtroEstado = ref('');

const desafiosFiltrados = computed(() => {
    let filtered = props.desafios || [];
    
    if (filtroTipo.value) {
        filtered = filtered.filter(d => d.tipo === filtroTipo.value);
    }
    
    if (filtroNivel.value) {
        filtered = filtered.filter(d => d.nivel == filtroNivel.value);
    }
    
    if (filtroEstado.value !== '') {
        filtered = filtered.filter(d => d.activo == (filtroEstado.value === 'true'));
    }
    
    return filtered;
});

const getTipoEmoji = (tipo) => {
    const emojis = {
        'terminal': '💻',
        'filesystem': '📁',
        'permisos': '🔐'
    };
    return emojis[tipo] || '❓';
};

const getTipoTexto = (tipo) => {
    const textos = {
        'terminal': 'Terminal',
        'filesystem': 'Sistema de Archivos',
        'permisos': 'Permisos'
    };
    return textos[tipo] || tipo;
};

const getTipoClasses = (tipo) => {
    const classes = {
        'terminal': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        'filesystem': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'permisos': 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
    };
    return classes[tipo] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
};

const getNivelTexto = (nivel) => {
    const niveles = {
        1: 'Principiante',
        2: 'Intermedio',
        3: 'Avanzado'
    };
    return niveles[nivel] || 'Desconocido';
};

const getNivelClasses = (nivel) => {
    const classes = {
        1: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        2: 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
        3: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
    };
    return classes[nivel] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
};

const toggleEstado = (desafio) => {
    router.patch(route('admin.desafios.update', desafio.id_desafio), {
        ...desafio,
        activo: !desafio.activo
    });
};

const eliminarDesafio = (id) => {
    if (confirm('¿Estás seguro de que quieres eliminar este desafío?')) {
        router.delete(route('admin.desafios.destroy', id));
    }
};
</script>
