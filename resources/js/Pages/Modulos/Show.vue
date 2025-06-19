<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    modulo: Object,
    progreso: Object,
    desafios: Array
});

// Estado local para manejo de desafíos
const desafioActivo = ref(null);
const mostrandoPista = ref(null);
const currentCommand = ref('');
const terminalHistory = ref([]);
const showSuccessNotification = ref(false);
const successMessage = ref('');
const xpMessage = ref('');
const permisoInput = ref({});
const operacionActiva = ref(null);
const formularioOperacion = ref({});

// Estado para la mini terminal de práctica
const miniTerminalCommand = ref('');
const miniTerminalHistory = ref([
    { type: 'output', text: 'Mini Terminal de Práctica - Escribe comandos aquí para practicar' },
    { type: 'output', text: 'Ejemplos: ls, pwd, whoami, date, echo "hola"' },
    { type: 'output', text: '---' }
]);
const showMiniTerminal = ref(true);

// Computed
const desafiosCompletados = computed(() => {
    return props.desafios?.filter(d => d.completado).length || 0;
});

const totalDesafios = computed(() => {
    return props.desafios?.length || 0;
});

const nivelTematico = computed(() => {
    const temas = {
        1: { nombre: 'Terminal Básico', color: 'green', icono: '🖥️' },
        2: { nombre: 'Sistema de Archivos', color: 'purple', icono: '📁' },
        3: { nombre: 'Permisos y Seguridad', color: 'orange', icono: '🔐' },
        4: { nombre: 'Procesos del Sistema', color: 'blue', icono: '⚙️' },
        5: { nombre: 'Configuración de Red', color: 'indigo', icono: '🌐' }
    };
    return temas[props.modulo.nivel] || { nombre: 'Avanzado', color: 'gray', icono: '📚' };
});

// Methods
const marcarCompletado = () => {
    router.post(route('progreso.actualizar', props.modulo.id_modulo), {
        estado: 'completado'
    });
};

const iniciarDesafio = (desafio) => {
    desafioActivo.value = desafio;
    
    // Inicializar estados específicos por tipo de desafío
    if (desafio.tipo === 'terminal') {
        terminalHistory.value = [
            { type: 'output', text: `Desafío iniciado: ${desafio.titulo}` },
            { type: 'output', text: desafio.descripcion },
            { type: 'output', text: '---' }
        ];
    } else if (desafio.tipo === 'permisos') {
        if (!permisoInput.value[desafio.id_desafio]) {
            permisoInput.value[desafio.id_desafio] = '';
        }
    }
};

const ejecutarComandoTerminal = async () => {
    if (!currentCommand.value.trim() || !desafioActivo.value) return;
    
    // Add command to history
    terminalHistory.value.push({
        type: 'command',
        text: currentCommand.value
    });

    try {
        const response = await fetch('/api/procesar-comando', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                comando: currentCommand.value,
                desafio_id: desafioActivo.value.id_desafio
            })
        });

        const result = await response.json();

        if (result.correcto) {
            terminalHistory.value.push({
                type: 'success',
                text: result.mensaje
            });
            
            mostrarExito(`¡Desafío completado! +${result.xp_ganado} XP`);
            
            // Marcar como completado
            desafioActivo.value.completado = true;
            desafioActivo.value = null;
        } else {
            terminalHistory.value.push({
                type: 'error',
                text: result.mensaje
            });
        }
    } catch (error) {
        terminalHistory.value.push({
            type: 'error',
            text: 'Error al procesar el comando'
        });
    }

    currentCommand.value = '';
};

const aplicarPermisos = async (desafio) => {
    const permisoIngresado = permisoInput.value[desafio.id_desafio];
    
    if (!permisoIngresado || permisoIngresado.length !== 3) {
        alert('Ingresa un permiso válido de 3 dígitos (ej: 755)');
        return;
    }
    
    try {
        const criterios = JSON.parse(desafio.criterios_validacion);
        const response = await fetch('/api/permisos/aplicar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                desafio_id: desafio.id_desafio,
                archivo: criterios.archivo,
                permisos: permisoIngresado,
                permisos_objetivo: criterios.permisos_objetivo
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            mostrarExito(`¡Desafío completado! +${result.xp_ganado} XP`);
            desafio.completado = true;
            desafioActivo.value = null;
        } else {
            alert(result.mensaje || 'Permisos incorrectos. Inténtalo de nuevo.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al aplicar permisos');
    }
};

const mostrarExito = (mensaje) => {
    successMessage.value = mensaje;
    showSuccessNotification.value = true;
    setTimeout(() => {
        showSuccessNotification.value = false;
    }, 4000);
};

const mostrarPista = (desafio) => {
    mostrandoPista.value = mostrandoPista.value === desafio.id_desafio ? null : desafio.id_desafio;
};

const getColorClasses = (color) => {
    const colors = {
        green: 'from-green-600 to-green-700 border-green-500',
        purple: 'from-purple-600 to-purple-700 border-purple-500',
        orange: 'from-orange-600 to-orange-700 border-orange-500',
        blue: 'from-blue-600 to-blue-700 border-blue-500',
        indigo: 'from-indigo-600 to-indigo-700 border-indigo-500',
        gray: 'from-gray-600 to-gray-700 border-gray-500'
    };
    return colors[color] || colors.gray;
};

// Función para la mini terminal de práctica
const ejecutarComandoMiniTerminal = async () => {
    if (!miniTerminalCommand.value.trim()) return;
    
    // Agregar comando al historial
    miniTerminalHistory.value.push({
        type: 'command',
        text: miniTerminalCommand.value
    });

    try {
        const response = await fetch('/api/mini-terminal', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                comando: miniTerminalCommand.value
            })
        });

        const result = await response.json();
        
        // Si es comando clear, limpiar terminal
        if (result.clear) {
            limpiarMiniTerminal();
        } else {
            // Agregar respuesta al historial
            miniTerminalHistory.value.push({
                type: result.success ? 'output' : 'error',
                text: result.output || result.mensaje || 'Comando ejecutado'
            });
        }
        
    } catch (error) {
        miniTerminalHistory.value.push({
            type: 'error',
            text: 'Error al ejecutar comando'
        });
    }

    miniTerminalCommand.value = '';
};

const limpiarMiniTerminal = () => {
    miniTerminalHistory.value = [
        { type: 'output', text: 'Terminal limpiada - Escribe comandos aquí para practicar' },
        { type: 'output', text: '---' }
    ];
};
</script>

<template>
    <Head :title="`${modulo.titulo} - SABLE`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ nivelTematico.icono }} Nivel {{ modulo.nivel }}: {{ modulo.titulo }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">{{ nivelTematico.nombre }}</p>
                </div>
                <Link 
                    :href="route('modulos.index')"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150"
                >
                    ← Volver a Módulos
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <!-- Estado del progreso general -->
                <div class="mb-6">
                    <div 
                        v-if="progreso?.estado === 'completado'"
                        class="bg-green-50 border border-green-200 rounded-lg p-4"
                    >
                        <div class="flex items-center">
                            <span class="text-green-400 text-xl mr-3">✅</span>
                            <div>
                                <h3 class="text-green-800 font-medium">¡Módulo Completado!</h3>
                                <p class="text-green-600 text-sm">Has completado exitosamente este nivel.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flujo secuencial del módulo -->
                <div class="space-y-8">
                    <!-- PASO 1: Contenido teórico del módulo -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                📚 Paso 1: Aprende la Teoría
                            </h3>
                            <p class="text-blue-100 text-sm mt-1">{{ nivelTematico.nombre }}</p>
                        </div>
                        <div class="p-6">
                            <div class="prose max-w-none">
                                <p class="text-gray-700 leading-relaxed text-lg">
                                    {{ modulo.contenido }}
                                </p>
                            </div>
                        </div>                    </div>

                    <!-- PASO 1.5: Mini Terminal de Práctica -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-white flex items-center">
                                        🖥️ Mini Terminal de Práctica
                                    </h3>
                                    <p class="text-gray-300 text-sm mt-1">Prueba comandos relacionados con {{ nivelTematico.nombre }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        @click="showMiniTerminal = !showMiniTerminal"
                                        class="px-3 py-1 bg-gray-600 hover:bg-gray-500 text-white rounded text-sm transition-colors"
                                    >
                                        {{ showMiniTerminal ? 'Ocultar' : 'Mostrar' }}
                                    </button>
                                    <button
                                        @click="limpiarMiniTerminal"
                                        class="px-3 py-1 bg-red-600 hover:bg-red-500 text-white rounded text-sm transition-colors"
                                    >
                                        Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-if="showMiniTerminal" class="p-6">
                            <!-- Terminal de práctica -->
                            <div class="bg-black rounded-lg p-4">
                                <div class="text-green-400 font-mono text-sm space-y-1 mb-4 max-h-60 overflow-y-auto">
                                    <div v-for="(line, index) in miniTerminalHistory" :key="index">
                                        <span v-if="line.type === 'command'" class="text-green-400">student@sable:~$ {{ line.text }}</span>
                                        <span v-else-if="line.type === 'output'" class="text-green-200">{{ line.text }}</span>
                                        <span v-else-if="line.type === 'error'" class="text-red-400">{{ line.text }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-green-400 font-mono mr-2">student@sable:~$</span>
                                    <input
                                        v-model="miniTerminalCommand"
                                        @keyup.enter="ejecutarComandoMiniTerminal"
                                        class="bg-transparent text-green-400 outline-none flex-1 font-mono"
                                        placeholder="Escribe un comando aquí (ej: ls, pwd, date)..."
                                    />
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <p class="text-blue-800 text-sm">
                                    💡 <strong>Tip:</strong> Esta es una terminal de práctica segura. Puedes probar comandos básicos como: 
                                    <code class="bg-blue-100 px-1 rounded">ls</code>, 
                                    <code class="bg-blue-100 px-1 rounded">pwd</code>, 
                                    <code class="bg-blue-100 px-1 rounded">whoami</code>, 
                                    <code class="bg-blue-100 px-1 rounded">date</code>, 
                                    <code class="bg-blue-100 px-1 rounded">echo "mensaje"</code>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PASO 2: Desafíos Gamificados -->
                    <div v-if="desafios && desafios.length > 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div :class="`bg-gradient-to-r ${getColorClasses(nivelTematico.color)} px-6 py-4`">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                {{ nivelTematico.icono }} Paso 2: Practica con Desafíos Gamificados
                            </h3>
                            <p class="text-white/90 text-sm mt-1">Completa {{ totalDesafios }} desafíos para dominar {{ nivelTematico.nombre }}</p>
                        </div>
                        <div class="p-6">
                            <!-- Progreso de desafíos -->
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Progreso de Desafíos</span>
                                    <span class="text-sm text-gray-500">{{ desafiosCompletados }}/{{ totalDesafios }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div 
                                        :class="`bg-gradient-to-r ${getColorClasses(nivelTematico.color)} h-3 rounded-full transition-all duration-500`"
                                        :style="`width: ${totalDesafios > 0 ? (desafiosCompletados / totalDesafios) * 100 : 0}%`"
                                    ></div>
                                </div>
                            </div>

                            <!-- Lista de desafíos -->
                            <div class="space-y-4 mb-6">
                                <div 
                                    v-for="(desafio, index) in desafios" 
                                    :key="desafio.id_desafio"
                                    class="border-2 rounded-lg p-4 transition-all duration-300"
                                    :class="{
                                        'border-green-500 bg-green-50': desafio.completado,
                                        'border-blue-500 bg-blue-50': desafioActivo?.id_desafio === desafio.id_desafio,
                                        'border-gray-200 hover:border-gray-300': !desafio.completado && desafioActivo?.id_desafio !== desafio.id_desafio
                                    }"
                                >
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-semibold text-gray-900 flex items-center">
                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-800 text-white text-xs rounded-full mr-3">
                                                {{ index + 1 }}
                                            </span>
                                            {{ desafio.titulo }}
                                        </h4>
                                        <div class="flex items-center space-x-2">
                                            <span v-if="desafio.completado" class="text-green-500 text-lg">✅</span>
                                            <span class="text-yellow-600 font-medium text-sm bg-yellow-100 px-2 py-1 rounded">+{{ desafio.xp_recompensa }} XP</span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-600 text-sm mb-4">{{ desafio.descripcion }}</p>
                                    
                                    <div class="flex space-x-2">
                                        <button
                                            v-if="!desafio.completado"
                                            @click="iniciarDesafio(desafio)"
                                            :class="`px-4 py-2 rounded-lg font-semibold text-sm transition-colors ${
                                                desafioActivo?.id_desafio === desafio.id_desafio 
                                                    ? 'bg-green-600 hover:bg-green-700 text-white' 
                                                    : 'bg-blue-600 hover:bg-blue-700 text-white'
                                            }`"
                                        >
                                            {{ desafioActivo?.id_desafio === desafio.id_desafio ? '🎮 Activo' : '🚀 Iniciar Desafío' }}
                                        </button>
                                        
                                        <button
                                            v-if="!desafio.completado"
                                            @click="mostrarPista(desafio)"
                                            class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-semibold text-sm transition-colors"
                                        >
                                            💡 Pista
                                        </button>
                                        
                                        <div v-if="desafio.completado" class="flex items-center text-green-600 font-semibold">
                                            <span class="mr-2">🎉</span>
                                            ¡Completado!
                                        </div>
                                    </div>
                                    
                                    <!-- Pista -->
                                    <div v-if="mostrandoPista === desafio.id_desafio" class="mt-3 p-3 bg-blue-100 rounded-lg border border-blue-300">
                                        <p class="text-blue-800 text-sm">
                                            💡 <strong>Pista:</strong> {{ JSON.parse(desafio.criterios_validacion || '{}').pista || 'Revisa la descripción del desafío.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Área de práctica activa -->
                            <div v-if="desafioActivo" class="border-2 rounded-lg p-6 bg-gradient-to-br from-gray-50 to-gray-100 border-blue-500 shadow-lg">
                                <h4 class="font-bold text-gray-900 mb-4 flex items-center text-lg">
                                    🎯 Practicando: {{ desafioActivo.titulo }}
                                </h4>
                                
                                <!-- Terminal para desafíos de terminal -->
                                <div v-if="desafioActivo.tipo === 'terminal'" class="bg-black rounded-lg p-4">
                                    <div class="text-green-400 font-mono text-sm space-y-1 mb-4 max-h-40 overflow-y-auto">
                                        <div v-for="(line, index) in terminalHistory" :key="index">
                                            <span v-if="line.type === 'command'" class="text-green-400">$ {{ line.text }}</span>
                                            <span v-else-if="line.type === 'output'" class="text-green-200">{{ line.text }}</span>
                                            <span v-else-if="line.type === 'error'" class="text-red-400">{{ line.text }}</span>
                                            <span v-else-if="line.type === 'success'" class="text-yellow-400">{{ line.text }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-green-400 font-mono mr-2">$</span>
                                        <input
                                            v-model="currentCommand"
                                            @keyup.enter="ejecutarComandoTerminal"
                                            class="bg-transparent text-green-400 outline-none flex-1 font-mono"
                                            placeholder="Escribe tu comando aquí..."
                                        />
                                    </div>
                                </div>
                                
                                <!-- Interfaz para desafíos de permisos -->
                                <div v-else-if="desafioActivo.tipo === 'permisos'" class="space-y-4">
                                    <div class="bg-gray-900 rounded-lg p-4 text-white font-mono text-sm">
                                        <div class="text-green-400 mb-2">Archivo objetivo:</div>
                                        <div class="text-orange-300">{{ JSON.parse(desafioActivo.criterios_validacion || '{}').archivo }}</div>
                                        <div class="text-green-400 mt-2 mb-2">Permisos objetivo:</div>
                                        <div class="text-green-300">{{ JSON.parse(desafioActivo.criterios_validacion || '{}').permisos_objetivo }}</div>
                                    </div>
                                    <div class="flex space-x-3">
                                        <input
                                            v-model="permisoInput[desafioActivo.id_desafio]"
                                            placeholder="ej: 755"
                                            class="bg-gray-700 border border-gray-600 text-white rounded px-3 py-2 font-mono flex-1"
                                            maxlength="3"
                                        />
                                        <button
                                            @click="aplicarPermisos(desafioActivo)"
                                            class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded font-semibold transition-colors"
                                        >
                                            Aplicar chmod
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Interfaz básica para otros tipos -->
                                <div v-else class="text-center py-8">
                                    <p class="text-gray-600 mb-4">Desafío {{ desafioActivo.tipo }} en desarrollo</p>
                                    <button
                                        @click="desafioActivo = null"
                                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded font-semibold transition-colors"
                                    >
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PASO 3: Evaluación del Módulo -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                📝 Paso 3: Demuestra tu Conocimiento
                            </h3>
                            <p class="text-green-100 text-sm mt-1">Completa la evaluación para finalizar el módulo</p>
                        </div>
                        <div class="p-6">
                            <div v-if="modulo.evaluaciones && modulo.evaluaciones.length > 0">
                                <div 
                                    v-for="evaluacion in modulo.evaluaciones" 
                                    :key="evaluacion.id_eval"
                                    class="border-2 border-green-200 rounded-lg p-6 bg-green-50"
                                >
                                    <h4 class="font-bold text-gray-900 mb-3 text-lg">
                                        🎯 Evaluación: {{ nivelTematico.nombre }}
                                    </h4>
                                    <p class="text-gray-600 mb-6">
                                        Demuestra que has dominado los conceptos y técnicas de este módulo completando esta evaluación.
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-500">
                                            💡 Completa todos los desafíos arriba para estar mejor preparado
                                        </div>
                                        <Link 
                                            :href="route('evaluaciones.tomar', evaluacion.id_eval)"
                                            class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-bold text-white hover:bg-green-700 transition ease-in-out duration-150 shadow-lg"
                                        >
                                            {{ progreso?.estado === 'completado' ? '🔄 Repetir Evaluación' : '🚀 Tomar Evaluación' }}
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center py-12 text-gray-500">
                                <p class="text-lg mb-2">⚠️ No hay evaluaciones disponibles</p>
                                <p class="text-sm">Este módulo aún no tiene una evaluación configurada.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar con progreso del usuario -->
                <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-center">📊 Tu Progreso Gamer</h3>
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <div class="font-bold text-purple-600 text-lg">{{ $page.props.auth.user.xp_total }}</div>
                            <div class="text-xs text-gray-600">XP Total</div>
                        </div>
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <div class="font-bold text-blue-600 text-lg">{{ $page.props.auth.user.nivel_actual }}</div>
                            <div class="text-xs text-gray-600">Nivel</div>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="font-bold text-green-600 text-lg">{{ desafiosCompletados }}/{{ totalDesafios }}</div>
                            <div class="text-xs text-gray-600">Desafíos</div>
                        </div>
                    </div>
                      <div class="space-y-3">
                        <button
                            v-if="progreso?.estado !== 'completado'"
                            @click="marcarCompletado"
                            class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition-colors"
                        >
                            ✅ Marcar como Completado
                        </button>
                    </div>
                </div>

                <!-- Notificación de éxito -->
                <div 
                    v-if="showSuccessNotification"
                    class="fixed top-4 right-4 bg-green-600 text-white p-4 rounded-lg shadow-lg transform transition-all duration-500 z-50"
                >
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">🎉</span>
                        <div>
                            <div class="font-bold">{{ successMessage }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
