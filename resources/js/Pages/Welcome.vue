<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { useRoute } from '../composables/useRoute.js';

const { route } = useRoute();

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="SABLE - Sistema de Aprendizaje de Base Linux Educativa" />
    
    <div class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-purple-900">
        <!-- Navegación -->
        <nav class="flex justify-between items-center p-6">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <span class="text-blue-900 font-bold text-xl">🐧</span>
                </div>
                <span class="text-white text-2xl font-bold">SABLE</span>
            </div>
            
            <div v-if="canLogin" class="space-x-4">
                <Link
                    :href="route('login')"
                    class="text-white hover:text-blue-200 font-medium"
                >
                    Iniciar Sesión
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="bg-white text-blue-900 px-6 py-2 rounded-lg font-medium hover:bg-blue-50 transition duration-300"
                >
                    Registrarse
                </Link>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="container mx-auto px-6 py-20">
            <div class="text-center">
                <!-- Logo principal -->
                <div class="mb-8">
                    <div class="w-32 h-32 mx-auto bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <span class="text-6xl">🐧</span>
                    </div>
                </div>

                <!-- Título principal -->
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">
                    <span class="bg-gradient-to-r from-blue-200 to-green-200 bg-clip-text text-transparent">
                        SABLE
                    </span>
                </h1>
                
                <h2 class="text-xl md:text-2xl text-blue-200 mb-8 max-w-3xl mx-auto">
                    Sistema de Aprendizaje de Base Linux Educativa
                </h2>

                <!-- Descripción -->
                <p class="text-lg text-blue-100 mb-12 max-w-2xl mx-auto leading-relaxed">
                    Aprende Linux de forma interactiva con módulos estructurados, evaluaciones prácticas 
                    y seguimiento de progreso personalizado. ¡Domina la terminal como un profesional!
                </p>

                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:from-green-600 hover:to-blue-600 transform hover:scale-105 transition duration-300 shadow-lg"
                    >
                        🚀 Comenzar Gratis
                    </Link>
                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white/20 transition duration-300 border border-white/20"
                    >
                        🔑 Acceder
                    </Link>
                </div>
            </div>
        </div>

        <!-- Características principales -->
        <div class="container mx-auto px-6 py-16">
            <h3 class="text-3xl font-bold text-white text-center mb-12">
                ¿Por qué elegir SABLE?
            </h3>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Característica 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">📚</span>
                    </div>
                    <h4 class="text-xl font-semibold text-white mb-3">
                        Aprendizaje Estructurado
                    </h4>
                    <p class="text-blue-200">
                        Módulos organizados por nivel de dificultad, desde conceptos básicos hasta administración avanzada.
                    </p>
                </div>

                <!-- Característica 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">⚡</span>
                    </div>
                    <h4 class="text-xl font-semibold text-white mb-3">
                        Evaluaciones Interactivas
                    </h4>
                    <p class="text-blue-200">
                        Pon a prueba tus conocimientos con evaluaciones prácticas y recibe retroalimentación inmediata.
                    </p>
                </div>

                <!-- Característica 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">📊</span>
                    </div>
                    <h4 class="text-xl font-semibold text-white mb-3">
                        Seguimiento de Progreso
                    </h4>
                    <p class="text-blue-200">
                        Monitorea tu avance, identifica áreas de mejora y celebra tus logros.
                    </p>
                </div>
            </div>
        </div>

        <!-- Módulos de aprendizaje -->
        <div class="container mx-auto px-6 py-16">
            <h3 class="text-3xl font-bold text-white text-center mb-12">
                Módulos de Aprendizaje
            </h3>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                    <div class="flex items-center mb-4">
                        <span class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">1</span>
                        <h4 class="text-lg font-semibold text-white">Introducción a Linux</h4>
                    </div>
                    <p class="text-blue-200 text-sm">
                        Historia, distribuciones y conceptos fundamentales del sistema operativo Linux.
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                    <div class="flex items-center mb-4">
                        <span class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">2</span>
                        <h4 class="text-lg font-semibold text-white">Sistema de Archivos</h4>
                    </div>
                    <p class="text-blue-200 text-sm">
                        Navegación, gestión de archivos y directorios con comandos esenciales.
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                    <div class="flex items-center mb-4">
                        <span class="bg-yellow-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">3</span>
                        <h4 class="text-lg font-semibold text-white">Permisos y Usuarios</h4>
                    </div>
                    <p class="text-blue-200 text-sm">
                        Gestión de usuarios, grupos y permisos de archivos y directorios.
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                    <div class="flex items-center mb-4">
                        <span class="bg-purple-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">4</span>
                        <h4 class="text-lg font-semibold text-white">Procesos y Servicios</h4>
                    </div>
                    <p class="text-blue-200 text-sm">
                        Monitoreo y gestión de procesos, servicios del sistema y automatización.
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                    <div class="flex items-center mb-4">
                        <span class="bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">5</span>
                        <h4 class="text-lg font-semibold text-white">Redes en Linux</h4>
                    </div>
                    <p class="text-blue-200 text-sm">
                        Configuración de red, diagnóstico y herramientas de administración.
                    </p>
                </div>

                <div class="bg-gradient-to-r from-green-500/20 to-blue-500/20 backdrop-blur-sm rounded-lg p-6 border border-green-300/20">
                    <div class="text-center">
                        <span class="text-3xl mb-3 block">🎯</span>
                        <h4 class="text-lg font-semibold text-white mb-2">¡Y mucho más!</h4>
                        <p class="text-green-200 text-sm">
                            Contenido en constante actualización para mantenerte al día.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="border-t border-white/20 py-8">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <span class="text-blue-900 font-bold">🐧</span>
                        </div>
                        <span class="text-white font-semibold">SABLE</span>
                        <span class="text-blue-200 text-sm">v1.0</span>
                    </div>
                    
                    <div class="text-center text-blue-200 text-sm">
                        <p>&copy; 2025 SABLE. Sistema de Aprendizaje de Base Linux Educativa.</p>
                        <p class="mt-1">Construido con ❤️ usando Laravel {{ laravelVersion }} y PHP {{ phpVersion }}</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
