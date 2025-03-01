<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Números</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen flex items-center justify-center bg-gray-100">
  <div class=" from-blue-50 to-indigo-50 w-screen min-h-screen flex items-center justify-center">
    <div class="bg-[#F5F5F5] rounded-2xl p-8 shadow-[9px_9px_0px_#2C3E50] border-3 border-[#2C3E50] max-w-md w-full flex gap-6 relative">
        <div class="w-1/2">
            <img src="https://64.media.tumblr.com/d9ff179b79bfc308b438fdb0361774a6/82081de09070662c-fa/s1280x1920/8492c306b3268f25c7f92dcbb3d9a5484a594494.png" alt="Anime character with fishing rod" class="h-full object-cover">
        </div>
        <div class="w-1/2 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-2">Validación Número</h1>
            <div class="shadow-2xl inline-block bg-green-500 text-white px-2 py-0.5 rounded text-sm w-16">Desafío</div>
            <form action="procesar.php" method="POST">
                <label class="block mb-2">Ingrese sus números:</label>
                <input 
                    type="text" 
                    name="numeros" 
                    class="bg-[#efeaea] rounded p-2 mb-4 w-full" 
                    placeholder="Ej: 2,3,5,8,13"
                    required
                >
                <button type="submit" class="bg-black text-white py-2 px-4 rounded hover:bg-gray-800 transition-colors w-full shadow-md">
                    Validar
                </button>
            </form>
        </div>
    </div>
  </div>
</body>
</html>
