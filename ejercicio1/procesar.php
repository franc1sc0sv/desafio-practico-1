<?php
// Funciones requeridas
function esPrimo($n) {
    if ($n < 2) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}

function obtenerPrimos($numeros) {
    return array_filter($numeros, "esPrimo");
}

function sumarNumeros($numeros) {
    return array_sum($numeros);
}

function contarNumeros($numeros) {
    return count($numeros);
}

// Procesamiento principal
$errores = [];
$resultados = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = trim($_POST['numeros'] ?? '');
    
    if (empty($input) && $input !=0) {
        $errores[] = "Debes ingresar números para analizar";
    } else {
        $numeros_str = explode(",", $input);
        $numeros = [];
        
        foreach ($numeros_str as $numStr) {
            if (!is_numeric($numStr)) {
                $errores[] = "'$numStr' no es un número válido";
            } else {
                $num = (int)$numStr;
                if ($num < 0) {
                    $errores[] = "El número $num es negativo. Solo se permiten valores positivos";
                }
                $numeros[] = $num;
            }
        }
        
        if (empty($errores)) {
            $resultados = [
                'ingresados' => $numeros,
                'primos' => obtenerPrimos($numeros),
                'suma' => sumarNumeros($numeros),
                'conteo' => contarNumeros($numeros)
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analizador de Números</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center p-4">
    <div class="w-full max-w-2xl space-y-6">


        <!-- Resultados/Errores -->
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
                <?php if (!empty($errores)): ?>
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <h3 class="text-red-800 font-semibold mb-2">⚠️ Errores detectados:</h3>
                        <ul class="list-disc list-inside space-y-1">
                            <?php foreach ($errores as $error): ?>
                                <li class="text-red-600"><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Sección de resultados -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Resultados del análisis</h2>
                        
                        <!-- Tarjeta números ingresados -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Números ingresados</h3>
                            <p class="font-mono text-gray-800"><?= implode(', ', $resultados['ingresados']) ?></p>
                        </div>

                        <!-- Tarjeta números primos -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-green-600 mb-1">Números primos encontrados</h3>
                            <p class="font-mono text-gray-800">
                                <?= !empty($resultados['primos']) ? implode(', ', $resultados['primos']) : 'Ninguno' ?>
                            </p>
                        </div>

                        <!-- Estadísticas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="text-sm font-medium text-blue-600 mb-1">Suma total</h3>
                                <p class="text-2xl font-bold text-gray-800"><?= $resultados['suma'] ?></p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <h3 class="text-sm font-medium text-purple-600 mb-1">Cantidad de números</h3>
                                <p class="text-2xl font-bold text-gray-800"><?= $resultados['conteo'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Botón para volver (sólo en resultados) -->
                <div class="pt-4 border-t border-gray-100">
                    <a href="/ejercicio1/index.php" 
                       class="block text-center bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors">
                        ← Realizar nuevo análisis
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>