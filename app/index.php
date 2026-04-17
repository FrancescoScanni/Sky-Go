<?php
    session_start();
    require_once("pages/generalFunctions.php");
    require_once("components/voliSection.php");
    setcookie("sessionID", "forzabari", time()+3600, "/");

    if(isset($_COOKIE['sessionID'])){
        //echo "Cookie sessionID presente e valido.";
    }else{
        $_SESSION['loggato']=false;
        echo $cookieMsg;
    }
    if(!isset($_SESSION['loggato'])){ //setto su falso a primo ingresso pagna 
        $_SESSION['loggato']=false;
    }
    if(!isset($_SESSION['AR'])){ //setto su false a primo ingresso pagina
        $_SESSION['AR']=false;
    }
    $_SESSION['idVolo'] = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky&GO - Find cheap flights at zero cost</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="static/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandPrimary: '#C48B7D', /* Il colore salmone/pesca dei bottoni */
                        searchBg: '#F3F5F6',     /* Il grigio chiarissimo del box di ricerca */
                        inputBg: '#E4EBEC'       /* Il grigio degli input field */
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="index">
    
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative w-full h-full flex flex-col justify-between pt-6 pb-12 px-4 md:px-12">

        <nav class="w-full max-w-7xl mx-auto bg-white/30 backdrop-blur-md rounded-2xl px-8 py-4 flex justify-between items-center shadow-sm">
            <div class="text-white text-3xl font-bold tracking-wider drop-shadow-md">Sky&GO</div>
            
            <div class="hidden md:flex space-x-10 text-gray-800 font-semibold text-sm">
                <a href="#titoli" class="hover:text-brandPrimary transition">Home</a>
                <a href="#hero2" class="hover:text-brandPrimary transition">About</a>
                <?php
                    if($_SESSION['loggato']===true){
                        echo '<a href="pages/prenotazioni.php" class="hover:text-brandPrimary transition">Bookings</a>';
                    }else{
                        echo '<a class="hover:text-brandPrimary transition cursor-not-allowed disabled">Bookings</a>';
                    }
                ?>

                <a href="#footer" class="hover:text-brandPrimary transition">Contact</a>
            </div>
            
            <div id="logBox" class="flex items-center space-x-6 text-sm font-semibold text-gray-800">
                <?php
                    if(isset($_SESSION['loggato'])&& $_SESSION['loggato']===true){
                        echo $homepageLoggato;
                    }else{
                        echo $homepageStandard;
                    }
                ?>
            </div>
        </nav>

        <div id="titoli" class="flex flex-col items-center justify-center text-center mt-12 md:mt-0 flex-grow">
            <h1 class="text-4xl md:text-5xl lg:text-[54px] text-white font-bold mb-6 max-w-4xl leading-tight drop-shadow-lg" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                Sky&Go: easily find cheap flights and leave whenever you want.
            </h1>
            <p class="text-white text-base md:text-lg max-w-3xl drop-shadow-md font-medium" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">
                Sky&Go is a platform designed to make searching for cheap flights quick and easy. With just a few steps, you can compare different offers. Our goal is to help you travel more, choosing the right flight at the right time and at the best available price.
            </p>
        </div>

        <?php
            if($_SESSION['AR']===false){
                echo $andataRitorno;
            }else{
                echo $soloAndata;
            }
        ?>
    </div>

    <div id="hero2" class="w-full bg-white text-slate-800">
        <div class="max-w-7xl mx-auto px-6 py-20 flex flex-col lg:flex-row items-center gap-16 lg:gap-24 overflow-hidden">
            
            <div class="relative w-full max-w-[420px] shrink-0 mx-auto lg:mx-0">
                
                <img src="https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Landscape" class="w-full h-[480px] object-cover rounded-[32px] shadow-sm">

                <div class="absolute bottom-8 -left-4 md:-left-8 bg-white px-5 py-2.5 rounded-full shadow-lg flex items-center space-x-2">
                    <i class="fa-solid fa-star text-yellow-400 text-lg"></i>
                    <span class="font-bold text-textDark text-lg">4.92</span>
                </div>

                <div class="absolute top-12 -right-8 md:-right-16 bg-white p-3 rounded-[24px] shadow-2xl w-[260px]">
                    
                    <div class="relative">
                        <img src="https://static.vecteezy.com/ti/foto-gratuito/p2/3023862-vista-in-volo-dalla-finestra-con-sfondo-tramonto-sbalorditivo-gratuito-foto.jpg" alt="Room" class="w-full h-36 object-cover rounded-[16px]">
                        <button class="absolute top-3 right-3 text-gray-700 hover:text-red-500 transition">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>

                    <div class="pt-3 px-1">
                        <div class="flex justify-between items-center mb-1">
                            <h4 class="font-bold text-textDark text-sm">New Delhi low cosy</h4>
                            <div class="flex items-center space-x-1">
                                <i class="fa-solid fa-star text-textDark text-[10px]"></i>
                                <span class="font-bold text-textDark text-xs">4.92</span>
                            </div>
                        </div>
                        
                        <p class="text-[10px] text-textGray leading-tight mb-3">
                            Reach never-before-seen destinations by taking advantage of our offers.
                        </p>

                        <div class="border-t border-dashed border-gray-300 my-3"></div>

                        <div class="flex justify-between items-center">
                            <div class="font-bold text-textDark text-sm">
                                €139.00 <span class="font-normal text-[10px] text-textGray"></span>
                            </div>
                            <div class="flex items-center space-x-1 text-textGray">
                                <i class="fa-solid fa-location-dot text-[10px] text-brandPrimary"></i>
                                <span class="text-[11px] font-medium">India</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:flex-1 flex flex-col space-y-6 mt-12 lg:mt-0">
                
                <div>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-textDark mb-4 tracking-tight">Why Choose Us</h2>
                    <p class="text-textGray font-medium leading-relaxed max-w-lg">
                        Discover a platform designed to make every trip simpler, faster, and more affordable, with the best offers just a click away.
                    </p>
                </div>

                <ul class="space-y-5 py-4">
                    <li class="flex items-center space-x-4">
                        <div class="w-3.5 h-3.5 bg-brandPrimary transform rotate-45 shrink-0 rounded-[2px]"></div>
                        <span class="font-bold text-textDark text-sm md:text-base">Quick Offer Comparison</span>
                    </li>
                    <li class="flex items-center space-x-4">
                        <div class="w-3.5 h-3.5 bg-brandPrimary transform rotate-45 shrink-0 rounded-[2px]"></div>
                        <span class="font-bold text-textDark text-sm md:text-base">Competitive and Affordable Prices</span>
                    </li>
                    <li class="flex items-center space-x-4">
                        <div class="w-3.5 h-3.5 bg-brandPrimary transform rotate-45 shrink-0 rounded-[2px]"></div>
                        <span class="font-bold text-textDark text-sm md:text-base">Wide Choice of Destinations Beyond Borders</span>
                    </li>
                    <li class="flex items-center space-x-4">
                        <div class="w-3.5 h-3.5 bg-brandPrimary transform rotate-45 shrink-0 rounded-[2px]"></div>
                        <span class="font-bold text-textDark text-sm md:text-base">Secure and Tracked Bookings</span>
                    </li>
                </ul>

                <p class="text-textGray font-medium leading-relaxed max-w-lg">
                    Coming soon: new features, reviews, baggage addition, travel packages, and much more!
                    <i class="fa-solid fa-plane text-brandPrimary ml-1 transform -rotate-45"></i>
                </p>

            </div>
        </div>
    </div>

    <footer id="footer" class="w-full bg-[#1A1C23] text-white pt-16 pb-8 font-sans">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 mb-16">
                
                <div class="lg:col-span-3 flex flex-col space-y-6">
                    <div>
                        <div class="border-[3px] border-white inline-block px-2 py-0.5">
                            <span class="font-bold text-3xl tracking-widest leading-none">SKYGO</span>
                        </div>
                    </div>
                    
                    <p class="text-gray-400 text-sm leading-relaxed pr-4">
                        Welcome to SkyGo. Our goal is to revolutionize the way you travel and buy flights.
                    </p>
                    
                    <div class="flex space-x-3">
                        <a href="https://it.linkedin.com/" class="w-10 h-10 rounded-full border border-gray-600 flex items-center justify-center text-gray-300 hover:bg-white hover:text-[#1A1C23] transition duration-300">
                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="https://github.com/FrancescoScanni" class="w-10 h-10 rounded-full border border-gray-600 flex items-center justify-center text-gray-300 hover:bg-white hover:text-[#1A1C23] transition duration-300">
                            <i class="fa-brands fa-github text-sm"></i>
                        </a>
                        <a href="mailto:frascanni07@gmail.com" class="w-10 h-10 rounded-full border border-gray-600 flex items-center justify-center text-gray-300 hover:bg-white hover:text-[#1A1C23] transition duration-300">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <h4 class="font-bold text-white mb-6">Product</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-400 text-sm hover:text-white transition">About us</a></li>
                        <li><a href="#hero2" class="text-gray-400 text-sm hover:text-white transition">Flight search</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h4 class="font-bold text-white mb-6">Support</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-400 text-sm hover:text-white transition">Contact us</a></li>
                        <li><a href="#" class="text-gray-400 text-sm hover:text-white transition">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h4 class="font-bold text-white mb-6">Partners</h4>
                    <ul class="space-y-4">
                        <li><a href="https://www.panettipitagora.edu.it/"  class="disabled text-gray-400 text-sm hover:text-white transition">School</a></li>
                        <li><a href="https://www.panettipitagora.edu.it/" class="text-gray-400 text-sm hover:text-white transition">ITT Panetti, BA</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-3">
                    <div class="bg-[#2A2C34] rounded-2xl p-6 shadow-lg">
                        <h4 class="font-bold text-white mb-4">Subscribe</h4>
                        
                        <div class="flex w-full mb-4">
                            <input type="email" placeholder="Email Address" class="w-full bg-white text-gray-800 text-sm px-4 py-2.5 rounded-l-md outline-none focus:ring-2 focus:ring-brandPrimary">
                            <button onclick="window.location.href='pages/registra.php'" class="bg-brandPrimary hover:bg-opacity-90 transition text-white px-4 py-2.5 rounded-r-md flex items-center justify-center">
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                        
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            Subscribe to receive updates on SkyGo and our latest news.
                        </p>
                    </div>
                </div>
                
            </div>

            <div class="border-t border-gray-700 pt-8 flex justify-center items-center">
                <div class="flex space-x-8 text-sm font-medium">
                    <a href="https://www.icann.org/" class="text-white hover:text-gray-300 transition">Terms</a>
                    <a href="https://www.iubenda.com/privacy-policy/34539065/cookie-policy" class="text-white hover:text-gray-300 transition">Privacy</a>
                    <a href="https://www.iubenda.com/privacy-policy/34539065" class="text-white hover:text-gray-300 transition">Cookies</a>
                </div>
            </div>
            
        </div>
    </footer>


    <script>
        //cambiare form di ricerca tra AR e A
        function cambiaForm() {
            <?php $_SESSION['AR'] = !$_SESSION['AR']; ?>   
            window.location.reload();
        }
    </script>
</body>
</html>