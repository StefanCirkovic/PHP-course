<?php


// Svi fajlovi su u folderu domaci tako mi je bilo lakse ovaj put,
// Sledeci put cu html kod u jedan folder, a php u drugi kao sto si pricao.
// file: baza.php

<?php

    $baza = mysqli_connect("localhost", "root", "", "web_shop");

// file: domaci_15_kreiranje.php

<!DOCTYPE html>
<html lang="en">
<head>
    
</head>
<body>

    <form method="GET" action = "domaci_15_php_kreiranje.php">
        <input type="text" name="ime" placeholder="ime" required>
        <input type="text" name="opis" placeholder="opis" required>
        <input type="number" name="cena" placeholder="cena" require>
        <input type="text" name="slika" placeholder="slika" required>
        <input type="number" name="kolicina" placeholder="kolicina" required>
        <button>Kreirajte proizvod</button>
    </form>
    
</body>
</html>


// file: domaci_15_php_kreiranje.php

<?php


   


    if(!isset($_GET['ime']) || empty($_GET['ime']))
    {
        die("Niste uneli ime!");
    }
    

    
    if(!isset($_GET['opis']) || empty($_GET['opis']))
    {
        die("Niste uneli opis!");
    }


    
    if(!isset($_GET['cena']) || empty($_GET['cena']))
    {
        die("Niste uneli cenu!");
    }

    
    if(!isset($_GET['slika']) || empty($_GET['slika']))
    {
        die("Niste uneli sliku!");
    }

    
    if(!isset($_GET['kolicina']) || empty($_GET['kolicina']))
    {
        die("Niste uneli kolicinu!");
    }



    $ime = $_GET['ime'];
    $opis = $_GET['opis'];
    $cena = $_GET['cena'];
    $slika = $_GET['slika'];
    $kolicina = $_GET['kolicina'];


    require_once "baza.php";



    $rezultat = $baza->query("SELECT * FROM proizvodi WHERE ime = '$ime' ");


    if ($rezultat->num_rows >= 1) 
    {
        echo "Ovaj proizvod vec postoji!";
    }
    else
    {
        $baza->query("INSERT INTO proizvodi (ime, opis, cena, slika, kolicina) VALUES ('$ime', '$opis', '$cena', '$slika', '$kolicina')");
        echo "Uspesno ste dodali proizvod!";
    }
    




    // file: domaci_15_pretraga.php



    <!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
    
    <form method="GET" action="domaci_15_php_pretraga.php"> 
        <input type="text" name="ime_proizvoda" placeholder="Ime proizvoda" required>
        <button>Pretraga</button>
    </form>

</body>
</html>


// file: domaci_15_php_pretraga.php


<?php

    

    if(!isset($_GET['ime_proizvoda']) || empty($_GET['ime_proizvoda']) )
    {
        die("Niste uneli ime_proizvoda!");
    }


    require_once "baza.php";


    $ime = $_GET['ime_proizvoda'];

    

    $rezultat = $baza->query("SELECT * FROM proizvodi WHERE ime LIKE '%$ime%' OR opis LIKE '%$ime%'");

    if ($rezultat->num_rows >= 1)
    {
        echo "Uspesno smo nasli ". $rezultat->num_rows. " proizvoda!";
    }
    else
    {
        echo "Nismo pronasli nista!";
    }




    
