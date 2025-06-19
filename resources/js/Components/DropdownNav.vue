<template>
    <div class="relative">
        <!-- Trigger -->
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div
            v-show="open"
            class="fixed inset-0 z-40"
            @click="open = false"
        ></div>        <!-- Dropdown -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-show="open"
                class="absolute z-50 mt-2 rounded-md shadow-lg border border-gray-200 dark:border-gray-600"
                :class="[widthClass, alignmentClasses]"
                @click="open = false"
            >
                <div class="rounded-md bg-white dark:bg-gray-800 ring-1 ring-black/5 dark:ring-white/10 py-1">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '48',
    },
})

const open = ref(false)

const widthClass = computed(() => {
    return {
        32: 'w-32',
        48: 'w-48',
        64: 'w-64',
        80: 'w-80',
    }[props.width.toString()]
})

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'ltr:origin-top-left rtl:origin-top-right start-0'
    } else if (props.align === 'right') {
        return 'ltr:origin-top-right rtl:origin-top-left end-0'
    } else {
        return 'origin-top'
    }
})

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false
    }
}

onMounted(() => document.addEventListener('keydown', closeOnEscape))
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))
</script>
