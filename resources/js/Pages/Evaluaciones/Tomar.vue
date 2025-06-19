<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';

const props = defineProps({
    evaluacion: Object
});

const respuestas = reactive({});
const loading = ref(false);

const submitEvaluacion = () => {
    loading.value = true;
    
    router.post(route('evaluaciones.calificar', props.evaluacion.id_eval), {
        respuestas: respuestas
    }, {
        onFinish: () => {
            loading.value = false;
        }
    });
};
</script>

<template>
    <Head :title="`Evaluación - ${evaluacion.modulo.titulo} - SABLE`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Evaluación: {{ evaluacion.modulo.titulo }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Nivel {{ evaluacion.modulo.nivel }}</p>
                </div>
                <Link 
                    :href="route('modulos.show', evaluacion.modulo.id_modulo)"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    ← Volver al Módulo
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <!-- Formulario de evaluación -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                Instrucciones
                            </h3>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Selecciona la respuesta correcta para cada pregunta</li>
                                <li>• Necesitas al menos 70% para aprobar</li>
                                <li>• Puedes repetir la evaluación las veces que necesites</li>
                                <li>• Revisa todas tus respuestas antes de enviar</li>
                            </ul>
                        </div>

                        <form @submit.prevent="submitEvaluacion">
                            <div 
                                v-for="(pregunta, index) in evaluacion.contenido_eval" 
                                :key="index"
                                class="mb-8 border-b border-gray-200 pb-6 last:border-b-0"
                            >
                                <h4 class="text-lg font-medium text-gray-900 mb-4">
                                    {{ index + 1 }}. {{ pregunta.pregunta }}
                                </h4>
                                
                                <div class="space-y-3">
                                    <div 
                                        v-for="(opcion, opcionIndex) in pregunta.opciones" 
                                        :key="opcionIndex"
                                        class="flex items-center"
                                    >
                                        <input 
                                            :id="`pregunta_${index}_opcion_${opcionIndex}`"
                                            v-model="respuestas[index]"
                                            :value="opcionIndex"
                                            type="radio"
                                            :name="`pregunta_${index}`"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                            required
                                        >
                                        <label 
                                            :for="`pregunta_${index}_opcion_${opcionIndex}`"
                                            class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer"
                                        >
                                            {{ opcion }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-6">
                                <p class="text-sm text-gray-600">
                                    {{ Object.keys(respuestas).length }} de {{ evaluacion.contenido_eval.length }} preguntas respondidas
                                </p>
                                
                                <button 
                                    type="submit"
                                    :disabled="Object.keys(respuestas).length !== evaluacion.contenido_eval.length || loading"
                                    class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <span v-if="loading" class="mr-2">
                                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                    {{ loading ? 'Enviando...' : 'Enviar Evaluación' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
