<template>
    <AuthenticatedLayout>
        <div class="bg-gradient-to-br from-gray-900 via-green-900 to-black min-h-screen text-green-400">
            <div class="container mx-auto px-4 py-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold mb-4 text-green-300">
                        🖥️ Terminal Interactivo - Nivel 1
                    </h1>
                    <p class="text-lg text-green-200">
                        Domina los comandos básicos de Linux y gana XP
                    </p>
                </div>

                <!-- Progress Overview -->
                <div class="bg-gray-800 rounded-lg p-6 mb-8 border border-green-500">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-green-300">Tu Progreso</h2>
                        <div class="text-right">
                            <div class="text-sm text-green-200">XP Total</div>
                            <div class="text-2xl font-bold text-yellow-400">{{ usuario.xp_total }}</div>
                        </div>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-3">
                        <div 
                            class="bg-gradient-to-r from-green-500 to-green-400 h-3 rounded-full"
                            :style="`width: ${(desafiosCompletados / desafios.length) * 100}%`"
                        ></div>
                    </div>
                    <div class="text-sm text-green-200 mt-2">
                        {{ desafiosCompletados }} de {{ desafios.length }} desafíos completados
                    </div>
                </div>

                <!-- Terminal Simulator -->
                <div class="bg-black rounded-lg border-2 border-green-500 mb-8 overflow-hidden">
                    <!-- Terminal Header -->
                    <div class="bg-gray-800 px-4 py-2 flex items-center">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                        <div class="ml-4 text-green-300 font-mono text-sm">terminal@sable:~$</div>
                    </div>
                    
                    <!-- Terminal Content -->
                    <div class="p-4 h-96 overflow-y-auto font-mono text-sm">
                        <div v-for="(line, index) in terminalHistory" :key="index" class="mb-1">
                            <span v-if="line.type === 'command'" class="text-green-400">
                                $ {{ line.text }}
                            </span>
                            <span v-else-if="line.type === 'output'" class="text-green-200">
                                {{ line.text }}
                            </span>
                            <span v-else-if="line.type === 'error'" class="text-red-400">
                                {{ line.text }}
                            </span>
                            <span v-else-if="line.type === 'success'" class="text-yellow-400">
                                {{ line.text }}
                            </span>
                        </div>
                        
                        <!-- Command Input -->
                        <div class="flex items-center mt-2">
                            <span class="text-green-400 mr-2">$</span>
                            <input
                                v-model="currentCommand"
                                @keyup.enter="executeCommand"
                                class="bg-transparent text-green-400 outline-none flex-1 font-mono"
                                placeholder="Escribe tu comando aquí..."
                                :disabled="processingCommand"
                            />
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
                            'border-yellow-500': desafioActual === desafio.id,
                            'border-gray-600': !desafio.completado && desafioActual !== desafio.id
                        }"
                    >
                        <!-- Challenge Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold" :class="{
                                'text-green-300': desafio.completado,
                                'text-yellow-300': desafioActual === desafio.id,
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

                        <!-- Challenge Actions -->
                        <div class="space-y-2">
                            <button
                                v-if="!desafio.completado"
                                @click="iniciarDesafio(desafio.id)"
                                class="w-full py-2 px-4 rounded-lg font-semibold transition-colors"
                                :class="{
                                    'bg-yellow-600 hover:bg-yellow-700 text-black': desafioActual !== desafio.id,
                                    'bg-green-600 hover:bg-green-700 text-white': desafioActual === desafio.id
                                }"
                            >
                                {{ desafioActual === desafio.id ? 'Desafío Activo' : 'Iniciar Desafío' }}
                            </button>
                            
                            <button
                                v-if="!desafio.completado && desafioActual === desafio.id"
                                @click="mostrarPista(desafio)"
                                class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors"
                            >
                                💡 Ver Pista
                            </button>
                        </div>

                        <!-- Hint Display -->
                        <div v-if="mostrandoPista === desafio.id" class="mt-4 p-3 bg-blue-900 rounded-lg border border-blue-500">
                            <p class="text-blue-200 text-sm">💡 {{ desafio.pista }}</p>
                        </div>
                    </div>
                </div>

                <!-- XP Notification -->
                <div 
                    v-if="showXpNotification"
                    class="fixed top-4 right-4 bg-green-600 text-white p-4 rounded-lg shadow-lg transform transition-all duration-500"
                    :class="{ 'translate-x-full opacity-0': !showXpNotification }"
                >
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">🎉</span>
                        <div>
                            <div class="font-bold">{{ xpMessage }}</div>
                            <div class="text-sm opacity-90">{{ feedbackMessage }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch, nextTick } from 'vue'
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    desafios: Array,
    usuario: Object
})

// Terminal state
const terminalHistory = ref([
    { type: 'output', text: 'Bienvenido al Terminal Interactivo de SABLE' },
    { type: 'output', text: 'Selecciona un desafío y practica comandos de Linux' },
    { type: 'output', text: '-------------------------------------------' }
])
const currentCommand = ref('')
const processingCommand = ref(false)

// Challenge state
const desafioActual = ref(null)
const mostrandoPista = ref(null)

// XP notification
const showXpNotification = ref(false)
const xpMessage = ref('')
const feedbackMessage = ref('')

// Computed
const desafiosCompletados = computed(() => {
    return props.desafios.filter(d => d.completado).length
})

// Methods
const iniciarDesafio = (desafioId) => {
    desafioActual.value = desafioId
    const desafio = props.desafios.find(d => d.id === desafioId)
    terminalHistory.value.push({
        type: 'output',
        text: `Desafío iniciado: ${desafio.titulo}`
    })
    terminalHistory.value.push({
        type: 'output',
        text: desafio.descripcion
    })
}

const mostrarPista = (desafio) => {
    mostrandoPista.value = mostrandoPista.value === desafio.id ? null : desafio.id
}

const executeCommand = async () => {
    if (!currentCommand.value.trim() || !desafioActual.value) {
        if (!desafioActual.value) {
            terminalHistory.value.push({
                type: 'error',
                text: 'Selecciona un desafío primero'
            })
        }
        return
    }

    processingCommand.value = true
    
    // Add command to history
    terminalHistory.value.push({
        type: 'command',
        text: currentCommand.value
    })

    try {
        const response = await fetch('/api/procesar-comando', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                comando: currentCommand.value,
                desafio_id: desafioActual.value
            })
        })

        const result = await response.json()

        if (result.correcto) {
            terminalHistory.value.push({
                type: 'success',
                text: result.mensaje
            })
            terminalHistory.value.push({
                type: 'output',
                text: result.feedback
            })

            // Show XP notification
            showXpNotification.value = true
            xpMessage.value = `+${result.xp_ganado} XP`
            feedbackMessage.value = result.mensaje

            setTimeout(() => {
                showXpNotification.value = false
            }, 4000)

            // Mark challenge as completed
            const desafio = props.desafios.find(d => d.id === desafioActual.value)
            if (desafio) {
                desafio.completado = true
            }
            
            desafioActual.value = null
        } else {
            terminalHistory.value.push({
                type: 'error',
                text: result.mensaje
            })
            if (result.pista) {
                terminalHistory.value.push({
                    type: 'output',
                    text: `Pista: ${result.pista}`
                })
            }
        }
    } catch (error) {
        terminalHistory.value.push({
            type: 'error',
            text: 'Error al procesar el comando'
        })
    }

    currentCommand.value = ''
    processingCommand.value = false
}

onMounted(() => {
    // Auto-scroll terminal to bottom
    const scrollToBottom = () => {
        const terminal = document.querySelector('.terminal-content')
        if (terminal) {
            terminal.scrollTop = terminal.scrollHeight
        }
    }
    
    // Scroll on history updates
    watch(terminalHistory, () => {
        nextTick(scrollToBottom)
    }, { deep: true })
})
</script>

<style scoped>
/* Terminal scrollbar styling */
.terminal-content::-webkit-scrollbar {
    width: 8px;
}

.terminal-content::-webkit-scrollbar-track {
    background: #1f2937;
}

.terminal-content::-webkit-scrollbar-thumb {
    background: #10b981;
    border-radius: 4px;
}

.terminal-content::-webkit-scrollbar-thumb:hover {
    background: #059669;
}
</style>
