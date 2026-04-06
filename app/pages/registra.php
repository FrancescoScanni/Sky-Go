<?php
    session_start(); //avvio sessione
    require_once("generalFunctions.php");
    require_once("../models/passeggero.php");
    

    $err=false;
    $nomeErr=$cognomeErr=$mailErr=$telefonoErr=$dataErr=$genereErr=$passwordErr="";


    //prendo variabili di sessione
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(!preg_match("/^[a-zA-ZÀ-ÿ'!? -]+$/",$_POST["nome"])){
            $nomeErr="*Solo lettere alfabetiche";
            $err=true;
        }else{
            $nome = sanitize($_POST["nome"]);
        }
        if(!preg_match("/^[a-zA-ZÀ-ÿ'!? -]+$/",$_POST["cognome"])){
            $cognomeErr="*Solo lettere alfabetiche";
            $err=true;
        }else{
            $cognome=sanitize($_POST["cognome"]);
        }
        if(empty($_POST["mail"])){
            
        }else{
            $mail=sanitize($_POST["mail"]);
        }
        if(empty($_POST["telefono"])){
            $telefonoErr="valore non accettato";
            $err=true;
        }else{
            $telefono=sanitize($_POST["telefono"]);
        }
        if(empty($_POST["data"])){
            $dataErr="valore non accettato";
            $err=true;
        }else{
            $data=sanitize($_POST["data"]);
        }
        if(empty($_POST["genere"])){
            $genereErr="valore non accettato";
            $err=true;
        }else{
            $genere=sanitize($_POST["genere"]);
        }
        if(!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/", $_POST["password"])){
            $passwordErr="*Almeno una maiuscola, un carattere speciale, un numero";
            $err=true;
        }else{
            $password=sanitize($_POST["password"]);
        }

        if(!$err){
            //istanzio un nuovo utente
            $passeggero=new Passeggero($nome,$cognome,$mail,$telefono,$data,$genere,$password);
            try{
                //salvo il nuovo passeggero nel DB
                $passeggero->salva();
                $_SESSION['registrato']=true;
            }catch(Exception $e){
                echo $e;
                exit;
            }
        }

    }
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky&GO - Registrazione</title>

    <link rel="stylesheet" href="../static/css/form.css">
    <link rel="stylesheet" href="../static/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
</head>


<body class="registra">
    
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div> <!--sfondo opaco-->


    <!--Main body-->
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl p-8">

        
        <!--Return home-->
        <div class="absolute">
                <a href="../index.php" class="text-[14px]">Home</a>
        </div>
        <!--Banner titolo-->
        <div class="text-center mb-8">
            <div class="text-brandPrimary text-4xl mb-3">
                <i class="fa-solid fa-plane-departure"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Benvenuto a bordo!</h2>
            <p class="text-sm text-gray-500 mt-2">Completa i tuoi dati per creare l'account.</p>
        </div>



        <!--Form registrazione-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="space-y-6">

            <!--Nome e cognome-->
            <div class="grid grid-cols-2 gap-4">
                <div class="relative h-[8vh]">
                    <input type="text" name="nome" id="reg-nome" placeholder="Nome (A-z)" class="custom bg-inputBg" required>
                    <span class="error ml-[10px] text-[#ff0000] text-[10px]"><b><?php echo $nomeErr;?></b></span><br><br>
                </div>
                <div class="relative h-[8vh]">
                    <input type="text" name="cognome" id="reg-cognome" placeholder="Cognome (A-z)" class="custom bg-inputBg" required>
                    <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $cognomeErr;?></span><br><br>
                </div>
            </div>

            <!--Mail-->
            <div class="relative h-[8vh]">
                <input type="email" name="mail" id="reg-mail" placeholder="Indirizzo Email" class="custom bg-inputBg" required>
                <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $mailErr;?></span><br><br>
            </div>

            <!--Telefono-->
            <div class="relative h-[8vh]">
                <input type="tel" name="telefono" id="reg-telefono" placeholder="Numero di Telefono" class="custom bg-inputBg" required>
                <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $telefonoErr;?></span><br><br>
            </div>

            <!--MData e genere-->
            <div class="grid grid-cols-2 gap-4">
                <div class="relative h-[6vh]">
                    <input type="date" name="data" id="reg-data" class="custom bg-inputBg" required>
                    <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $dataErr;?></span><br><br>
                </div>
                <div class="relative h-[8vh]">
                    <select name="genere" id="reg-genere" class="w-full bg-inputBg text-gray-400 text-sm pl-11 pr-4 py-3.5 rounded-xl outline-none focus:ring-2 focus:ring-brandPrimary transition appearance-none cursor-pointer" required>
                        <option value="" disabled selected >Genere</option>
                        <option value="M">Maschio (M)</option>
                        <option value="F">Femmina (F)</option>
                    </select>
                    
                </div>
            </div>

            <!--Password-->
            <div class="relative h-[6vh]">
                <input type="password" name="password" id="reg-password" placeholder="Password (es. 123Char!)" class="custom bg-inputBg" required>
                <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $passwordErr;?></span><br><br>
            </div>

            <!--INVIO-->
            <div class="pt-4 space-y-3">
                <button type="submit" id="btnRegistrati" class="w-full bg-brandPrimary hover:bg-opacity-90 text-white py-3.5 rounded-xl font-semibold transition shadow-md">
                    Registrati Ora
                </button>
                <!--Redirect a login-->
                <a href="accedi.php" class="block text-center text-sm text-gray-500 hover:text-brandPrimary transition w-full py-2">
                    Hai già un account? Accedi
                </a>
            </div>

        </form>
    </div>

</body>
</html>