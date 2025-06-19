<?php

/**
 * Script para generar APP_KEY válida para Laravel
 * Uso: php generate-app-key.php
 */

// Generar clave de 32 caracteres para AES-256-CBC
$key = base64_encode(random_bytes(32));

echo "=== CLAVE DE APLICACIÓN GENERADA ===\n";
echo "Copia y pega esta línea completa en las variables de entorno de Render:\n\n";
echo "APP_KEY=base64:{$key}\n\n";
echo "IMPORTANTE:\n";
echo "- Incluye 'base64:' al inicio\n";
echo "- Esta clave es única, guárdala de forma segura\n";
echo "- Úsala en la variable APP_KEY en Render\n";
echo "=====================================\n";
