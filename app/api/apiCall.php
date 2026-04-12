<?php


    //chiave duffel
    $key="duffel_test_CsswiUl9eG9CK3fhQPSEGIQcvb1a0Y-omMauyUuW0KC"; //la mia key 

    //ANDATA
    function apiAndata($codiciArrivo, $codiciPartenza, $npasseggeri, $dataP, $key){
        foreach($codiciArrivo as $arrivo){
            foreach($codiciPartenza as $partenza){                        
                $passeggeriArray = [];
                        for ($i = 0; $i < $npasseggeri; $i++) {
                                $passeggeriArray[] = ["type" => "adult"]; //indico il tipo di passeggero
                    }
                        //setto i dati da passare secondo il modello impostato di duffel
                    $payload = json_encode([
                            "data" => [
                                "slices" => [
                                    [   "origin" => $partenza,
                                        "destination" => $arrivo,
                                        "departure_date" => $dataP   ]
                                ],
                                "passengers" => $passeggeriArray,
                                "return_offers" => true //restituisce subito i voli trovati
                            ]
                    ]);
                        //impostazione chiamata api
                    $opzioniDuffel = [
                            'http' => [
                                'method' => 'POST',
                                'header' => "Authorization: Bearer " . $key . "\r\n" .
                                            "Duffel-Version: v2\r\n" .
                                            "Content-Type: application/json\r\n" .
                                            "Accept: application/json\r\n",
                                'content' => $payload,
                                'ignore_errors' => true
                            ]
                    ];
                    //chiamo url API di duffel
                    $urlRicerca = "https://api.duffel.com/air/offer_requests";
                    $rispostaVoli = @file_get_contents($urlRicerca, false, stream_context_create($opzioniDuffel)); //richiesta effettiva

                    //decodifico i risultati e prendo solo i primi 10 per evitare di sovraccaricare la pagina
                    $datiDecodificati = json_decode($rispostaVoli, true);

                    //salvo negli arry
                    if(isset($datiDecodificati['data']['offers'])){
                            $risultatiVoli = $datiDecodificati['data']['offers'];
                            $risultati = array_slice($risultatiVoli, 0, 10); //metto max 10 siccome evito overload
                            return $risultati;
                    }
                }
        }
    }


    //ANDATA e RITORNO
    function apiAR($codiciArrivo, $codiciPartenza, $npasseggeri, $dataP, $dataR, $key){
        foreach($codiciArrivo as $arrivo){
            foreach($codiciPartenza as $partenza){                        
                $passeggeriArray = [];
                    for ($i = 0; $i < $npasseggeri; $i++) {
                            $passeggeriArray[] = ["type" => "adult"]; //indico il tipo di passeggero
                    }
                    $payload = json_encode([
                            "data" => [
                                "slices" => [
                                    //ANDATA
                                    [   
                                        "origin" => $partenza,      
                                        "destination" => $arrivo,    
                                        "departure_date" => $dataP
                                    ],
                                    //Ritorno
                                    [   
                                        "origin" => $arrivo,        
                                        "destination" => $partenza,
                                        "departure_date" => $dataR 
                                    ]
                                ],
                                "passengers" => $passeggeriArray,
                                "return_offers" => true
                            ]
                    ]);
                    $opzioniDuffel = [
                            'http' => [
                                'method' => 'POST',
                                'header' => "Authorization: Bearer " . $key . "\r\n" .
                                            "Duffel-Version: v2\r\n" .
                                            "Content-Type: application/json\r\n" .
                                            "Accept: application/json\r\n",
                                'content' => $payload,
                                'ignore_errors' => true
                            ]
                    ];

                    //chiamo url API di Duffel
                    $urlRicerca = "https://api.duffel.com/air/offer_requests";
                    $rispostaVoli = @file_get_contents($urlRicerca, false, stream_context_create($opzioniDuffel)); //richiesta effettiva

                    //decodifico i risultati e prendo solo i primi 10 per evitare di sovraccaricare la pagina
                    $datiDecodificati = json_decode($rispostaVoli, true);

                    //salvo negli arry
                    if(isset($datiDecodificati['data']['offers'])){
                            $risultatiVoli = $datiDecodificati['data']['offers'];
                            $risultati = array_slice($risultatiVoli, 0, 10);
                            return $risultati;
                    }
                }
        }
    }
?>
