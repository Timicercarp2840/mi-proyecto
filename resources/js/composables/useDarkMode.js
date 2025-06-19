import { ref, computed, watch } from 'vue'

const isDark = ref(false)

// Inicializar desde localStorage al cargar
if (typeof window !== 'undefined') {
    const saved = localStorage.getItem('darkMode')
    isDark.value = saved ? JSON.parse(saved) : false
    
    // Aplicar clase inicial
    if (isDark.value) {
        document.documentElement.classList.add('dark')
    }
}

export function useDarkMode() {
    const toggleDarkMode = () => {
        isDark.value = !isDark.value
        
        // Guardar en localStorage
        localStorage.setItem('darkMode', JSON.stringify(isDark.value))
        
        // Aplicar/quitar clase al html
        if (isDark.value) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    }

    const setDarkMode = (value) => {
        isDark.value = value
        localStorage.setItem('darkMode', JSON.stringify(value))
        
        if (value) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    }

    return {
        isDark: computed(() => isDark.value),
        toggleDarkMode,
        setDarkMode
    }
}
