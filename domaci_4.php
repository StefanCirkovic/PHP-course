<?php


    // 1. Zadatak:

    $ime = "admInistrAtor";
    $lozinka = "mojaSifraJeSigurna";

    if (strcasecmp($ime, "administrator") == 0 && $lozinka == "mojaSifraJeSigurna") 
    {
        echo "dobrodosao administratore!";
    }
    else
    {
        echo "pogresna lozinka ili ime!";
    }


    // 2. Zadatak:


    $trenutno_vreme = date("H");

    if ($trenutno_vreme >= 5 && $trenutno_vreme < 12)
    {
        echo "jutro je!";
    }
    elseif ($trenutno_vreme >= 12 && $trenutno_vreme < 20)
    {
        echo "podne je!";
    }
    else
    {
        echo "noc je!";
    }
    

?>