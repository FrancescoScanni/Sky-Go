<?php
    session_start(); //session start
    require_once("generalFunctions.php");
    require_once("../models/passeggero.php");
    

    $err=false;
    $nomeErr=$cognomeErr=$mailErr=$telefonoErr=$dataErr=$genereErr=$passwordErr="";


    //get session variables
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(!preg_match("/^[a-zA-ZÀ-ÿ'!? -]+$/",$_POST["nome"])){
            $nomeErr="*Alphabetic letters only";
            $err=true;
        }else{
            $nome = sanitize($_POST["nome"]);
        }
        if(!preg_match("/^[a-zA-ZÀ-ÿ'!? -]+$/",$_POST["cognome"])){
            $cognomeErr="*Alphabetic letters only";
            $err=true;
        }else{
            $cognome=sanitize($_POST["cognome"]);
        }
        if(empty($_POST["mail"])){
            
        }else{
            $mail=sanitize($_POST["mail"]);
        }
        if(empty($_POST["telefono"]) || !preg_match('/^[0-9]{9,11}$/',$_POST["telefono"])){
            $telefonoErr="Invalid value";
            $err=true;
        }else{
            $telefono=sanitize($_POST["telefono"]);
        }
        if(empty($_POST["data"])){
            $dataErr="Invalid value";
            $err=true;
        }else{
            $data=sanitize($_POST["data"]);
        }
        if(empty($_POST["genere"])){
            $genereErr="Invalid value";
            $err=true;
        }else{
            $genere=sanitize($_POST["genere"]);
        }
        if(!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/", $_POST["password"])){
            $passwordErr="*At least one uppercase letter, one special character, and one number";
            $err=true;
        }else{
            $password=sanitize($_POST["password"]);
        }

        if(!$err){
            //instantiate a new user
            $passeggero=new Passeggero($nome,$cognome,$mail,$telefono,$data,$genere,$password);
            try{
                //save new passenger to DB
                if($passeggero->salva()){
                    $_SESSION['registrato']=true;
                }else{
                    echo $giaPresente;
                }
                
            }catch(Exception $e){
                echo $e;
                exit;
            }
        }

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky&GO - Registration</title>

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
    
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div> <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl p-8">

        
        <div class="absolute">
                <a href="../index.php" class="text-[14px]">Home</a>
        </div>
        <div class="text-center mb-8">
            <div class="text-brandPrimary text-4xl mb-3">
                <i class="fa-solid fa-plane-departure"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Welcome aboard!</h2>
            <p class="text-sm text-gray-500 mt-2">Complete your details to create an account.</p>
        </div>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="space-y-6">

            <div class="grid grid-cols-2 gap-4">
                <div class="relative h-[8vh]">
                    <input type="text" name="nome" id="reg-nome" placeholder="First Name (A-z)" class="custom bg-inputBg" required>
                    <span class="error ml-[10px] text-[#ff0000] text-[10px]"><b><?php echo $nomeErr;?></b></span><br><br>
                </div>
                <div class="relative h-[8vh]">
                    <input type="text" name="cognome" id="reg-cognome" placeholder="Last Name (A-z)" class="custom bg-inputBg" required>
                    <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $cognomeErr;?></span><br><br>
                </div>
            </div>

            <div class="relative h-[8vh]">
                <input type="email" name="mail" id="reg-mail" placeholder="Email Address" class="custom bg-inputBg" required>
                <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $mailErr;?></span><br><br>
            </div>

            <div class="relative h-[8vh]">
                <input type="tel" name="telefono" id="reg-telefono" placeholder="Phone Number" class="custom bg-inputBg" required>
                <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $telefonoErr;?></span><br><br>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="relative h-[6vh]">
                    <input type="date" name="data" id="reg-data" class="custom bg-inputBg" required>
                    <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $dataErr;?></span><br><br>
                </div>
                <div class="relative h-[8vh]">
                    <select name="genere" id="reg-genere" class="w-full bg-inputBg text-gray-400 text-sm pl-11 pr-4 py-3.5 rounded-xl outline-none focus:ring-2 focus:ring-brandPrimary transition appearance-none cursor-pointer" required>
                        <option value="" disabled selected >Gender</option>
                        <option value="M">Male (M)</option>
                        <option value="F">Female (F)</option>
                    </select>
                    
                </div>
            </div>

            <div class="relative h-[6vh]">
                <input type="password" name="password" id="reg-password" placeholder="Password (e.g. 123Char!)" class="custom bg-inputBg" required>
                <span class="error ml-[10px] text-[#ff0000] text-[10px]"><?php echo $passwordErr;?></span><br><br>
            </div>

            <div class="pt-4 space-y-3">
                <button type="submit" id="btnRegistrati" class="w-full bg-brandPrimary hover:bg-opacity-90 text-white py-3.5 rounded-xl font-semibold transition shadow-md">
                    Register Now
                </button>
                <a href="accedi.php" class="block text-center text-sm text-gray-500 hover:text-brandPrimary transition w-full py-2">
                    Already have an account? Log in
                </a>
            </div>

        </form>
    </div>

</body>
</html>