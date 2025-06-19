<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    usuarios: Array
});

const getPosicionEmoji = (index) => {
    switch(index) {
        case 0: return '🥇';
        case 1: return '🥈';
        case 2: return '🥉';
        default: return `${index + 1}°`;
    }
};

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
</script>

<template>
    <Head title="Tabla de Clasificación - SABLE" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <span class="text-3xl">🏆</span>
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Tabla de Clasificación
                    </h2>
                    <p class="text-sm text-gray-600">Los pingüinos más destacados de SABLE</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Podio Top 3 -->
                        <div v-if="usuarios.length >= 3" class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-6 text-center">
                                🏆 Podio de Campeones 🏆
                            </h3>
                            <div class="flex justify-center items-end space-x-4">
                                <!-- Segundo lugar -->
                                <div v-if="usuarios[1]" class="text-center">
                                    <div class="bg-gray-100 rounded-lg p-4 h-32 flex flex-col justify-center items-center border-2 border-gray-300">
                                        <span class="text-2xl mb-2">🥈</span>
                                        <p class="font-medium text-sm">{{ usuarios[1].name }}</p>
                                        <p class="text-xs text-gray-600">{{ usuarios[1].xp_total }} XP</p>
                                        <p class="text-xs text-blue-600">Nivel {{ usuarios[1].nivel_actual }}</p>
                                    </div>
                                </div>
                                
                                <!-- Primer lugar -->
                                <div v-if="usuarios[0]" class="text-center">
                                    <div class="bg-gradient-to-b from-yellow-100 to-yellow-200 rounded-lg p-6 h-40 flex flex-col justify-center items-center border-2 border-yellow-400 shadow-lg">
                                        <span class="text-3xl mb-2">👑</span>
                                        <p class="font-bold text-lg">{{ usuarios[0].name }}</p>
                                        <p class="text-sm text-gray-700">{{ usuarios[0].xp_total }} XP</p>
                                        <p class="text-sm text-purple-600 font-medium">{{ getNivelTitulo(usuarios[0].nivel_actual) }}</p>
                                    </div>
                                </div>
                                
                                <!-- Tercer lugar -->
                                <div v-if="usuarios[2]" class="text-center">
                                    <div class="bg-orange-50 rounded-lg p-4 h-32 flex flex-col justify-center items-center border-2 border-orange-300">
                                        <span class="text-2xl mb-2">🥉</span>
                                        <p class="font-medium text-sm">{{ usuarios[2].name }}</p>
                                        <p class="text-xs text-gray-600">{{ usuarios[2].xp_total }} XP</p>
                                        <p class="text-xs text-blue-600">Nivel {{ usuarios[2].nivel_actual }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla completa -->
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                📊 Clasificación Completa
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Posición
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Estudiante
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                XP Total
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nivel
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Insignias
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr 
                                            v-for="(usuario, index) in usuarios" 
                                            :key="usuario.id"
                                            :class="index < 3 ? 'bg-gradient-to-r from-blue-50 to-purple-50' : ''"
                                        >
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <span class="text-lg">{{ getPosicionEmoji(index) }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8">
                                                        <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold">
                                                            {{ usuario.name.charAt(0).toUpperCase() }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ usuario.name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ getNivelTitulo(usuario.nivel_actual) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-purple-600">
                                                    {{ usuario.xp_total }} XP
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Nivel {{ usuario.nivel_actual }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex space-x-1">
                                                    <span 
                                                        v-for="insignia in usuario.insignias.slice(0, 3)" 
                                                        :key="insignia.id_insignia"
                                                        class="text-lg"
                                                        :title="insignia.nombre"
                                                    >
                                                        {{ insignia.icono }}
                                                    </span>
                                                    <span v-if="usuario.insignias.length > 3" class="text-xs text-gray-500">
                                                        +{{ usuario.insignias.length - 3 }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div v-if="usuarios.length === 0" class="text-center py-8">
                            <span class="text-6xl mb-4 block">🐧</span>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                ¡Sé el primero en aparecer aquí!
                            </h3>
                            <p class="text-gray-600">
                                Completa módulos y evaluaciones para ganar XP y subir en la clasificación.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
