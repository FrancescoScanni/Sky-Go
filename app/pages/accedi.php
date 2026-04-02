<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky&GO - Accedi</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandPrimary: '#C48B7D', 
                        inputBg: '#E4EBEC'       
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="../static/css/form.css">
    <link rel="stylesheet" href="../static/css/style.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="accedi">
    
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl p-8">
        
        <div class="text-center mb-8">
            <div class="text-brandPrimary text-4xl mb-3">
                <i class="fa-solid fa-plane-arrival"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Bentornato a bordo</h2>
            <p class="text-sm text-gray-500 mt-2">Inserisci le tue credenziali per accedere.</p>
        </div>

        <form action="#" method="POST" class="space-y-5">
            
            <div class="relative">
                <i class="fa-solid fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="login-id" placeholder="Email o Numero di Telefono" class="w-full bg-inputBg text-gray-700 text-sm pl-11 pr-4 py-3.5 rounded-xl outline-none focus:ring-2 focus:ring-brandPrimary transition">
            </div>

            <div class="relative">
                <i class="fa-solid fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="password" id="login-password" placeholder="Password" class="w-full bg-inputBg text-gray-700 text-sm pl-11 pr-4 py-3.5 rounded-xl outline-none focus:ring-2 focus:ring-brandPrimary transition">
            </div>

            <div class="flex justify-end">
                <a href="#" class="text-xs text-gray-500 hover:text-brandPrimary transition">Hai dimenticato la password?</a>
            </div>

            <div class="pt-4 space-y-4">
                <button type="button" id="btnAccedi" class="w-full bg-brandPrimary hover:bg-opacity-90 text-white py-3.5 rounded-xl font-semibold transition shadow-md">
                    Accedi
                </button>
                
                <div class="text-center text-sm text-gray-500 pt-3 border-t border-gray-100">
                    Non hai ancora un account? <a href="registra.php" class="text-brandPrimary font-semibold hover:underline">Registrati qui</a>
                </div>

                <a href="../index.php" class="block text-center text-sm text-gray-400 hover:text-gray-600 transition w-full">
                    Torna alla Home
                </a>
            </div>

        </form>
    </div>

</body>
</html>