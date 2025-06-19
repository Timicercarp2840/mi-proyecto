<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    usuario: Object,
    insignias_obtenidas: Array,
    todas_las_insignias: Array,
    estadisticas: Object
});

const porcentajeXP = computed(() => {
    const xpEnNivelActual = props.usuario.xp_total % 1000;
    return (xpEnNivelActual / 1000) * 100;
});

const getNivelTitulo = (nivel) => {
    switch(nivel) {
        case 1: return 'Novato Pingüino';
        case 2: return 'Explorador Linux';
        case 3: return 'Guardián del Sistema';
        case 4: return 'Doctor del Sistema';
        case 5: return 'Maestro de Redes';
        default: return 'Leyenda Linux';
    }
};

const insigniasObtenidas = computed(() => {
    return props.insignias_obtenidas.map(insignia => insignia.id_insignia);
});
</script>

<template>
    <Head title="Mi Perfil Gamer - SABLE" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <span class="text-3xl">🎮</span>
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Mi Perfil Gamer
                    </h2>
                    <p class="text-sm text-gray-600">Tu progreso en la aventura Linux</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-6xl sm:px-6 lg:px-8 space-y-6">
                <!-- Estadísticas principales -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- XP Total -->
                    <div class="bg-gradient-to-br from-purple-500 to-blue-600 rounded-lg p-6 text-white">
                        <div class="text-center">
                            <span class="text-3xl">⚡</span>
                            <h3 class="text-2xl font-bold mt-2">{{ usuario.xp_total }}</h3>
                            <p class="text-sm opacity-90">XP Total</p>
                        </div>
                    </div>

                    <!-- Nivel -->
                    <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-lg p-6 text-white">
                        <div class="text-center">
                            <span class="text-3xl">🎯</span>
                            <h3 class="text-2xl font-bold mt-2">{{ usuario.nivel_actual }}</h3>
                            <p class="text-sm opacity-90">Nivel Actual</p>
                        </div>
                    </div>

                    <!-- Insignias -->
                    <div class="bg-gradient-to-br from-yellow-500 to-orange-600 rounded-lg p-6 text-white">
                        <div class="text-center">
                            <span class="text-3xl">🏆</span>
                            <h3 class="text-2xl font-bold mt-2">{{ insignias_obtenidas.length }}</h3>
                            <p class="text-sm opacity-90">Insignias</p>
                        </div>
                    </div>

                    <!-- Módulos -->
                    <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-lg p-6 text-white">
                        <div class="text-center">
                            <span class="text-3xl">📚</span>
                            <h3 class="text-2xl font-bold mt-2">{{ estadisticas.modulos_completados }}/{{ estadisticas.modulos_totales }}</h3>
                            <p class="text-sm opacity-90">Módulos</p>
                        </div>
                    </div>
                </div>

                <!-- Progreso de Nivel -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ getNivelTitulo(usuario.nivel_actual) }}
                            </h3>
                            <span class="text-sm text-gray-600">
                                Nivel {{ usuario.nivel_actual }}
                            </span>
                        </div>
                        
                        <!-- Barra de progreso -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>{{ usuario.xp_total % 1000 }} / 1000 XP</span>
                                <span>{{ estadisticas.xp_siguiente_nivel }} XP para subir</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div 
                                    class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-500"
                                    :style="{ width: porcentajeXP + '%' }"
                                ></div>
                            </div>
                        </div>

                        <!-- Progreso de módulos -->
                        <div class="mt-6">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Progreso del Curso</span>
                                <span>{{ estadisticas.porcentaje_completado }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div 
                                    class="bg-gradient-to-r from-green-500 to-teal-600 h-2 rounded-full transition-all duration-500"
                                    :style="{ width: estadisticas.porcentaje_completado + '%' }"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colección de Insignias -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">
                            🏆 Colección de Insignias ({{ insignias_obtenidas.length }}/{{ todas_las_insignias.length }})
                        </h3>

                        <!-- Insignias por categoría -->
                        <div class="space-y-6">
                            <!-- Insignias de Nivel -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                                    <span class="mr-2">🎯</span>
                                    Insignias de Nivel
                                </h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                                    <div 
                                        v-for="insignia in todas_las_insignias.filter(i => i.tipo === 'nivel')" 
                                        :key="insignia.id_insignia"
                                        :class="[
                                            'p-4 rounded-lg text-center transition-all duration-300',
                                            insigniasObtenidas.includes(insignia.id_insignia) 
                                                ? 'bg-gradient-to-br from-yellow-100 to-orange-100 border-2 border-yellow-300 shadow-lg' 
                                                : 'bg-gray-100 border-2 border-gray-200 opacity-50'
                                        ]"
                                    >
                                        <div :class="insigniasObtenidas.includes(insignia.id_insignia) ? 'text-3xl' : 'text-2xl grayscale'">
                                            {{ insignia.icono }}
                                        </div>
                                        <h5 :class="[
                                            'text-xs font-medium mt-2',
                                            insigniasObtenidas.includes(insignia.id_insignia) ? 'text-gray-900' : 'text-gray-500'
                                        ]">
                                            {{ insignia.nombre }}
                                        </h5>
                                        <p :class="[
                                            'text-xs mt-1',
                                            insigniasObtenidas.includes(insignia.id_insignia) ? 'text-gray-700' : 'text-gray-400'
                                        ]">
                                            {{ insignia.descripcion }}
                                        </p>
                                        <div v-if="insigniasObtenidas.includes(insignia.id_insignia)" class="mt-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✅ Obtenida
                                            </span>
                                        </div>
                                        <div v-else class="mt-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                🔒 Bloqueada
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Insignias de Logro -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                                    <span class="mr-2">⭐</span>
                                    Insignias de Logro
                                </h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    <div 
                                        v-for="insignia in todas_las_insignias.filter(i => i.tipo === 'logro')" 
                                        :key="insignia.id_insignia"
                                        :class="[
                                            'p-4 rounded-lg text-center transition-all duration-300',
                                            insigniasObtenidas.includes(insignia.id_insignia) 
                                                ? 'bg-gradient-to-br from-blue-100 to-purple-100 border-2 border-blue-300 shadow-lg' 
                                                : 'bg-gray-100 border-2 border-gray-200 opacity-50'
                                        ]"
                                    >
                                        <div :class="insigniasObtenidas.includes(insignia.id_insignia) ? 'text-3xl' : 'text-2xl grayscale'">
                                            {{ insignia.icono }}
                                        </div>
                                        <h5 :class="[
                                            'text-xs font-medium mt-2',
                                            insigniasObtenidas.includes(insignia.id_insignia) ? 'text-gray-900' : 'text-gray-500'
                                        ]">
                                            {{ insignia.nombre }}
                                        </h5>
                                        <div v-if="insigniasObtenidas.includes(insignia.id_insignia)" class="mt-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✅ Obtenida
                                            </span>
                                        </div>
                                        <div v-else class="mt-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                🔒 Bloqueada
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Insignias Especiales -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                                    <span class="mr-2">👑</span>
                                    Insignias Especiales
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    <div 
                                        v-for="insignia in todas_las_insignias.filter(i => i.tipo === 'especial')" 
                                        :key="insignia.id_insignia"
                                        :class="[
                                            'p-6 rounded-lg text-center transition-all duration-300',
                                            insigniasObtenidas.includes(insignia.id_insignia) 
                                                ? 'bg-gradient-to-br from-yellow-200 to-orange-200 border-2 border-yellow-400 shadow-xl' 
                                                : 'bg-gray-100 border-2 border-gray-200 opacity-50'
                                        ]"
                                    >
                                        <div :class="insigniasObtenidas.includes(insignia.id_insignia) ? 'text-4xl' : 'text-3xl grayscale'">
                                            {{ insignia.icono }}
                                        </div>
                                        <h5 :class="[
                                            'text-sm font-bold mt-3',
                                            insigniasObtenidas.includes(insignia.id_insignia) ? 'text-gray-900' : 'text-gray-500'
                                        ]">
                                            {{ insignia.nombre }}
                                        </h5>
                                        <p :class="[
                                            'text-xs mt-2',
                                            insigniasObtenidas.includes(insignia.id_insignia) ? 'text-gray-700' : 'text-gray-400'
                                        ]">
                                            {{ insignia.descripcion }}
                                        </p>
                                        <div class="mt-3">
                                            <span :class="[
                                                'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium',
                                                insigniasObtenidas.includes(insignia.id_insignia) 
                                                    ? 'bg-yellow-100 text-yellow-800' 
                                                    : 'bg-gray-100 text-gray-600'
                                            ]">
                                                {{ insigniasObtenidas.includes(insignia.id_insignia) ? '👑 Especial' : '🔒 Requiere ' + insignia.xp_requerido + ' XP' }}
                                            </span>
                                        </div>
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
