<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    usuario: Object,
    insignias_obtenidas: Array,
    todas_las_insignias: Array,
    estadisticas: Object,
    progreso_modulos: Array,
    progresos: Array, // Para compatibilidad con Mi Progreso
    totalModulos: Number,
    modulosCompletados: Number,
    porcentajeProgreso: Number
});

const editandoPerfil = ref(false);
const mostrandoProgreso = ref(false);

const form = useForm({
    name: props.usuario.name,
    email: props.usuario.email,
    telefono: props.usuario.telefono || '',
    username: props.usuario.username || props.usuario.name,
    password: '',
    password_confirmation: ''
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

const modulosCompletados = computed(() => {
    return props.progreso_modulos?.filter(p => p.estado === 'completado').length || 0;
});

const modulosTotales = computed(() => {
    return props.progreso_modulos?.length || 0;
});

const porcentajeModulos = computed(() => {
    if (modulosTotales.value === 0) return 0;
    return (modulosCompletados.value / modulosTotales.value) * 100;
});

const guardarPerfil = () => {
    form.patch(route('profile.update'), {
        onSuccess: () => {
            editandoPerfil.value = false;
            form.reset('password', 'password_confirmation');
        },
        onError: (errors) => {
            console.log('Errores de validación:', errors);
        }
    });
};

const getEstadoColor = (estado) => {
    return estado === 'completado' ? 'text-green-600' : 
           estado === 'en_progreso' ? 'text-yellow-600' : 'text-gray-400';
};

const getEstadoIcono = (estado) => {
    return estado === 'completado' ? '✅' : 
           estado === 'en_progreso' ? '⏳' : '⭕';
};
</script>

<template>
    <Head title="Mi Perfil - SABLE" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-3xl">🎮</span>
                    <div>
                        <h2 class="text-xl font-semibold leading-tight text-gray-800">
                            Mi Perfil
                        </h2>
                        <p class="text-sm text-gray-600">Tu progreso y configuración de cuenta</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button
                        @click="editandoPerfil = !editandoPerfil"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                    >
                        {{ editandoPerfil ? '❌ Cancelar' : '✏️ Editar Perfil' }}
                    </button>
                    <button
                        @click="mostrandoProgreso = !mostrandoProgreso"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium"
                    >
                        {{ mostrandoProgreso ? '📊 Estadísticas' : '📚 Ver Módulos' }}
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-6xl sm:px-6 lg:px-8 space-y-6">
                
                <!-- Formulario de edición del perfil -->
                <div v-if="editandoPerfil" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">✏️ Editar Información Personal</h3>
                    </div>
                    <form @submit.prevent="guardarPerfil" class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre completo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                />
                                <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                            </div>

                            <!-- Username -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de Usuario</label>
                                <input
                                    v-model="form.username"
                                    type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <div v-if="form.errors.username" class="text-red-500 text-sm mt-1">{{ form.errors.username }}</div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                />
                                <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Número de Teléfono</label>
                                <input
                                    v-model="form.telefono"
                                    type="tel"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Opcional"
                                />
                                <div v-if="form.errors.telefono" class="text-red-500 text-sm mt-1">{{ form.errors.telefono }}</div>
                            </div>

                            <!-- Nueva contraseña -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                                <input
                                    v-model="form.password"
                                    type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Dejar vacío para mantener actual"
                                />
                                <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
                            </div>

                            <!-- Confirmar contraseña -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                                <input
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Solo si cambias la contraseña"
                                />
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button
                                type="button"
                                @click="editandoPerfil = false"
                                class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
                            >
                                Cancelar
                            </button>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
                            >
                                {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
                            </button>
                        </div>
                    </form>
                </div>                <!-- Vista de progreso de módulos (contenido completo de Mi Progreso) -->
                <div v-if="mostrandoProgreso" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white">📚 Mi Progreso de Aprendizaje</h3>
                    </div>
                    <div class="p-6">
                        <!-- Resumen general -->
                        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-3">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 text-center border border-blue-200">
                                <div class="text-3xl font-bold text-blue-600 mb-2">{{ porcentajeProgreso }}%</div>
                                <div class="text-sm text-blue-700">Progreso General</div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 text-center border border-green-200">
                                <div class="text-3xl font-bold text-green-600 mb-2">{{ modulosCompletados }}</div>
                                <div class="text-sm text-green-700">Módulos Completados</div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 text-center border border-gray-200">
                                <div class="text-3xl font-bold text-gray-600 mb-2">{{ totalModulos }}</div>
                                <div class="text-sm text-gray-700">Total Módulos</div>
                            </div>
                        </div>

                        <!-- Barra de progreso visual -->
                        <div class="mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">📊 Progreso Visual</h4>
                            <div class="w-full bg-gray-200 rounded-full h-6 mb-4">
                                <div 
                                    class="bg-gradient-to-r from-blue-500 to-green-500 h-6 rounded-full transition-all duration-500 flex items-center justify-center" 
                                    :style="{ width: porcentajeProgreso + '%' }"
                                >
                                    <span v-if="porcentajeProgreso > 15" class="text-white text-xs font-semibold">
                                        {{ porcentajeProgreso }}%
                                    </span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">
                                ¡Sigue así! Has completado {{ modulosCompletados }} de {{ totalModulos }} módulos.
                            </p>
                        </div>

                        <!-- Detalle por módulo -->
                        <div class="mb-8">
                            <h4 class="text-lg font-medium text-gray-900 mb-6">📋 Progreso Detallado por Módulo</h4>
                            
                            <div v-if="progreso_modulos && progreso_modulos.length > 0" class="space-y-4">
                                <div 
                                    v-for="progreso in progreso_modulos" 
                                    :key="progreso.id_modulo"
                                    class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                                >
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-medium">
                                                    {{ progreso.modulo.nivel }}
                                                </span>
                                                <div>
                                                    <h5 class="text-lg font-medium text-gray-900">
                                                        {{ progreso.modulo.titulo }}
                                                    </h5>
                                                    <p class="text-sm text-gray-600">
                                                        {{ progreso.modulo.descripcion }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-4">
                                            <!-- Estado -->
                                            <div class="text-center">
                                                <div 
                                                    v-if="progreso.estado === 'completado'"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                                >
                                                    ✓ Completado
                                                </div>
                                                <div 
                                                    v-else-if="progreso.estado === 'en_progreso'"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                                                >
                                                    📚 En Proceso
                                                </div>
                                                <div 
                                                    v-else
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                                >
                                                    ⭕ No Iniciado
                                                </div>
                                            </div>
                                            
                                            <!-- Puntuación -->
                                            <div v-if="progreso.puntuacion" class="text-center">
                                                <div class="text-lg font-bold text-gray-900">
                                                    {{ progreso.puntuacion }}%
                                                </div>
                                                <div class="text-xs text-gray-500">Puntuación</div>
                                            </div>
                                            
                                            <!-- Acciones -->
                                            <div>
                                                <Link 
                                                    :href="route('modulos.show', progreso.modulo.id_modulo)"
                                                    class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                >
                                                    <span v-if="progreso.estado === 'completado'">
                                                        Revisar
                                                    </span>
                                                    <span v-else>
                                                        Continuar
                                                    </span>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fecha de actualización -->
                                    <div class="mt-3 text-xs text-gray-500">
                                        Última actualización: {{ new Date(progreso.updated_at).toLocaleDateString('es-ES', { 
                                            year: 'numeric', 
                                            month: 'long', 
                                            day: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        }) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Estado si no hay progreso -->
                            <div v-if="!progreso_modulos || progreso_modulos.length === 0" class="text-center py-12">
                                <div class="text-6xl mb-4">📚</div>
                                <h4 class="text-lg font-medium text-gray-900 mb-2">
                                    ¡Comienza tu Aventura de Aprendizaje!
                                </h4>
                                <p class="text-gray-600 mb-6">
                                    Aún no has comenzado ningún módulo. ¡Es hora de empezar!
                                </p>
                                <Link 
                                    :href="route('modulos.index')"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    Ver Módulos Disponibles
                                </Link>
                            </div>
                        </div>

                        <!-- Consejos motivacionales -->
                        <div class="bg-gradient-to-r from-blue-50 to-green-50 border border-blue-200 rounded-lg p-6">
                            <h4 class="text-lg font-medium text-blue-900 mb-4">
                                💪 ¡Sigue Adelante!
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <h5 class="font-medium text-blue-800 mb-2">Consejos para el Éxito:</h5>
                                    <ul class="text-blue-700 space-y-1">
                                        <li>• Practica los comandos regularmente</li>
                                        <li>• Completa las evaluaciones para consolidar conocimientos</li>
                                        <li>• No tengas miedo de repetir módulos</li>
                                    </ul>
                                </div>
                                <div>
                                    <h5 class="font-medium text-green-800 mb-2">Tu Progreso:</h5>
                                    <ul class="text-green-700 space-y-1">
                                        <li v-if="porcentajeProgreso >= 80">• ¡Excelente! Estás muy cerca del final</li>
                                        <li v-else-if="porcentajeProgreso >= 50">• ¡Muy bien! Vas por la mitad del camino</li>
                                        <li v-else-if="porcentajeProgreso >= 25">• ¡Buen comienzo! Sigue así</li>
                                        <li v-else>• ¡Es el momento perfecto para comenzar!</li>
                                        <li>• Cada módulo completado es un logro</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas principales (vista por defecto) -->
                <div v-if="!editandoPerfil && !mostrandoProgreso">
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
                                <h3 class="text-2xl font-bold mt-2">{{ modulosCompletados }}/{{ modulosTotales }}</h3>
                                <p class="text-sm opacity-90">Módulos</p>
                            </div>
                        </div>
                    </div>                    <!-- Progreso de Nivel -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ getNivelTitulo(usuario.nivel_actual) }}
                                </h3>
                                <span class="text-sm text-gray-600">
                                    Nivel {{ usuario.nivel_actual }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div 
                                    class="bg-gradient-to-r from-purple-500 to-blue-600 h-4 rounded-full transition-all duration-500"
                                    :style="`width: ${porcentajeXP}%`"
                                ></div>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 mt-2">
                                <span>{{ usuario.xp_total % 1000 }} XP</span>
                                <span>1000 XP</span>
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
