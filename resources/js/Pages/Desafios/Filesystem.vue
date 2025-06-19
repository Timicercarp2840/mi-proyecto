<template>
    <AuthenticatedLayout>
        <div class="bg-gradient-to-br from-gray-900 via-purple-900 to-black min-h-screen">
            <div class="container mx-auto px-4 py-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold mb-4 text-purple-300">
                        📁 Maestro del Sistema de Archivos - Nivel 2
                    </h1>
                    <p class="text-lg text-purple-200">
                        Domina la navegación y manipulación de archivos
                    </p>
                </div>

                <!-- Progress Overview -->
                <div class="bg-gray-800 rounded-lg p-6 mb-8 border border-purple-500">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-2xl font-bold text-purple-300 mb-4">Progreso del Nivel</h2>
                            <div class="w-full bg-gray-700 rounded-full h-4 mb-2">
                                <div 
                                    class="bg-gradient-to-r from-purple-500 to-pink-400 h-4 rounded-full transition-all duration-500"
                                    :style="`width: ${(desafiosCompletados / desafios.length) * 100}%`"
                                ></div>
                            </div>
                            <div class="text-sm text-purple-200">
                                {{ desafiosCompletados }} de {{ desafios.length }} desafíos completados
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-purple-200">XP Total</div>
                            <div class="text-3xl font-bold text-yellow-400">{{ $page.props.auth.user.xp_total }}</div>
                            <div class="text-sm text-purple-200">Nivel {{ $page.props.auth.user.nivel_actual }}</div>
                        </div>
                    </div>
                </div>

                <!-- File System Simulator -->
                <div class="bg-gray-900 rounded-lg border-2 border-purple-500 mb-8">
                    <!-- Explorer Header -->
                    <div class="bg-gray-800 px-4 py-3 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="text-purple-300 font-bold">📁 Explorador SABLE</span>
                            <span class="text-gray-400">|</span>
                            <span class="text-purple-200 font-mono">{{ currentPath }}</span>
                        </div>
                        <div class="flex space-x-2">
                            <button
                                @click="navegarA('/')"
                                class="px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded text-sm transition-colors"
                            >
                                🏠 Home
                            </button>
                            <button
                                @click="navegarAtras"
                                :disabled="!puedeNavigarAtras"
                                class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded text-sm transition-colors disabled:opacity-50"
                            >
                                ← Atrás
                            </button>
                        </div>
                    </div>
                    
                    <!-- File System Content -->
                    <div class="p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Directory Tree -->
                            <div class="bg-black rounded-lg p-4 border border-purple-400">
                                <h3 class="text-purple-300 font-bold mb-4">🌳 Estructura de Directorios</h3>
                                <div class="font-mono text-sm space-y-1">
                                    <div 
                                        v-for="item in directorioActual.contenido" 
                                        :key="item.nombre"
                                        class="flex items-center space-x-2 p-2 rounded hover:bg-gray-800 cursor-pointer transition-colors"
                                        @click="manejarClickItem(item)"
                                        :class="{ 'bg-purple-900': item.seleccionado }"
                                    >
                                        <span>{{ item.tipo === 'directorio' ? '📁' : getIconoArchivo(item.nombre) }}</span>
                                        <span class="text-purple-200">{{ item.nombre }}</span>
                                        <span v-if="item.tipo === 'archivo'" class="text-gray-400 text-xs ml-auto">
                                            {{ item.tamaño || '1KB' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- File Operations Panel -->
                            <div class="bg-black rounded-lg p-4 border border-purple-400">
                                <h3 class="text-purple-300 font-bold mb-4">⚡ Operaciones de Archivo</h3>
                                <div class="space-y-3">
                                    <div class="grid grid-cols-2 gap-2">
                                        <button
                                            @click="mostrarOperacion('copiar')"
                                            class="p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors"
                                        >
                                            📋 Copiar
                                        </button>
                                        <button
                                            @click="mostrarOperacion('mover')"
                                            class="p-3 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition-colors"
                                        >
                                            ✂️ Mover
                                        </button>
                                        <button
                                            @click="mostrarOperacion('crear')"
                                            class="p-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-semibold transition-colors"
                                        >
                                            ➕ Crear
                                        </button>
                                        <button
                                            @click="mostrarOperacion('eliminar')"
                                            class="p-3 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold transition-colors"
                                        >
                                            🗑️ Eliminar
                                        </button>
                                    </div>
                                    
                                    <!-- Operation Panel -->
                                    <div v-if="operacionActiva" class="mt-4 p-4 bg-gray-800 rounded-lg border border-gray-600">
                                        <h4 class="text-purple-300 font-bold mb-3 capitalize">{{ operacionActiva }}</h4>
                                        
                                        <!-- Copy/Move Operations -->
                                        <div v-if="operacionActiva === 'copiar' || operacionActiva === 'mover'">
                                            <div class="mb-3">
                                                <label class="block text-sm text-gray-300 mb-1">Origen:</label>
                                                <input
                                                    v-model="formularioOperacion.origen"
                                                    placeholder="ruta/del/archivo"
                                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 text-sm"
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="block text-sm text-gray-300 mb-1">Destino:</label>
                                                <input
                                                    v-model="formularioOperacion.destino"
                                                    placeholder="ruta/destino/"
                                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 text-sm"
                                                />
                                            </div>
                                        </div>
                                        
                                        <!-- Create Operation -->
                                        <div v-if="operacionActiva === 'crear'">
                                            <div class="mb-3">
                                                <label class="block text-sm text-gray-300 mb-1">Tipo:</label>
                                                <select
                                                    v-model="formularioOperacion.tipo"
                                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 text-sm"
                                                >
                                                    <option value="archivo">Archivo</option>
                                                    <option value="directorio">Directorio</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="block text-sm text-gray-300 mb-1">Nombre:</label>
                                                <input
                                                    v-model="formularioOperacion.nombre"
                                                    placeholder="nombre_del_archivo.txt"
                                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 text-sm"
                                                />
                                            </div>
                                        </div>
                                        
                                        <!-- Delete Operation -->
                                        <div v-if="operacionActiva === 'eliminar'">
                                            <div class="mb-3">
                                                <label class="block text-sm text-gray-300 mb-1">Archivo/Directorio a eliminar:</label>
                                                <input
                                                    v-model="formularioOperacion.objetivo"
                                                    placeholder="ruta/del/archivo"
                                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 text-sm"
                                                />
                                            </div>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <button
                                                @click="ejecutarOperacion"
                                                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded font-semibold transition-colors"
                                            >
                                                Ejecutar
                                            </button>
                                            <button
                                                @click="cancelarOperacion"
                                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded font-semibold transition-colors"
                                            >
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Challenges Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="desafio in desafios" 
                        :key="desafio.id"
                        class="bg-gray-800 rounded-lg p-6 border-2 transition-all duration-300"
                        :class="{
                            'border-green-500': desafio.completado,
                            'border-purple-500': desafioActual === desafio.id,
                            'border-gray-600': !desafio.completado && desafioActual !== desafio.id
                        }"
                    >
                        <!-- Challenge Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold" :class="{
                                'text-green-300': desafio.completado,
                                'text-purple-300': desafioActual === desafio.id,
                                'text-gray-300': !desafio.completado && desafioActual !== desafio.id
                            }">
                                {{ desafio.titulo }}
                            </h3>
                            <div class="flex items-center space-x-2">
                                <span v-if="desafio.completado" class="text-green-400 text-xl">✅</span>
                                <span class="text-yellow-400 font-bold">{{ desafio.xp_recompensa }} XP</span>
                            </div>
                        </div>

                        <!-- Challenge Description -->
                        <p class="text-gray-300 mb-4">{{ desafio.descripcion }}</p>

                        <!-- Challenge Type Badge -->
                        <div class="mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold"
                                :class="getBadgeClass(desafio.tipo)"
                            >
                                {{ getTypeName(desafio.tipo) }}
                            </span>
                        </div>

                        <!-- Challenge Actions -->
                        <div class="space-y-2">
                            <button
                                v-if="!desafio.completado"
                                @click="iniciarDesafio(desafio)"
                                class="w-full py-2 px-4 rounded-lg font-semibold transition-colors"
                                :class="{
                                    'bg-purple-600 hover:bg-purple-700 text-white': desafioActual !== desafio.id,
                                    'bg-green-600 hover:bg-green-700 text-white': desafioActual === desafio.id
                                }"
                            >
                                {{ desafioActual === desafio.id ? 'Desafío Activo' : 'Iniciar Desafío' }}
                            </button>
                            
                            <button
                                v-if="desafio.completado"
                                class="w-full py-2 px-4 bg-gray-600 text-gray-300 rounded-lg font-semibold cursor-not-allowed"
                                disabled
                            >
                                ✅ Completado
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Success Notification -->
                <div 
                    v-if="showSuccessNotification"
                    class="fixed top-4 right-4 bg-green-600 text-white p-4 rounded-lg shadow-lg transform transition-all duration-500"
                >
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">🎉</span>
                        <div>
                            <div class="font-bold">{{ successMessage }}</div>
                            <div class="text-sm opacity-90">{{ xpMessage }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    desafios: Array
})

// File system state
const currentPath = ref('/home/usuario')
const historialNavegacion = ref(['/'])
const directorioActual = ref({
    nombre: 'usuario',
    tipo: 'directorio',
    contenido: [
        { nombre: 'documentos', tipo: 'directorio', contenido: [] },
        { nombre: 'descargas', tipo: 'directorio', contenido: [] },
        { nombre: 'escritorio', tipo: 'directorio', contenido: [] },
        { nombre: 'backup', tipo: 'directorio', contenido: [] },
        { nombre: 'logs', tipo: 'directorio', contenido: [] },
        { nombre: 'config.txt', tipo: 'archivo', tamaño: '2KB' },
        { nombre: 'script.sh', tipo: 'archivo', tamaño: '1KB' },
        { nombre: 'datos.log', tipo: 'archivo', tamaño: '5KB' },
        { nombre: 'error.log', tipo: 'archivo', tamaño: '3KB' },
        { nombre: 'sistema.log', tipo: 'archivo', tamaño: '8KB' }
    ]
})

// Challenge state
const desafioActual = ref(null)
const operacionActiva = ref(null)
const formularioOperacion = ref({})

// Notifications
const showSuccessNotification = ref(false)
const successMessage = ref('')
const xpMessage = ref('')

// Computed
const desafiosCompletados = computed(() => {
    return props.desafios.filter(d => d.completado).length
})

const puedeNavigarAtras = computed(() => {
    return historialNavegacion.value.length > 1
})

// Methods
const navegarA = (ruta) => {
    historialNavegacion.value.push(currentPath.value)
    currentPath.value = ruta
    // Update directory content based on path
    actualizarContenidoDirectorio()
}

const navegarAtras = () => {
    if (puedeNavigarAtras.value) {
        currentPath.value = historialNavegacion.value.pop()
        actualizarContenidoDirectorio()
    }
}

const actualizarContenidoDirectorio = () => {
    // Simulate different directory contents based on current path
    // This would normally come from a backend API
}

const manejarClickItem = (item) => {
    // Reset all selections
    directorioActual.value.contenido.forEach(i => i.seleccionado = false)
    
    // Select clicked item
    item.seleccionado = true
    
    if (item.tipo === 'directorio') {
        // Navigate to directory
        navegarA(`${currentPath.value}/${item.nombre}`)
    }
}

const getIconoArchivo = (nombre) => {
    const extension = nombre.split('.').pop()
    const iconos = {
        'txt': '📄',
        'log': '📊',
        'sh': '⚙️',
        'conf': '🔧',
        'cfg': '🔧',
        'json': '📋',
        'xml': '📋'
    }
    return iconos[extension] || '📄'
}

const mostrarOperacion = (tipo) => {
    operacionActiva.value = tipo
    formularioOperacion.value = {}
}

const cancelarOperacion = () => {
    operacionActiva.value = null
    formularioOperacion.value = {}
}

const ejecutarOperacion = async () => {
    if (!desafioActual.value) {
        alert('Selecciona un desafío primero')
        return
    }
    
    try {
        const response = await fetch('/api/filesystem/operacion', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                desafio_id: desafioActual.value.id,
                operacion: operacionActiva.value,
                parametros: formularioOperacion.value
            })
        })
        
        const result = await response.json()
        
        if (result.success) {
            mostrarExito(result.mensaje, result.xp_ganado)
            
            // Mark challenge as completed if applicable
            if (result.completado) {
                const desafio = props.desafios.find(d => d.id === desafioActual.value.id)
                if (desafio) {
                    desafio.completado = true
                }
            }
            
            // Update file system state
            if (result.nuevo_estado_fs) {
                directorioActual.value = result.nuevo_estado_fs
            }
        } else {
            alert(result.mensaje || 'Error en la operación')
        }
    } catch (error) {
        console.error('Error:', error)
        alert('Error al ejecutar la operación')
    }
    
    cancelarOperacion()
}

const iniciarDesafio = (desafio) => {
    desafioActual.value = desafio
    successMessage.value = `Desafío iniciado: ${desafio.titulo}`
    showSuccessNotification.value = true
    setTimeout(() => {
        showSuccessNotification.value = false
    }, 3000)
}

const getBadgeClass = (tipo) => {
    const classes = {
        'navegacion': 'bg-blue-500 text-white',
        'copia': 'bg-green-500 text-white',
        'mover': 'bg-yellow-500 text-black',
        'crear': 'bg-purple-500 text-white',
        'eliminar': 'bg-red-500 text-white'
    }
    return classes[tipo] || 'bg-gray-500 text-white'
}

const getTypeName = (tipo) => {
    const nombres = {
        'navegacion': 'Navegación',
        'copia': 'Copia',
        'mover': 'Mover',
        'crear': 'Crear',
        'eliminar': 'Eliminar'
    }
    return nombres[tipo] || 'Archivo'
}

const mostrarExito = (mensaje, xp) => {
    successMessage.value = mensaje
    xpMessage.value = `+${xp} XP ganados!`
    showSuccessNotification.value = true
    setTimeout(() => {
        showSuccessNotification.value = false
    }, 4000)
}

onMounted(() => {
    // Initialize file system
    actualizarContenidoDirectorio()
})
</script>
