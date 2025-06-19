<template>
    <Head title="Editar Desafío" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Editar Desafío: {{ desafio.titulo }}
                </h2>
                <Link :href="route('admin.desafios')" 
                      class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Volver
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submitForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Título -->
                                <div class="md:col-span-2">
                                    <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Título del Desafío
                                    </label>
                                    <input 
                                        id="titulo"
                                        v-model="form.titulo"
                                        type="text" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    />
                                    <div v-if="errors.titulo" class="text-red-600 text-sm mt-1">{{ errors.titulo }}</div>
                                </div>

                                <!-- Nivel -->
                                <div>
                                    <label for="nivel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nivel
                                    </label>
                                    <input 
                                        id="nivel"
                                        v-model.number="form.nivel"
                                        type="number" 
                                        min="1"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    />
                                    <div v-if="errors.nivel" class="text-red-600 text-sm mt-1">{{ errors.nivel }}</div>
                                </div>

                                <!-- Tipo -->
                                <div>
                                    <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Tipo de Desafío
                                    </label>
                                    <select 
                                        id="tipo"
                                        v-model="form.tipo"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    >
                                        <option value="">Seleccionar tipo</option>
                                        <option value="terminal">🖥️ Terminal</option>
                                        <option value="filesystem">📁 Sistema de Archivos</option>
                                        <option value="permisos">🔐 Permisos</option>
                                        <option value="general">🎯 General</option>
                                    </select>
                                    <div v-if="errors.tipo" class="text-red-600 text-sm mt-1">{{ errors.tipo }}</div>
                                </div>

                                <!-- XP Recompensa -->
                                <div>
                                    <label for="xp_recompensa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        XP de Recompensa
                                    </label>
                                    <input 
                                        id="xp_recompensa"
                                        v-model.number="form.xp_recompensa"
                                        type="number" 
                                        min="1"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    />
                                    <div v-if="errors.xp_recompensa" class="text-red-600 text-sm mt-1">{{ errors.xp_recompensa }}</div>
                                </div>

                                <!-- Estado -->
                                <div>
                                    <label class="flex items-center">
                                        <input 
                                            v-model="form.activo"
                                            type="checkbox" 
                                            class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        />
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Desafío activo</span>
                                    </label>
                                </div>

                                <!-- Descripción -->
                                <div class="md:col-span-2">
                                    <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Descripción
                                    </label>
                                    <textarea 
                                        id="descripcion"
                                        v-model="form.descripcion"
                                        rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    ></textarea>
                                    <div v-if="errors.descripcion" class="text-red-600 text-sm mt-1">{{ errors.descripcion }}</div>
                                </div>

                                <!-- Criterios de Validación -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Criterios de Validación
                                    </label>
                                    
                                    <div class="space-y-3">
                                        <div v-for="(criterio, index) in form.criterios_validacion" :key="index"
                                             class="flex items-center space-x-2">
                                            <input 
                                                v-model="criterio.comando"
                                                type="text" 
                                                placeholder="Comando esperado"
                                                class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            />
                                            <input 
                                                v-model="criterio.descripcion"
                                                type="text" 
                                                placeholder="Descripción del criterio"
                                                class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            />
                                            <button 
                                                type="button"
                                                @click="removeCriterio(index)"
                                                class="text-red-600 hover:text-red-800"
                                            >
                                                🗑️
                                            </button>
                                        </div>
                                        
                                        <button 
                                            type="button"
                                            @click="addCriterio"
                                            class="text-blue-600 hover:text-blue-800 text-sm"
                                        >
                                            ➕ Agregar criterio
                                        </button>
                                    </div>
                                    <div v-if="errors.criterios_validacion" class="text-red-600 text-sm mt-1">{{ errors.criterios_validacion }}</div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="mt-6 flex justify-end space-x-3">
                                <Link :href="route('admin.desafios')"
                                      class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Cancelar
                                </Link>
                                <button 
                                    type="submit"
                                    :disabled="processing"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                                >
                                    {{ processing ? 'Actualizando...' : 'Actualizar Desafío' }}
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
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    desafio: Object,
    errors: Object
})

const form = useForm({
    titulo: props.desafio.titulo,
    nivel: props.desafio.nivel,
    descripcion: props.desafio.descripcion,
    tipo: props.desafio.tipo,
    criterios_validacion: props.desafio.criterios_validacion || [{ comando: '', descripcion: '' }],
    xp_recompensa: props.desafio.xp_recompensa,
    activo: props.desafio.activo
})

const addCriterio = () => {
    form.criterios_validacion.push({ comando: '', descripcion: '' })
}

const removeCriterio = (index) => {
    if (form.criterios_validacion.length > 1) {
        form.criterios_validacion.splice(index, 1)
    }
}

const submitForm = () => {
    form.put(route('admin.desafios.update', props.desafio.id_desafio))
}
</script>
