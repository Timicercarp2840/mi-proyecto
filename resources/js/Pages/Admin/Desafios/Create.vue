<template>
    <Head title="Crear Desafío" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                ➕ Crear Nuevo Desafío
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Título -->
                                <div class="md:col-span-2">
                                    <label for="titulo" class="block text-sm font-medium mb-2">Título del Desafío</label>
                                    <input
                                        id="titulo"
                                        v-model="form.titulo"
                                        type="text"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                        required
                                    />
                                    <div v-if="errors.titulo" class="text-red-600 text-sm mt-1">{{ errors.titulo }}</div>
                                </div>

                                <!-- Tipo -->
                                <div>
                                    <label for="tipo" class="block text-sm font-medium mb-2">Tipo de Desafío</label>
                                    <select
                                        id="tipo"
                                        v-model="form.tipo"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                        required
                                    >
                                        <option value="">Seleccionar tipo</option>
                                        <option value="terminal">💻 Terminal</option>
                                        <option value="filesystem">📁 Sistema de Archivos</option>
                                        <option value="permisos">🔐 Permisos</option>
                                    </select>
                                    <div v-if="errors.tipo" class="text-red-600 text-sm mt-1">{{ errors.tipo }}</div>
                                </div>

                                <!-- Nivel -->
                                <div>
                                    <label for="nivel" class="block text-sm font-medium mb-2">Nivel de Dificultad</label>
                                    <select
                                        id="nivel"
                                        v-model="form.nivel"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                        required
                                    >
                                        <option value="">Seleccionar nivel</option>
                                        <option value="1">🟢 Principiante</option>
                                        <option value="2">🟡 Intermedio</option>
                                        <option value="3">🔴 Avanzado</option>
                                    </select>
                                    <div v-if="errors.nivel" class="text-red-600 text-sm mt-1">{{ errors.nivel }}</div>
                                </div>

                                <!-- XP Recompensa -->
                                <div>
                                    <label for="xp_recompensa" class="block text-sm font-medium mb-2">XP de Recompensa</label>
                                    <input
                                        id="xp_recompensa"
                                        v-model="form.xp_recompensa"
                                        type="number"
                                        min="1"
                                        max="1000"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                        required
                                    />
                                    <div v-if="errors.xp_recompensa" class="text-red-600 text-sm mt-1">{{ errors.xp_recompensa }}</div>
                                </div>

                                <!-- Descripción -->
                                <div class="md:col-span-2">
                                    <label for="descripcion" class="block text-sm font-medium mb-2">Descripción</label>
                                    <textarea
                                        id="descripcion"
                                        v-model="form.descripcion"
                                        rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                        required
                                    ></textarea>
                                    <div v-if="errors.descripcion" class="text-red-600 text-sm mt-1">{{ errors.descripcion }}</div>
                                </div>

                                <!-- Criterios de Validación -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium mb-2">Criterios de Validación</label>
                                    
                                    <!-- Comandos Esperados (para tipo terminal) -->
                                    <div v-if="form.tipo === 'terminal'" class="space-y-3">
                                        <div class="flex items-center space-x-2">
                                            <input
                                                v-model="nuevoComando"
                                                type="text"
                                                placeholder="Ej: ls, cd, pwd..."
                                                class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                            />
                                            <button
                                                type="button"
                                                @click="agregarComando"
                                                class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded"
                                            >
                                                ➕
                                            </button>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span
                                                v-for="(comando, index) in form.criterios_validacion.comandos_esperados"
                                                :key="index"
                                                class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm"
                                            >
                                                {{ comando }}
                                                <button
                                                    type="button"
                                                    @click="eliminarComando(index)"
                                                    class="ml-2 text-blue-600 hover:text-blue-800"
                                                >
                                                    ✕
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Archivos/Directorios (para filesystem) -->
                                    <div v-else-if="form.tipo === 'filesystem'" class="space-y-3">
                                        <textarea
                                            v-model="criteriosTexto"
                                            rows="4"
                                            placeholder="Estructura de archivos esperada (JSON):"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-mono text-sm"
                                        ></textarea>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Ejemplo: {"archivos": ["test.txt"], "directorios": ["carpeta1"]}
                                        </p>
                                    </div>

                                    <!-- Permisos (para permisos) -->
                                    <div v-else-if="form.tipo === 'permisos'" class="space-y-3">
                                        <textarea
                                            v-model="criteriosTexto"
                                            rows="4"
                                            placeholder="Configuración de permisos esperada (JSON):"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-mono text-sm"
                                        ></textarea>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Ejemplo: {"archivo": "test.txt", "permisos": "644"}
                                        </p>
                                    </div>

                                    <div v-if="errors.criterios_validacion" class="text-red-600 text-sm mt-1">{{ errors.criterios_validacion }}</div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="flex justify-end space-x-4 mt-8">
                                <Link 
                                    :href="route('admin.desafios')"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    Cancelar
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="processing"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                                >
                                    {{ processing ? 'Creando...' : 'Crear Desafío' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    errors: Object,
});

const form = ref({
    titulo: '',
    descripcion: '',
    tipo: '',
    nivel: '',
    criterios_validacion: {
        comandos_esperados: []
    },
    xp_recompensa: 25
});

const nuevoComando = ref('');
const criteriosTexto = ref('');
const processing = ref(false);

// Watch para actualizar criterios_validacion según el tipo
watch(() => form.value.tipo, (nuevoTipo) => {
    if (nuevoTipo === 'terminal') {
        form.value.criterios_validacion = {
            comandos_esperados: []
        };
    } else {
        form.value.criterios_validacion = {};
        criteriosTexto.value = '';
    }
});

// Watch para actualizar criterios desde el textarea
watch(criteriosTexto, (nuevoTexto) => {
    if (form.value.tipo !== 'terminal' && nuevoTexto) {
        try {
            form.value.criterios_validacion = JSON.parse(nuevoTexto);
        } catch (e) {
            // Ignorar errores de JSON malformado hasta que el usuario termine
        }
    }
});

const agregarComando = () => {
    if (nuevoComando.value.trim()) {
        form.value.criterios_validacion.comandos_esperados.push(nuevoComando.value.trim());
        nuevoComando.value = '';
    }
};

const eliminarComando = (index) => {
    form.value.criterios_validacion.comandos_esperados.splice(index, 1);
};

const submit = () => {
    processing.value = true;
    
    router.post(route('admin.desafios.store'), form.value, {
        onFinish: () => processing.value = false,
    });
};
</script>
