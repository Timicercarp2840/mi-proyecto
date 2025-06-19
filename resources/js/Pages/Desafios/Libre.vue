<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const desafios = [
    {
        tipo: 'terminal',
        titulo: 'Terminal Interactivo',
        descripcion: 'Practica comandos básicos de terminal Linux en un entorno interactivo',
        icono: '🖥️',
        color: 'blue',
        niveles: [
            { nombre: 'Básico', descripcion: 'Comandos fundamentales: ls, cd, pwd, mkdir', puntos: '10-25 XP' },
            { nombre: 'Intermedio', descripcion: 'Manipulación de archivos y pipes', puntos: '25-50 XP' },
            { nombre: 'Avanzado', descripcion: 'Scripts y comandos complejos', puntos: '50-100 XP' }
        ],
        ruta: 'desafios.terminal'
    },
    {
        tipo: 'filesystem',
        titulo: 'Sistema de Archivos',
        descripcion: 'Explora y manipula el sistema de archivos Linux',
        icono: '📁',
        color: 'green',
        niveles: [
            { nombre: 'Básico', descripcion: 'Navegación y estructura básica', puntos: '10-25 XP' },
            { nombre: 'Intermedio', descripcion: 'Permisos y propiedades de archivos', puntos: '25-50 XP' },
            { nombre: 'Avanzado', descripcion: 'Links simbólicos y montaje', puntos: '50-100 XP' }
        ],
        ruta: 'desafios.filesystem'
    },
    {
        tipo: 'permisos',
        titulo: 'Permisos y Seguridad',
        descripcion: 'Aprende a gestionar permisos de archivos y directorios',
        icono: '🔐',
        color: 'orange',
        niveles: [
            { nombre: 'Básico', descripcion: 'chmod, chown básicos', puntos: '15-30 XP' },
            { nombre: 'Intermedio', descripcion: 'Permisos especiales y ACLs', puntos: '30-60 XP' },
            { nombre: 'Avanzado', descripcion: 'Seguridad avanzada del sistema', puntos: '60-120 XP' }
        ],
        ruta: 'desafios.permisos'
    },
    {
        tipo: 'muro-comandos',
        titulo: 'Muro de Comandos',
        descripcion: 'Comparte y descubre comandos útiles con la comunidad',
        icono: '🏆',
        color: 'purple',
        niveles: [
            { nombre: 'Comunidad', descripcion: 'Comparte y vota comandos útiles', puntos: '5-50 XP' }
        ],
        ruta: 'desafios.muro-comandos'
    }
];

const getColorClasses = (color) => {
    const colors = {
        blue: 'from-blue-500 to-blue-600 border-blue-300 hover:border-blue-400',
        green: 'from-green-500 to-green-600 border-green-300 hover:border-green-400',
        orange: 'from-orange-500 to-orange-600 border-orange-300 hover:border-orange-400',
        purple: 'from-purple-500 to-purple-600 border-purple-300 hover:border-purple-400'
    };
    return colors[color] || colors.blue;
};

const getBgColor = (color) => {
    const colors = {
        blue: 'bg-blue-50',
        green: 'bg-green-50',
        orange: 'bg-orange-50',
        purple: 'bg-purple-50'
    };
    return colors[color] || colors.blue;
};
</script>

<template>
    <Head title="Desafíos Libre - SABLE" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        🎮 Desafíos Libre
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Practica tus habilidades de Linux en diferentes áreas</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
                <!-- Introducción -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-8">
                        <h3 class="text-2xl font-bold text-white text-center">
                            🚀 ¡Mejora tus habilidades con desafíos libres!
                        </h3>
                        <p class="text-indigo-100 text-center mt-2">
                            Elige el área que quieras practicar y avanza a tu propio ritmo
                        </p>
                    </div>
                </div>

                <!-- Grid de desafíos -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div 
                        v-for="desafio in desafios" 
                        :key="desafio.tipo"
                        :class="`${getBgColor(desafio.color)} border-2 rounded-xl p-6 transition-all duration-300 hover:shadow-lg ${getColorClasses(desafio.color).split(' ').slice(2).join(' ')}`"
                    >
                        <!-- Header del desafío -->
                        <div class="flex items-center mb-4">
                            <div class="text-4xl mr-4">{{ desafio.icono }}</div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ desafio.titulo }}</h3>
                                <p class="text-gray-600 text-sm">{{ desafio.descripcion }}</p>
                            </div>
                        </div>                        <!-- Niveles disponibles -->
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Niveles disponibles:</h4>
                            <div class="space-y-2">
                                <div 
                                    v-for="nivel in desafio.niveles" 
                                    :key="nivel.nombre"
                                    class="flex items-center justify-between p-3 bg-white rounded-lg border"
                                >
                                    <div>
                                        <span class="font-medium text-gray-900">{{ nivel.nombre }}</span>
                                        <p class="text-xs text-gray-600 mt-1">{{ nivel.descripcion }}</p>
                                    </div>
                                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                        {{ nivel.puntos }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Estadísticas rápidas -->
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-900">{{ $page.props.auth.user.xp_total || 0 }}</div>
                                <div class="text-xs text-gray-600">XP Total</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-900">{{ $page.props.auth.user.nivel_actual || 1 }}</div>
                                <div class="text-xs text-gray-600">Nivel</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-900">0</div>
                                <div class="text-xs text-gray-600">Completados</div>
                            </div>
                        </div>

                        <!-- Botón de acceso -->
                        <Link 
                            :href="route(desafio.ruta)"
                            :class="`w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r ${getColorClasses(desafio.color).split(' ').slice(0, 2).join(' ')} border border-transparent rounded-lg font-bold text-white hover:shadow-lg transform hover:scale-105 transition-all duration-200`"
                        >
                            <span class="mr-2">{{ desafio.icono }}</span>
                            Comenzar Desafío
                        </Link>
                    </div>
                </div>

                <!-- Estadísticas generales del usuario -->
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">📊 Tu Progreso Global</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid md:grid-cols-4 gap-6">
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $page.props.auth.user.xp_total || 0 }}</div>
                                <div class="text-sm text-gray-600">XP Total</div>
                            </div>
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">{{ $page.props.auth.user.nivel_actual || 1 }}</div>
                                <div class="text-sm text-gray-600">Nivel Actual</div>
                            </div>
                            <div class="text-center p-4 bg-purple-50 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600">0</div>
                                <div class="text-sm text-gray-600">Badges Obtenidas</div>
                            </div>
                            <div class="text-center p-4 bg-orange-50 rounded-lg">
                                <div class="text-2xl font-bold text-orange-600">0</div>
                                <div class="text-sm text-gray-600">Desafíos Completados</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
