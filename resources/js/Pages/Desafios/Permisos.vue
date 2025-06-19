<template>
    <AuthenticatedLayout>
        <div class="bg-gradient-to-br from-gray-900 via-orange-900 to-black min-h-screen">
            <div class="container mx-auto px-4 py-8">                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold mb-4 text-orange-300">
                        🔐 Guardián de Permisos - {{ nivel || 'Básico' }}
                    </h1>
                    <p class="text-lg text-orange-200">
                        Controla el acceso y seguridad del sistema de archivos
                    </p>
                </div>

                <!-- Selector de nivel -->
                <div class="flex justify-center mb-8">
                    <div class="bg-gray-800 rounded-lg p-4 border border-orange-500">
                        <div class="flex space-x-4">
                            <Link 
                                :href="route('desafios.permisos', 'basico')"
                                class="px-4 py-2 rounded-lg transition-colors"
                                :class="(nivel || 'Básico') === 'Basico' ? 'bg-orange-600 text-white' : 'bg-gray-700 text-orange-300 hover:bg-gray-600'"
                            >
                                🟢 Básico
                            </Link>
                            <Link 
                                :href="route('desafios.permisos', 'intermedio')"
                                class="px-4 py-2 rounded-lg transition-colors"
                                :class="(nivel || 'Básico') === 'Intermedio' ? 'bg-orange-600 text-white' : 'bg-gray-700 text-orange-300 hover:bg-gray-600'"
                            >
                                🟡 Intermedio
                            </Link>
                            <Link 
                                :href="route('desafios.permisos', 'avanzado')"
                                class="px-4 py-2 rounded-lg transition-colors"
                                :class="(nivel || 'Básico') === 'Avanzado' ? 'bg-orange-600 text-white' : 'bg-gray-700 text-orange-300 hover:bg-gray-600'"
                            >
                                🔴 Avanzado
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Permissions Guide -->
                <div class="bg-gray-800 rounded-lg p-6 mb-8 border border-orange-500">
                    <h2 class="text-2xl font-bold text-orange-300 mb-4">📚 Guía de Permisos Linux</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-gray-900 rounded-lg p-4">
                            <h3 class="text-orange-300 font-bold mb-3">Tipos de Permisos</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center space-x-2">
                                    <span class="text-green-400">r</span>
                                    <span class="text-gray-300">Lectura (Read) - 4</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-yellow-400">w</span>
                                    <span class="text-gray-300">Escritura (Write) - 2</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-red-400">x</span>
                                    <span class="text-gray-300">Ejecución (Execute) - 1</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-900 rounded-lg p-4">
                            <h3 class="text-orange-300 font-bold mb-3">Usuarios</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center space-x-2">
                                    <span class="text-blue-400">u</span>
                                    <span class="text-gray-300">Propietario (User)</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-purple-400">g</span>
                                    <span class="text-gray-300">Grupo (Group)</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-pink-400">o</span>
                                    <span class="text-gray-300">Otros (Others)</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-900 rounded-lg p-4">
                            <h3 class="text-orange-300 font-bold mb-3">Permisos Comunes</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center space-x-2">
                                    <span class="text-green-400 font-mono">644</span>
                                    <span class="text-gray-300">rw-r--r--</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-yellow-400 font-mono">755</span>
                                    <span class="text-gray-300">rwxr-xr-x</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-red-400 font-mono">777</span>
                                    <span class="text-gray-300">rwxrwxrwx</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions Calculator -->
                <div class="bg-gray-800 rounded-lg p-6 mb-8 border border-orange-500">
                    <h2 class="text-2xl font-bold text-orange-300 mb-4">🧮 Calculadora de Permisos</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <!-- User Permissions -->
                        <div class="bg-gray-900 rounded-lg p-4">
                            <h3 class="text-blue-300 font-bold mb-3">👤 Propietario (User)</h3>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        v-model="permisos.user.read"
                                        class="rounded bg-gray-700 border-gray-600 text-green-500 focus:ring-green-500"
                                    />
                                    <span class="text-green-400">Lectura (r)</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        v-model="permisos.user.write"
                                        class="rounded bg-gray-700 border-gray-600 text-yellow-500 focus:ring-yellow-500"
                                    />
                                    <span class="text-yellow-400">Escritura (w)</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        v-model="permisos.user.execute"
                                        class="rounded bg-gray-700 border-gray-600 text-red-500 focus:ring-red-500"
                                    />
                                    <span class="text-red-400">Ejecución (x)</span>
                                </label>
                            </div>
                            <div class="mt-4 text-center">
                                <div class="text-2xl font-bold text-blue-400">{{ calcularPermiso('user') }}</div>
                                <div class="text-sm text-gray-400">{{ mostrarPermisoTexto('user') }}</div>
                            </div>
                        </div>

                        <!-- Group Permissions -->
                        <div class="bg-gray-900 rounded-lg p-4">
                            <h3 class="text-purple-300 font-bold mb-3">👥 Grupo (Group)</h3>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        v-model="permisos.group.read"
                                        class="rounded bg-gray-700 border-gray-600 text-green-500 focus:ring-green-500"
                                    />
                                    <span class="text-green-400">Lectura (r)</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        v-model="permisos.group.write"
                                        class="rounded bg-gray-700 border-gray-600 text-yellow-500 focus:ring-yellow-500"
                                    />
                                    <span class="text-yellow-400">Escritura (w)</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        v-model="permisos.group.execute"
                                        class="rounded bg-gray-700 border-gray-600 text-red-500 focus:ring-red-500"
                                    />
                                    <span class="text-red-400">Ejecución (x)</span>
                                </label>
                            </div>
                            <div class="mt-4 text-center">
                                <div class="text-2xl font-bold text-purple-400">{{ calcularPermiso('group') }}</div>
                                <div class="text-sm text-gray-400">{{ mostrarPermisoTexto('group') }}</div>
                            </div>
                        </div>

                        <!-- Others Permissions -->
                        <div class="bg-gray-900 rounded-lg p-4">
                            <h3 class="text-pink-300 font-bold mb-3">🌍 Otros (Others)</h3>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        v-model="permisos.others.read"
                                        class="rounded bg-gray-700 border-gray-600 text-green-500 focus:ring-green-500"
                                    />
                                    <span class="text-green-400">Lectura (r)</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        v-model="permisos.others.write"
                                        class="rounded bg-gray-700 border-gray-600 text-yellow-500 focus:ring-yellow-500"
                                    />
                                    <span class="text-yellow-400">Escritura (w)</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input 
                                        type="checkbox" 
                                        v-model="permisos.others.execute"
                                        class="rounded bg-gray-700 border-gray-600 text-red-500 focus:ring-red-500"
                                    />
                                    <span class="text-red-400">Ejecución (x)</span>
                                </label>
                            </div>
                            <div class="mt-4 text-center">
                                <div class="text-2xl font-bold text-pink-400">{{ calcularPermiso('others') }}</div>
                                <div class="text-sm text-gray-400">{{ mostrarPermisoTexto('others') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Result -->
                    <div class="mt-6 text-center">
                        <div class="bg-black rounded-lg p-4 border border-orange-500">
                            <h3 class="text-orange-300 font-bold mb-2">Resultado Final</h3>
                            <div class="flex items-center justify-center space-x-4">
                                <div class="text-3xl font-bold text-orange-400 font-mono">
                                    {{ permisoOctal }}
                                </div>
                                <div class="text-2xl text-gray-400">|</div>
                                <div class="text-2xl font-mono text-orange-200">
                                    {{ permisoTextoCompleto }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <code class="text-green-400 text-sm">
                                    chmod {{ permisoOctal }} archivo.txt
                                </code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File System with Permissions -->
                <div class="bg-gray-800 rounded-lg p-6 mb-8 border border-orange-500">
                    <h2 class="text-2xl font-bold text-orange-300 mb-4">📁 Sistema de Archivos</h2>
                    <div class="bg-black rounded-lg p-4 font-mono text-sm">
                        <div class="text-green-400 mb-2">$ ls -la</div>
                        <div class="space-y-1">
                            <div 
                                v-for="archivo in archivos" 
                                :key="archivo.nombre"
                                class="flex items-center space-x-4 p-2 rounded hover:bg-gray-800 cursor-pointer transition-colors"
                                @click="seleccionarArchivo(archivo)"
                                :class="{ 'bg-orange-900': archivo.seleccionado }"
                            >
                                <span class="text-gray-400 w-24">{{ archivo.permisos }}</span>
                                <span class="text-blue-400 w-16">{{ archivo.propietario }}</span>
                                <span class="text-purple-400 w-16">{{ archivo.grupo }}</span>
                                <span class="text-white">{{ archivo.nombre }}</span>
                                <span v-if="archivo.needsPermissionChange" class="text-red-400 text-xs">⚠️ Requiere cambio</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Challenges Grid -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div 
                        v-for="desafio in desafios" 
                        :key="desafio.id"
                        class="bg-gray-800 rounded-lg p-6 border-2 transition-all duration-300"
                        :class="{
                            'border-green-500': desafio.completado,
                            'border-orange-500': desafioActual === desafio.id,
                            'border-gray-600': !desafio.completado && desafioActual !== desafio.id
                        }"
                    >
                        <!-- Challenge Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold" :class="{
                                'text-green-300': desafio.completado,
                                'text-orange-300': desafioActual === desafio.id,
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

                        <!-- Target Permissions Display -->
                        <div class="bg-gray-900 rounded-lg p-3 mb-4">
                            <div class="text-sm text-gray-400 mb-1">Archivo objetivo:</div>
                            <div class="text-orange-300 font-mono">{{ desafio.archivo }}</div>
                            <div class="text-sm text-gray-400 mb-1 mt-2">Permisos objetivo:</div>
                            <div class="text-green-400 font-mono">{{ desafio.permisos_objetivo }}</div>
                        </div>

                        <!-- Permission Setter -->
                        <div v-if="desafioActual === desafio.id" class="mb-4">
                            <div class="mb-2">
                                <label class="block text-sm text-gray-300 mb-1">Configurar permisos:</label>
                                <input
                                    v-model="permisoInput[desafio.id]"
                                    placeholder="ej: 755"
                                    class="w-full bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 font-mono"
                                    maxlength="3"
                                />
                            </div>
                            <button
                                @click="aplicarPermisos(desafio)"
                                class="w-full py-2 px-4 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors"
                            >
                                🔧 Aplicar chmod {{ permisoInput[desafio.id] || '___' }} {{ desafio.archivo }}
                            </button>
                        </div>

                        <!-- Challenge Actions -->
                        <div class="space-y-2">
                            <button
                                v-if="!desafio.completado"
                                @click="iniciarDesafio(desafio)"
                                class="w-full py-2 px-4 rounded-lg font-semibold transition-colors"
                                :class="{
                                    'bg-orange-600 hover:bg-orange-700 text-white': desafioActual !== desafio.id,
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
import { ref, computed, reactive } from 'vue'
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    desafios: Array,
    nivel: String
})

// Permissions calculator state
const permisos = reactive({
    user: { read: false, write: false, execute: false },
    group: { read: false, write: false, execute: false },
    others: { read: false, write: false, execute: false }
})

// File system state
const archivos = ref([
    { nombre: 'script.sh', permisos: '-rw-r--r--', propietario: 'usuario', grupo: 'usuarios', seleccionado: false, needsPermissionChange: true },
    { nombre: 'backup.sh', permisos: '-rw-r--r--', propietario: 'usuario', grupo: 'usuarios', seleccionado: false, needsPermissionChange: true },
    { nombre: 'config.txt', permisos: '-rw-r--r--', propietario: 'usuario', grupo: 'usuarios', seleccionado: false, needsPermissionChange: false },
    { nombre: 'datos.log', permisos: '-rw-r--r--', propietario: 'usuario', grupo: 'usuarios', seleccionado: false, needsPermissionChange: false }
])

// Challenge state
const desafioActual = ref(null)
const permisoInput = ref({})

// Notifications
const showSuccessNotification = ref(false)
const successMessage = ref('')
const xpMessage = ref('')

// Computed properties
const permisoOctal = computed(() => {
    return calcularPermiso('user') + calcularPermiso('group') + calcularPermiso('others')
})

const permisoTextoCompleto = computed(() => {
    return mostrarPermisoTexto('user') + mostrarPermisoTexto('group') + mostrarPermisoTexto('others')
})

// Methods
const calcularPermiso = (tipo) => {
    const p = permisos[tipo]
    let valor = 0
    if (p.read) valor += 4
    if (p.write) valor += 2
    if (p.execute) valor += 1
    return valor
}

const mostrarPermisoTexto = (tipo) => {
    const p = permisos[tipo]
    let texto = ''
    texto += p.read ? 'r' : '-'
    texto += p.write ? 'w' : '-'
    texto += p.execute ? 'x' : '-'
    return texto
}

const seleccionarArchivo = (archivo) => {
    archivos.value.forEach(a => a.seleccionado = false)
    archivo.seleccionado = true
}

const iniciarDesafio = (desafio) => {
    desafioActual.value = desafio
    if (!permisoInput.value[desafio.id]) {
        permisoInput.value[desafio.id] = ''
    }
}

const aplicarPermisos = async (desafio) => {
    const permisoIngresado = permisoInput.value[desafio.id]
    
    if (!permisoIngresado || permisoIngresado.length !== 3) {
        alert('Ingresa un permiso válido de 3 dígitos (ej: 755)')
        return
    }
    
    try {
        const response = await fetch('/api/permisos/aplicar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                desafio_id: desafio.id,
                archivo: desafio.archivo,
                permisos: permisoIngresado,
                permisos_objetivo: desafio.permisos_objetivo
            })
        })
        
        const result = await response.json()
        
        if (result.success) {
            mostrarExito(result.mensaje, result.xp_ganado)
            
            // Mark challenge as completed
            desafio.completado = true
            
            // Update file permissions in UI
            const archivo = archivos.value.find(a => a.nombre === desafio.archivo)
            if (archivo) {
                archivo.permisos = convertirPermisoTexto(permisoIngresado)
                archivo.needsPermissionChange = false
            }
            
            desafioActual.value = null
        } else {
            alert(result.mensaje || 'Permisos incorrectos. Inténtalo de nuevo.')
        }
    } catch (error) {
        console.error('Error:', error)
        alert('Error al aplicar permisos')
    }
}

const convertirPermisoTexto = (octal) => {
    const convertirDigito = (digito) => {
        const num = parseInt(digito)
        let texto = ''
        texto += (num & 4) ? 'r' : '-'
        texto += (num & 2) ? 'w' : '-'
        texto += (num & 1) ? 'x' : '-'
        return texto
    }
    
    return '-' + convertirDigito(octal[0]) + convertirDigito(octal[1]) + convertirDigito(octal[2])
}

const mostrarExito = (mensaje, xp) => {
    successMessage.value = mensaje
    xpMessage.value = `+${xp} XP ganados!`
    showSuccessNotification.value = true
    setTimeout(() => {
        showSuccessNotification.value = false
    }, 4000)
}
</script>
