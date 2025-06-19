import { ref, onMounted, watch } from 'vue'

const isDark = ref(false)

export function useDarkMode() {
    // Inicializar desde localStorage o preferencia del sistema
    onMounted(() => {
        const stored = localStorage.getItem('darkMode')
        if (stored) {
            isDark.value = JSON.parse(stored)
        } else {
            // Detectar preferencia del sistema
            isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches
        }
        
        // Aplicar la clase inicial
        updateDarkMode()
    })
    
    // Observar cambios y aplicarlos
    watch(isDark, () => {
        updateDarkMode()
        localStorage.setItem('darkMode', JSON.stringify(isDark.value))
    })
    
    function updateDarkMode() {
        if (isDark.value) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    }
    
    function toggleDarkMode() {
        isDark.value = !isDark.value
    }
    
    return {
        isDark,
        toggleDarkMode
    }
}
