<template>
    <Head title="Crear Evaluación" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Nueva Evaluación
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="id_modulo" class="block text-sm font-medium text-gray-700">
                                        Módulo
                                    </label>
                                    <select
                                        id="id_modulo"
                                        v-model="form.id_modulo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    >
                                        <option value="">Selecciona un módulo</option>
                                        <option v-for="modulo in modulos" :key="modulo.id_modulo" :value="modulo.id_modulo">
                                            Nivel {{ modulo.nivel }} - {{ modulo.titulo }}
                                        </option>
                                    </select>
                                    <div v-if="errors.id_modulo" class="text-red-600 text-sm mt-1">
                                        {{ errors.id_modulo }}
                                    </div>
                                </div>

                                <div class="border-t pt-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">Preguntas</h3>
                                        <button
                                            type="button"
                                            @click="agregarPregunta"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            Agregar Pregunta
                                        </button>
                                    </div>

                                    <div v-for="(pregunta, index) in form.contenido_eval" :key="index" class="mb-6 p-4 border rounded-lg">
                                        <div class="flex justify-between items-start mb-3">
                                            <h4 class="text-md font-medium text-gray-700">Pregunta {{ index + 1 }}</h4>
                                            <button
                                                type="button"
                                                @click="eliminarPregunta(index)"
                                                class="text-red-600 hover:text-red-800"
                                            >
                                                Eliminar
                                            </button>
                                        </div>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Texto de la pregunta
                                                </label>
                                                <input
                                                    v-model="pregunta.pregunta"
                                                    type="text"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    required
                                                />
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Opciones de respuesta
                                                </label>
                                                <div v-for="(opcion, opcionIndex) in pregunta.opciones" :key="opcionIndex" class="flex items-center space-x-2 mb-2">
                                                    <input
                                                        type="radio"
                                                        :name="`respuesta_${index}`"
                                                        :value="opcionIndex"
                                                        v-model="pregunta.respuesta_correcta"
                                                        class="text-indigo-600"
                                                    />
                                                    <input
                                                        v-model="pregunta.opciones[opcionIndex]"
                                                        type="text"
                                                        placeholder="Opción de respuesta"
                                                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        required
                                                    />
                                                    <button
                                                        type="button"
                                                        @click="eliminarOpcion(index, opcionIndex)"
                                                        class="text-red-600 hover:text-red-800"
                                                        v-if="pregunta.opciones.length > 2"
                                                    >
                                                        ×
                                                    </button>
                                                </div>
                                                <button
                                                    type="button"
                                                    @click="agregarOpcion(index)"
                                                    class="text-blue-600 hover:text-blue-800 text-sm"
                                                >
                                                    + Agregar opción
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end space-x-4 pt-6 border-t">                                    <Link 
                                        :href="route('admin.modulos')"
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                    >
                                        Cancelar
                                    </Link>
                                    <button
                                        type="submit"
                                        :disabled="form.processing || form.contenido_eval.length === 0"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                                    >
                                        {{ form.processing ? 'Guardando...' : 'Crear Evaluación' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    modulos: Array,
    errors: Object,
});

const form = useForm({
    id_modulo: '',
    contenido_eval: [],
});

const agregarPregunta = () => {
    form.contenido_eval.push({
        pregunta: '',
        opciones: ['', ''],
        respuesta_correcta: 0,
    });
};

const eliminarPregunta = (index) => {
    form.contenido_eval.splice(index, 1);
};

const agregarOpcion = (preguntaIndex) => {
    form.contenido_eval[preguntaIndex].opciones.push('');
};

const eliminarOpcion = (preguntaIndex, opcionIndex) => {
    if (form.contenido_eval[preguntaIndex].opciones.length > 2) {
        form.contenido_eval[preguntaIndex].opciones.splice(opcionIndex, 1);
        // Ajustar respuesta correcta si es necesario
        if (form.contenido_eval[preguntaIndex].respuesta_correcta >= opcionIndex) {
            form.contenido_eval[preguntaIndex].respuesta_correcta = Math.max(0, form.contenido_eval[preguntaIndex].respuesta_correcta - 1);
        }
    }
};

const submit = () => {
    form.post(route('admin.evaluaciones.store'));
};
</script>
