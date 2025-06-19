<template>
    <component
        :is="tag"
        :href="href"
        :class="classes"
        v-bind="(tag === 'button') ? { type } : {}"
        @click="onClick"
    >
        <slot />
    </component>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    href: String,
    method: {
        type: String,
        default: 'GET',
    },
    as: String,
    type: {
        type: String,
        default: 'button',
    },
})

const emit = defineEmits(['click'])

const tag = computed(() => {
    if (props.as) return props.as
    return props.href ? 'a' : 'button'
})

const classes = computed(() => 
    'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out'
)

const onClick = (event) => {
    if (props.method !== 'GET' && props.href) {
        event.preventDefault()
        // Handle form submission for non-GET methods if needed
    }
    emit('click', event)
}
</script>
