<template>
    <AuthenticatedLayout>
        <div class="bg-gradient-to-br from-gray-900 via-blue-900 to-black min-h-screen">
            <div class="container mx-auto px-4 py-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold mb-4 text-blue-300">
                        🏆 Muro de la Fama de Comandos
                    </h1>
                    <p class="text-lg text-blue-200">
                        Celebra los comandos exitosos de toda la comunidad SABLE
                    </p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-800 rounded-lg p-6 border border-blue-500">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-400 mb-2">
                                {{ estadisticas.total_comandos }}
                            </div>
                            <div class="text-blue-200">Comandos Ejecutados</div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-800 rounded-lg p-6 border border-green-500">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-400 mb-2">
                                {{ estadisticas.usuarios_activos }}
                            </div>
                            <div class="text-blue-200">Usuarios Activos</div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-800 rounded-lg p-6 border border-purple-500">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-400 mb-2 font-mono">
                                {{ estadisticas.comando_mas_usado }}
                            </div>
                            <div class="text-blue-200">Comando Más Popular</div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-gray-800 rounded-lg p-6 mb-8 border border-gray-600">
                    <div class="flex flex-wrap gap-4 items-center">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Filtrar por comando:
                            </label>
                            <input
                                v-model="filtroComando"
                                type="text"
                                placeholder="ej: ls, cd, mkdir..."
                                class="bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Ordenar por:
                            </label>
                            <select 
                                v-model="ordenarPor"
                                class="bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="reciente">Más Reciente</option>
                                <option value="usuario">Usuario</option>
                                <option value="comando">Comando</option>
                            </select>
                        </div>
                        
                        <button
                            @click="limpiarFiltros"
                            class="mt-6 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors"
                        >
                            Limpiar Filtros
                        </button>
                    </div>
                </div>

                <!-- Commands Wall -->
                <div class="space-y-4">
                    <div 
                        v-for="comando in comandosFiltrados" 
                        :key="comando.id_comando"
                        class="bg-gray-800 rounded-lg p-6 border border-gray-600 hover:border-blue-500 transition-colors"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <!-- User Info -->
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        {{ comando.usuario.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-white font-semibold">{{ comando.usuario.name }}</div>
                                        <div class="text-gray-400 text-sm">
                                            Nivel {{ comando.usuario.nivel_actual }} • {{ comando.usuario.titulo }}
                                        </div>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <div class="text-yellow-400 font-bold">{{ comando.usuario.xp_total }} XP</div>
                                        <div class="text-gray-400 text-sm">
                                            {{ formatearFecha(comando.enviado_en) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Command Display -->
                                <div class="bg-black rounded-lg p-4 border border-green-500">
                                    <div class="flex items-center mb-2">
                                        <span class="text-green-400 font-mono text-sm">$</span>
                                        <span class="ml-2 text-green-300 font-mono">{{ comando.comando }}</span>
                                        <span class="ml-auto text-green-400 text-sm">✅ Exitoso</span>
                                    </div>
                                    <div class="text-gray-400 text-sm">
                                        {{ obtenerDescripcionComando(comando.comando) }}
                                    </div>
                                </div>

                                <!-- Interaction Buttons -->
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex space-x-4">
                                        <button
                                            @click="darLike(comando.id_comando)"
                                            class="flex items-center space-x-2 text-gray-400 hover:text-red-400 transition-colors"
                                            :class="{ 'text-red-400': comando.like_usuario }"
                                        >
                                            <span>❤️</span>
                                            <span>{{ comando.likes || 0 }}</span>
                                        </button>
                                        
                                        <button
                                            @click="toggleComentarios(comando.id_comando)"
                                            class="flex items-center space-x-2 text-gray-400 hover:text-blue-400 transition-colors"
                                        >
                                            <span>💬</span>
                                            <span>{{ comando.comentarios || 0 }}</span>
                                        </button>
                                        
                                        <button
                                            @click="copiarComando(comando.comando)"
                                            class="flex items-center space-x-2 text-gray-400 hover:text-green-400 transition-colors"
                                        >
                                            <span>📋</span>
                                            <span>Copiar</span>
                                        </button>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-500 text-sm">Desafío #{{ comando.desafio_id }}</span>
                                    </div>
                                </div>

                                <!-- Comments Section -->
                                <div v-if="comentariosVisibles.includes(comando.id_comando)" class="mt-4 border-t border-gray-700 pt-4">
                                    <!-- Comment Input -->
                                    <div class="flex space-x-3 mb-4">
                                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <div class="flex-1">
                                            <input
                                                v-model="nuevoComentario[comando.id_comando]"
                                                @keyup.enter="enviarComentario(comando.id_comando)"
                                                placeholder="Escribe un comentario..."
                                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            />
                                        </div>
                                        <button
                                            @click="enviarComentario(comando.id_comando)"
                                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors"
                                        >
                                            Enviar
                                        </button>
                                    </div>
                                    
                                    <!-- Comments List -->
                                    <div class="space-y-3">
                                        <div 
                                            v-for="comentario in comando.comentarios_lista" 
                                            :key="comentario.id"
                                            class="flex space-x-3"
                                        >
                                            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ comentario.usuario.name.charAt(0).toUpperCase() }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-gray-700 rounded-lg p-3">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <span class="text-white font-semibold text-sm">{{ comentario.usuario.name }}</span>
                                                        <span class="text-gray-400 text-xs">{{ formatearFecha(comentario.created_at) }}</span>
                                                    </div>
                                                    <p class="text-gray-200 text-sm">{{ comentario.texto }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="comandos.links" class="mt-8">
                    <nav class="flex justify-center">
                        <div class="flex space-x-2">
                            <button
                                v-for="link in comandos.links"
                                :key="link.label"
                                @click="cambiarPagina(link.url)"
                                :disabled="!link.url"
                                class="px-3 py-2 rounded-lg font-semibold transition-colors"
                                :class="{
                                    'bg-blue-600 text-white': link.active,
                                    'bg-gray-700 text-gray-300 hover:bg-gray-600': !link.active && link.url,
                                    'bg-gray-800 text-gray-500 cursor-not-allowed': !link.url
                                }"
                                v-html="link.label"
                            >
                            </button>
                        </div>
                    </nav>
                </div>

                <!-- Toast Notification -->
                <div 
                    v-if="showToast"
                    class="fixed bottom-4 right-4 bg-green-600 text-white p-4 rounded-lg shadow-lg transform transition-all duration-300"
                    :class="{ 'translate-y-full opacity-0': !showToast }"
                >
                    {{ toastMessage }}
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    comandos: Object,
    estadisticas: Object
})

// Reactive state
const filtroComando = ref('')
const ordenarPor = ref('reciente')
const comentariosVisibles = ref([])
const nuevoComentario = ref({})
const showToast = ref(false)
const toastMessage = ref('')

// Computed properties
const comandosFiltrados = computed(() => {
    let comandos = props.comandos.data || []
    
    if (filtroComando.value) {
        comandos = comandos.filter(cmd => 
            cmd.comando.toLowerCase().includes(filtroComando.value.toLowerCase())
        )
    }
    
    // Apply sorting
    if (ordenarPor.value === 'usuario') {
        comandos.sort((a, b) => a.usuario.name.localeCompare(b.usuario.name))
    } else if (ordenarPor.value === 'comando') {
        comandos.sort((a, b) => a.comando.localeCompare(b.comando))
    }
    // 'reciente' is already the default order from backend
    
    return comandos
})

// Methods
const limpiarFiltros = () => {
    filtroComando.value = ''
    ordenarPor.value = 'reciente'
}

const toggleComentarios = (comandoId) => {
    const index = comentariosVisibles.value.indexOf(comandoId)
    if (index > -1) {
        comentariosVisibles.value.splice(index, 1)
    } else {
        comentariosVisibles.value.push(comandoId)
    }
}

const darLike = async (comandoId) => {
    try {
        const response = await fetch(`/api/comandos/${comandoId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        
        if (response.ok) {
            mostrarToast('¡Like enviado!')
            // Update like count in UI
            // This would be handled better with a proper state management solution
        }
    } catch (error) {
        console.error('Error al dar like:', error)
    }
}

const enviarComentario = async (comandoId) => {
    const texto = nuevoComentario.value[comandoId]
    if (!texto || !texto.trim()) return
    
    try {
        const response = await fetch(`/api/comandos/${comandoId}/comentario`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ texto })
        })
        
        if (response.ok) {
            nuevoComentario.value[comandoId] = ''
            mostrarToast('¡Comentario enviado!')
            // Reload page or update state
        }
    } catch (error) {
        console.error('Error al enviar comentario:', error)
    }
}

const copiarComando = async (comando) => {
    try {
        await navigator.clipboard.writeText(comando)
        mostrarToast('¡Comando copiado al portapapeles!')
    } catch (error) {
        console.error('Error al copiar:', error)
        mostrarToast('Error al copiar el comando')
    }
}

const formatearFecha = (fecha) => {
    return new Date(fecha).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const obtenerDescripcionComando = (comando) => {
    const descripciones = {
        'ls': 'Lista el contenido del directorio actual',
        'pwd': 'Muestra la ruta del directorio actual',
        'cd': 'Cambia de directorio',
        'mkdir': 'Crea un nuevo directorio',
        'touch': 'Crea un archivo vacío o actualiza la fecha de modificación',
        'cp': 'Copia archivos o directorios',
        'mv': 'Mueve o renombra archivos/directorios',
        'rm': 'Elimina archivos o directorios',
        'cat': 'Muestra el contenido de un archivo',
        'grep': 'Busca patrones en archivos',
        'chmod': 'Cambia permisos de archivos',
        'chown': 'Cambia el propietario de archivos'
    }
    
    const comandoBase = comando.split(' ')[0]
    return descripciones[comandoBase] || 'Comando de Linux'
}

const cambiarPagina = (url) => {
    if (url) {
        router.visit(url, { preserveState: true })
    }
}

const mostrarToast = (mensaje) => {
    toastMessage.value = mensaje
    showToast.value = true
    setTimeout(() => {
        showToast.value = false
    }, 3000)
}

onMounted(() => {
    // Initialize any required data
})
</script>
