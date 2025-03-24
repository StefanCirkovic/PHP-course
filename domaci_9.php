<?php



    function izracunajPDV($broj) {


        if (!is_numeric($broj)) {
            die("broj mora biti numericka vrednost!");
        }



        if ($broj < 1) {
            die("broj ne moze biti manji od 1!");
        }
        else {
            
            echo " PDV iznosi: ".($broj * 0.22). " eur";

        }


    }

    izracunajPDV(100);