<template>
    <Head title="Editar Módulo" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Módulo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="nivel" class="block text-sm font-medium text-gray-700">
                                        Nivel
                                    </label>
                                    <input
                                        id="nivel"
                                        v-model="form.nivel"
                                        type="number"
                                        min="1"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    />
                                    <div v-if="errors.nivel" class="text-red-600 text-sm mt-1">
                                        {{ errors.nivel }}
                                    </div>
                                </div>

                                <div>
                                    <label for="titulo" class="block text-sm font-medium text-gray-700">
                                        Título
                                    </label>
                                    <input
                                        id="titulo"
                                        v-model="form.titulo"
                                        type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required
                                    />
                                    <div v-if="errors.titulo" class="text-red-600 text-sm mt-1">
                                        {{ errors.titulo }}
                                    </div>
                                </div>

                                <div>
                                    <label for="descripcion" class="block text-sm font-medium text-gray-700">
                                        Descripción
                                    </label>
                                    <textarea
                                        id="descripcion"
                                        v-model="form.descripcion"
                                        rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    ></textarea>
                                    <div v-if="errors.descripcion" class="text-red-600 text-sm mt-1">
                                        {{ errors.descripcion }}
                                    </div>
                                </div>

                                <div>
                                    <label for="contenido" class="block text-sm font-medium text-gray-700">
                                        Contenido
                                    </label>
                                    <textarea
                                        id="contenido"
                                        v-model="form.contenido"
                                        rows="8"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Escribe el contenido del módulo aquí..."
                                    ></textarea>
                                    <div v-if="errors.contenido" class="text-red-600 text-sm mt-1">
                                        {{ errors.contenido }}
                                    </div>
                                </div>

                                <div class="flex items-center justify-end space-x-4">
                                    <Link 
                                        :href="route('admin.modulos')"
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                    >
                                        Cancelar
                                    </Link>
                                    <button
                                        type="submit"
                                        :disabled="form.processing"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                                    >
                                        {{ form.processing ? 'Actualizando...' : 'Actualizar Módulo' }}
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

const props = defineProps({
    modulo: Object,
    errors: Object,
});

const form = useForm({
    nivel: props.modulo.nivel,
    titulo: props.modulo.titulo,
    descripcion: props.modulo.descripcion || '',
    contenido: props.modulo.contenido || '',
});

const submit = () => {
    form.put(route('admin.modulos.update', props.modulo.id_modulo));
};
</script>
