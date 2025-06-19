<template>
    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <!-- Cuerpo del pingüino -->
        <ellipse cx="50" cy="65" rx="25" ry="30" fill="#2c3e50"/>
        
        <!-- Barriga blanca -->
        <ellipse cx="50" cy="68" rx="16" ry="22" fill="#ecf0f1"/>
        
        <!-- Cabeza -->
        <circle cx="50" cy="35" r="18" fill="#2c3e50"/>
        
        <!-- Cara blanca -->
        <ellipse cx="50" cy="38" rx="12" ry="14" fill="#ecf0f1"/>
        
        <!-- Ojos -->
        <circle cx="45" cy="32" r="3" fill="#ffffff"/>
        <circle cx="55" cy="32" r="3" fill="#ffffff"/>
        <circle cx="45" cy="32" r="1.5" fill="#2c3e50"/>
        <circle cx="55" cy="32" r="1.5" fill="#2c3e50"/>
        
        <!-- Pico -->
        <polygon points="50,38 46,42 54,42" fill="#e67e22"/>
        
        <!-- Aletas -->
        <ellipse cx="25" cy="55" rx="8" ry="15" fill="#2c3e50" transform="rotate(-20 25 55)"/>
        <ellipse cx="75" cy="55" rx="8" ry="15" fill="#2c3e50" transform="rotate(20 75 55)"/>
        
        <!-- Patas -->
        <ellipse cx="42" cy="90" rx="5" ry="8" fill="#e67e22"/>
        <ellipse cx="58" cy="90" rx="5" ry="8" fill="#e67e22"/>
        
        <!-- Detalles en las patas -->
        <ellipse cx="42" cy="95" rx="7" ry="3" fill="#e67e22"/>
        <ellipse cx="58" cy="95" rx="7" ry="3" fill="#e67e22"/>
        
        <!-- Mejillas rosadas -->
        <circle cx="38" cy="40" r="2" fill="#e74c3c" opacity="0.6"/>
        <circle cx="62" cy="40" r="2" fill="#e74c3c" opacity="0.6"/>
    </svg>
</template>
