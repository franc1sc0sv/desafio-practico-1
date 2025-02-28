<?php

function validarNombre($nombre)
{
    if (preg_match('/[0-9]/', $nombre)) {
        return "❌ El nombre no debe contener números.";
    }
    return null;
}

function calcularTotal($precio, $cantidad)
{
    return $precio * $cantidad;
}

function calcularVuelto($pago, $total)
{
    return $pago - $total;
}

function desglosarVuelto($vuelto)
{
    $billetes = [100, 50, 20, 10, 5, 1];
    $monedas = [0.50, 0.25, 0.10, 0.05, 0.01];

    $desglose = [];

    foreach ($billetes as $billete) {
        if ($vuelto >= $billete) {
            $desglose["\$$billete"] = floor($vuelto / $billete);
            $vuelto = fmod($vuelto, $billete);
        }
    }

    foreach ($monedas as $moneda) {
        if ($vuelto >= $moneda) {
            $desglose["\$$moneda"] = floor($vuelto / $moneda);
            $vuelto = round(fmod($vuelto, $moneda), 2);
        }
    }

    return $desglose;
}

$errores = [];
$total = $vuelto = 0;
$desglose = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $precio = floatval($_POST["precio"]);
    $cantidad = intval($_POST["cantidad"]);
    $pago = floatval($_POST["pago"]);

    $errorNombre = validarNombre($nombre);
    if ($errorNombre) {
        $errores[] = $errorNombre;
    }

    $total = calcularTotal($precio, $cantidad);
    $vuelto = calcularVuelto($pago, $total);

    if ($vuelto < 0) {
        $errores[] = "❌ El pago es insuficiente. Debes pagar al menos <strong>$" . number_format($total, 2) . "</strong>.";
    } else {
        $desglose = desglosarVuelto($vuelto);
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Compra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Resumen de Compra</h2>

        <?php if (!empty($errores)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4 rounded relative">
                <strong class="font-bold">¡Error!</strong>
                <ul class="mt-2">
                    <?php foreach ($errores as $error): ?>
                        <li>⚠️ <?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <p class="mb-2"><strong>👤 Cliente:</strong> <?php echo htmlspecialchars($nombre); ?></p>
            <p class="mb-2"><strong>💰 Total a Pagar:</strong> $<?php echo number_format($total, 2); ?></p>
            <p class="mb-2"><strong>💵 Pago Realizado:</strong> $<?php echo number_format($pago, 2); ?></p>
            <p class="mb-2"><strong>🔄 Vuelto:</strong> $<?php echo number_format($vuelto, 2); ?></p>

            <h3 class="text-lg font-bold mt-4">🤑 Desglose del Vuelto:</h3>
            <ul class="list-disc list-inside">
                <?php foreach ($desglose as $denominacion => $cantidad): ?>
                    <li>🟢 <?php echo "$cantidad x $denominacion"; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="text-center mt-6">
            <a href="index.html" class="inline-block px-6 py-3 text-white font-semibold bg-blue-600 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:bg-blue-700 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                🔄 Volver al formulario
            </a>
        </div>

    </div>

</body>

</html>