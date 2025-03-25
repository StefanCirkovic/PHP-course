<?php


    $dostava = [

        "Subotica" => 220,
        "Pancevo" => 10,
        "Sarajevo" => 292,
        "Split" => 799
    ];


    function izracunajDostavu($cena, $lokacija, $dostava) {

        if (isset($dostava[$lokacija])) {
            $rastojanje = $dostava[$lokacija];


            if ($rastojanje < 100) {
                $cenaDostave = 200;
            }
            else if ($rastojanje >= 100 && $rastojanje <= 200) {
                $cenaDostave = 350;
            }
            else if($rastojanje > 200 ) {
                $cenaDostave = 500;
            }
            $cenaSaDostavom = $cenaDostave + $cena;


            return "Rastojanje $lokacija - Beograd je $rastojanje km, a dostava iznosi $cenaSaDostavom u dinarima";

        }
        else {

            return "Ne dostavljamo na lokaciju $lokacija.";
            $cenaDostave = null;
        }

    }


    $rezultat = izracunajDostavu(1000, "Barja", $dostava);
    echo $rezultat;

    $rezultatDva = izracunajDostavu(1000, "Subotica", $dostava);
    echo $rezultatDva;

    $rezultatTri = izracunajDostavu(1000, "Pancevo", $dostava);
    echo $rezultatTri;

    $rezultatCetiri = izracunajDostavu(1000, "Sarajevo", $dostava);
    echo $rezultatCetiri;

    $rezultatPet = izracunajDostavu(1000, "Split", $dostava);
    echo $rezultatPet;