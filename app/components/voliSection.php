<?php
    //forms dei voli A/R e solo A
    

    $andataRitorno='<form action="pages/voliAR.php" method="POST" class="w-full max-w-7xl mx-auto relative mt-20">
                        <div class="bg-searchBg rounded-r-3xl rounded-bl-3xl p-6 md:p-8 shadow-2xl relative">
                            <div class="bg-searchBg absolute -top-16 left-0 rounded-t-3xl p-3 flex space-x-2">

                                <button onclick="cambiaForm()" type="button" class="bg-brandPrimary text-white flex items-center space-x-2 px-6 py-3 rounded-xl font-medium shadow-md">
                                    <i class="fa-solid fa-right-left"></i>
                                    <span>Andata e ritorno</span>
                                </button>
                                <button onclick="cambiaForm()" type="button" class="text-gray-600 hover:bg-gray-200 flex items-center space-x-2 px-6 py-3 rounded-xl font-medium transition">
                                    <i class="fa-solid fa-arrow-right"></i>
                                    <span>Solo andata</span>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 md:gap-4 mt-4 md:mt-0 items-end divide-y md:divide-y-0 md:divide-x divide-gray-300">
                                
                            <!--Aeroporti partenza-->
                                <div class="flex flex-col space-y-2 pr-0 md:pr-4">
                                    <label for="partenza" class="text-gray-800 font-bold text-sm">Da</label>
                                    <div class="relative w-full">
                                        <i class="fa-solid fa-plane-departure absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        
                                        <input type="text" name="IATAP" required placeholder="IATA o aeroporto" class="w-full bg-inputBg text-gray-700 text-sm pl-10 pr-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-brandPrimary transition placeholder-gray-400">
                                    
                                    </div>
                                </div>
                            <!--Aeroporti arrivo-->
                                <div class="flex flex-col space-y-2 px-0 md:px-4 pt-4 md:pt-0">
                                    <label for="arrivo" class="text-gray-800 font-bold text-sm">A</label>
                                    <div class="relative w-full">
                                        <i class="fa-solid fa-plane-arrival absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        
                                        <input type="text" name="IATAA" required placeholder="IATA o aeroporto" class="w-full bg-inputBg text-gray-700 text-sm pl-10 pr-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-brandPrimary transition placeholder-gray-400">
                                    
                                    </div>
                                </div>
                                <div class="flex flex-col space-y-2 px-0 md:px-4 pt-4 md:pt-0">
                                    <label for="data_partenza" class="text-gray-800 font-bold text-sm">Andata</label>
                                    <input type="date" name="dataP" required class="w-full bg-inputBg text-gray-700 text-sm px-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-brandPrimary transition cursor-pointer">
                                </div>

                                <div class="flex flex-col space-y-2 px-0 md:px-4 pt-4 md:pt-0">
                                    <label for="data_ritorno" class="text-gray-800 font-bold text-sm">Ritorno</label>
                                    <input type="date" name="dataR" required class="w-full bg-inputBg text-gray-700 text-sm px-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-brandPrimary transition cursor-pointer">
                                </div>

                                <div class="flex flex-col space-y-2 pl-0 md:pl-4 pt-4 md:pt-0">
                                    <label for="passeggeri" class="text-gray-800 font-bold text-sm">Passeggeri</label>
                                    <div class="flex space-x-2">
                                        <input type="number" name="passeggeri" min="1" max="9" value="1" required class="w-20 bg-inputBg text-gray-700 text-sm px-3 py-3 rounded-lg outline-none focus:ring-2 focus:ring-brandPrimary transition text-center">
                                        
                                        <input type="submit" value="Cerca" class="bg-brandPrimary hover:bg-opacity-90 text-white px-4 py-3 rounded-lg font-medium transition shadow-md flex-1 flex items-center justify-center space-x-2">
                                        </input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>';


    $soloAndata='<form action="pages/voliA.php" method="POST" class="w-full max-w-7xl mx-auto relative mt-20">
    
                    <div class="bg-searchBg rounded-r-3xl rounded-bl-3xl p-6 md:p-8 shadow-2xl relative">
                        
                        <div class="bg-searchBg absolute -top-16 left-0 rounded-t-3xl p-3 flex space-x-2">
                            
                        <button onclick="cambiaForm()" type="button" class="text-gray-600 hover:bg-gray-200 flex items-center space-x-2 px-6 py-3 rounded-xl font-medium transition">
                                <i class="fa-solid fa-right-left"></i>
                                <span>Andata e ritorno</span>
                            </button>
                            <button onclick="cambiaForm()" type="button" class="bg-brandPrimary text-white flex items-center space-x-2 px-6 py-3 rounded-xl font-medium shadow-md">
                                <i class="fa-solid fa-arrow-right"></i>
                                <span>Solo andata</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 md:gap-4 mt-4 md:mt-0 items-end divide-y md:divide-y-0 md:divide-x divide-gray-300">
                            
                            <div class="flex flex-col space-y-2 pr-0 md:pr-4">
                                <label for="partenza" class="text-gray-800 font-bold text-sm">Da</label>
                                <div class="relative w-full">
                                    <i class="fa-solid fa-plane-departure absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    
                                    <input type="text" name="IATAP" required placeholder="IATA o aeroporto" class="w-full bg-inputBg text-gray-700 text-sm pl-10 pr-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-brandPrimary transition placeholder-gray-400">
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-2 px-0 md:px-4 pt-4 md:pt-0">
                                <label for="arrivo" class="text-gray-800 font-bold text-sm">A</label>
                                <div class="relative w-full">
                                    <i class="fa-solid fa-plane-arrival absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    
                                    <input type="text" name="IATAA" required placeholder="IATA o aeroporto" class="w-full bg-inputBg text-gray-700 text-sm pl-10 pr-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-brandPrimary transition placeholder-gray-400">
                                </div>
                            </div>

                            <div class="flex flex-col space-y-2 px-0 md:px-4 pt-4 md:pt-0">
                                <label for="data_partenza" class="text-gray-800 font-bold text-sm">Andata</label>
                                
                                <input type="date" name="dataP" required class="w-full bg-inputBg text-gray-700 text-sm px-4 py-3 rounded-lg outline-none focus:ring-2 focus:ring-brandPrimary transition cursor-pointer">
                            </div>

                            <div class="flex flex-col space-y-2 px-0 md:px-4 pt-4 md:pt-0">
                                <label for="data_ritorno" class="text-gray-400 font-bold text-sm">Ritorno</label>
                                
                                <input type="date" name="dataA" disabled class="w-full bg-gray-200 text-gray-400 text-sm px-4 py-3 rounded-lg outline-none cursor-not-allowed opacity-70">
                            </div>

                            <div class="flex flex-col space-y-2 pl-0 md:pl-4 pt-4 md:pt-0">
                                <label for="passeggeri" class="text-gray-800 font-bold text-sm">Passeggeri</label>
                                <div class="flex space-x-2">
                                    <input type="number" id="passeggeri" name="passeggeri" min="1" max="9" value="1" required class="w-20 bg-inputBg text-gray-700 text-sm px-3 py-3 rounded-lg outline-none focus:ring-2 focus:ring-brandPrimary transition text-center">
                                    
                                    <button type="submit" class="bg-brandPrimary hover:bg-opacity-90 text-white px-4 py-3 rounded-lg font-medium transition shadow-md flex-1 flex items-center justify-center space-x-2">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <span class="hidden lg:inline">Cerca</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>';

?>