<template>
    <Head title="Mi Perfil Completo" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Mi Perfil Completo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <!-- Tabs de navegación -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <nav class="-mb-px flex space-x-8">
                                <button
                                    @click="activeTab = 'perfil'"
                                    :class="[
                                        activeTab === 'perfil'
                                            ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                                            : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600',
                                        'whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm'
                                    ]"
                                >
                                    👤 Mi Perfil
                                </button>
                                <button
                                    @click="activeTab = 'progreso'"
                                    :class="[
                                        activeTab === 'progreso'
                                            ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                                            : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600',
                                        'whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm'
                                    ]"
                                >
                                    📊 Mi Progreso
                                </button>
                                <button
                                    @click="activeTab = 'gamer'"
                                    :class="[
                                        activeTab === 'gamer'
                                            ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                                            : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600',
                                        'whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm'
                                    ]"
                                >
                                    🎮 Perfil Gamer
                                </button>
                                <button
                                    @click="activeTab = 'ranking'"
                                    :class="[
                                        activeTab === 'ranking'
                                            ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                                            : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600',
                                        'whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm'
                                    ]"
                                >
                                    🏆 Clasificación
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Contenido de la pestaña activa -->
                
                <!-- Tab: Mi Perfil -->
                <div v-show="activeTab === 'perfil'" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="max-w-xl">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Información del Perfil
                            </h3>
                            
                            <form @submit.prevent="updateProfile">
                                <div class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Nombre
                                        </label>
                                        <input
                                            id="name"
                                            v-model="profileForm.name"
                                            type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Email
                                        </label>
                                        <input
                                            id="email"
                                            v-model="profileForm.email"
                                            type="email"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required
                                        />
                                    </div>

                                    <div class="flex items-center justify-end">
                                        <button
                                            type="submit"
                                            :disabled="profileForm.processing"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 disabled:opacity-50"
                                        >
                                            {{ profileForm.processing ? 'Guardando...' : 'Guardar' }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab: Mi Progreso -->
                <div v-show="activeTab === 'progreso'" class="space-y-6">
                    <!-- Resumen del progreso -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                📊 Resumen de Mi Progreso
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">                                <div class="bg-blue-50 dark:bg-blue-900/50 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Módulos Completados</h4>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">
                                        {{ modulosCompletados }} / {{ totalModulos }}
                                    </p>
                                    <div class="w-full bg-blue-200 dark:bg-blue-800 rounded-full h-2 mt-2">
                                        <div 
                                            class="bg-blue-600 dark:bg-blue-400 h-2 rounded-full transition-all duration-500"
                                            :style="`width: ${totalModulos > 0 ? (modulosCompletados / totalModulos) * 100 : 0}%`"
                                        ></div>
                                    </div>
                                </div>
                                
                                <div class="bg-green-50 dark:bg-green-900/50 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-green-800 dark:text-green-200">Evaluaciones Aprobadas</h4>
                                    <p class="text-2xl font-bold text-green-600 dark:text-green-300">
                                        {{ evaluacionesAprobadas }}
                                    </p>
                                </div>
                                
                                <div class="bg-purple-50 dark:bg-purple-900/50 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-purple-800 dark:text-purple-200">Promedio General</h4>
                                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-300">
                                        {{ promedioGeneral }}%
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>                    <!-- Lista detallada de módulos -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                📚 Progreso por Módulos
                            </h3>
                            
                            <div v-if="progresos && progresos.length > 0" class="space-y-4">
                                <div 
                                    v-for="progreso in progresos" 
                                    :key="progreso.id"
                                    class="border border-gray-200 dark:border-gray-600 rounded-lg p-4"
                                >
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ progreso.modulo?.titulo || 'Módulo sin título' }}
                                            </h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                {{ progreso.modulo?.descripcion || 'Sin descripción' }}
                                            </p>
                                            <div class="flex items-center mt-2 space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                                <span>Iniciado: {{ progreso.fecha_inicio ? new Date(progreso.fecha_inicio).toLocaleDateString() : 'N/A' }}</span>
                                                <span v-if="progreso.fecha_completado">
                                                    Completado: {{ new Date(progreso.fecha_completado).toLocaleDateString() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right ml-4">
                                            <span :class="getEstadoClass(progreso.estado)">
                                                {{ getEstadoTexto(progreso.estado) }}
                                            </span>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                Puntuación: 
                                                <span :class="progreso.puntuacion >= 60 ? 'text-green-600 dark:text-green-400 font-medium' : 'text-red-600 dark:text-red-400'">
                                                    {{ progreso.puntuacion || 'Sin calificar' }}
                                                    <span v-if="progreso.puntuacion">%</span>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div v-else class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p class="text-xl">📚</p>
                                <p class="mt-2">¡Aún no tienes progreso en módulos!</p>
                                <p class="text-sm">Ve a la sección de Módulos para comenzar tu aprendizaje.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progreso en desafíos -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                🎯 Progreso en Desafíos
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4 rounded-lg text-white">
                                    <h4 class="text-sm opacity-90">Desafíos Completados</h4>
                                    <p class="text-2xl font-bold">{{ desafiosCompletados }}</p>
                                </div>
                                
                                <div class="bg-gradient-to-r from-green-500 to-blue-500 p-4 rounded-lg text-white">
                                    <h4 class="text-sm opacity-90">XP Obtenido</h4>
                                    <p class="text-2xl font-bold">{{ usuario.xp_total || 0 }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <Link 
                                    :href="route('desafio-libre.index')" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                >
                                    🎯 Ir a Desafío Libre
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Perfil Gamer -->
                <div v-show="activeTab === 'gamer'" class="space-y-6">
                    <!-- Estadísticas de gaming -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                                🎮 Mi Perfil Gamer
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- XP Total -->
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 rounded-lg text-white">
                                    <div class="flex items-center">
                                        <span class="text-3xl mr-3">⭐</span>
                                        <div>
                                            <p class="text-sm opacity-90">XP Total</p>
                                            <p class="text-2xl font-bold">{{ usuario.xp_total || 0 }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nivel Actual -->
                                <div class="bg-gradient-to-r from-green-500 to-blue-500 p-6 rounded-lg text-white">
                                    <div class="flex items-center">
                                        <span class="text-3xl mr-3">🏆</span>
                                        <div>
                                            <p class="text-sm opacity-90">Nivel</p>
                                            <p class="text-2xl font-bold">{{ usuario.nivel_actual || 1 }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Título -->
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6 rounded-lg text-white">
                                    <div class="flex items-center">
                                        <span class="text-3xl mr-3">👑</span>
                                        <div>
                                            <p class="text-sm opacity-90">Título</p>
                                            <p class="text-lg font-bold">{{ usuario.titulo || 'Novato' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desafíos Completados -->
                                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-6 rounded-lg text-white">
                                    <div class="flex items-center">
                                        <span class="text-3xl mr-3">🎯</span>
                                        <div>
                                            <p class="text-sm opacity-90">Desafíos</p>
                                            <p class="text-2xl font-bold">{{ desafiosCompletados }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress hacia siguiente nivel -->
                            <div class="mt-6">
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <span>Progreso al siguiente nivel</span>
                                    <span>{{ xpParaSiguienteNivel }} XP restantes</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                    <div 
                                        class="bg-gradient-to-r from-green-400 to-blue-500 h-3 rounded-full transition-all duration-500"
                                        :style="`width: ${progresoNivel}%`"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Insignias -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                🏅 Mis Insignias
                            </h3>
                            
                            <div v-if="insignias && insignias.length > 0" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                <div 
                                    v-for="insignia in insignias" 
                                    :key="insignia.id"
                                    class="text-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg"
                                >
                                    <div class="text-3xl mb-2">{{ insignia.icono }}</div>
                                    <h4 class="font-medium text-sm text-gray-900 dark:text-gray-100">
                                        {{ insignia.nombre }}
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ insignia.descripcion }}
                                    </p>
                                </div>
                            </div>
                            
                            <div v-else class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p class="text-xl">🏅</p>
                                <p class="mt-2">¡Aún no tienes insignias!</p>
                                <p class="text-sm">Completa desafíos y módulos para obtener tus primeras insignias.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Clasificación -->
                <div v-show="activeTab === 'ranking'" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                            🏆 Clasificación Global
                        </h3>
                        
                        <!-- Mi posición -->
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-6 rounded-lg text-white mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm opacity-90">Mi Posición</p>
                                    <p class="text-3xl font-bold">#{{ miPosicion || '?' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm opacity-90">Mi XP</p>
                                    <p class="text-2xl font-bold">{{ usuario.xp_total || 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Top 10 -->
                        <div class="space-y-3">
                            <div 
                                v-for="(user, index) in leaderboard" 
                                :key="user.id"
                                :class="[
                                    'flex items-center justify-between p-4 rounded-lg',
                                    user.id === usuario.id 
                                        ? 'bg-indigo-50 dark:bg-indigo-900/50 border-2 border-indigo-200 dark:border-indigo-700' 
                                        : 'bg-gray-50 dark:bg-gray-700'
                                ]"
                            >
                                <div class="flex items-center">
                                    <span :class="[
                                        'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold mr-4',
                                        index === 0 ? 'bg-yellow-500 text-white' :
                                        index === 1 ? 'bg-gray-400 text-white' :
                                        index === 2 ? 'bg-orange-600 text-white' :
                                        'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300'
                                    ]">
                                        {{ index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ user.name }}
                                            <span v-if="user.id === usuario.id" class="text-indigo-600 dark:text-indigo-400">(Tú)</span>
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Nivel {{ user.nivel_actual || 1 }} • {{ user.titulo || 'Novato' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ user.xp_total || 0 }} XP</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, useForm, router, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    usuario: Object,
    progresos: Array,
    insignias: Array,
    leaderboard: Array,
    miPosicion: Number,
    desafiosCompletados: Number,
    totalModulos: Number,
    modulosCompletados: Number,
    evaluacionesAprobadas: Number,
    promedioGeneral: Number
})

const activeTab = ref('perfil')

// Form para actualizar perfil
const profileForm = useForm({
    name: props.usuario.name,
    email: props.usuario.email
})

// Computed properties
const xpParaSiguienteNivel = computed(() => {
    const nivelActual = props.usuario.nivel_actual || 1
    const xpRequerido = nivelActual * 1000
    const xpActual = props.usuario.xp_total || 0
    return Math.max(0, xpRequerido - xpActual)
})

const progresoNivel = computed(() => {
    const nivelActual = props.usuario.nivel_actual || 1
    const xpAnterior = (nivelActual - 1) * 1000
    const xpRequerido = nivelActual * 1000
    const xpActual = props.usuario.xp_total || 0
    
    const progreso = ((xpActual - xpAnterior) / (xpRequerido - xpAnterior)) * 100
    return Math.max(0, Math.min(100, progreso))
})

// Methods
const updateProfile = () => {
    profileForm.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Mostrar mensaje de éxito
        }
    })
}

const getEstadoClass = (estado) => {
    const classes = {
        'completado': 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
        'en_progreso': 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
        'no_iniciado': 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
    }
    return classes[estado] || classes['no_iniciado']
}

const getEstadoTexto = (estado) => {
    const textos = {
        'completado': 'Completado',
        'en_progreso': 'En Progreso',
        'no_iniciado': 'No Iniciado'
    }
    return textos[estado] || 'No Iniciado'
}
</script>
