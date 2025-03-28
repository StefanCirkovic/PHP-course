
<?php

// file baza.php:


<?php


    $baza = mysqli_connect("localhost", "root", "", "web_shop");

    

// file: domaci_login.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
</head>
<body>
    <form method="POST" action = "domaci_loginUser.php">
        <input type = "email" name = "email" placeholder = "Unesite email" required>
        <input type = "password" name = "sifra" placeholder = "Unesite sifru" required>
        <button>Registruj me!</button>

    </form>
</body>
</html>


// file: domaci_loginUser.php


<?php


    if (!isset($_POST['email']) || empty($_POST['email']))
    {
        die("Niste uneli email!");
    }

    if (!isset($_POST['sifra']) || empty($_POST['sifra']))
    {
        die("Niste uneli sifru!");
    }


    $email = $_POST['email'];
    $sifra = $_POST['sifra'];

    require_once "baza.php";

    $q = $baza->query("SELECT * FROM korisnici WHERE email = '$email'");

    if ($q->num_rows == 1)
    {
        echo "korisnik vec postoji!";
    }
    else
    {
        $rezultat = $baza->query("INSERT INTO korisnici (email, sifra) VALUES ('$email', '$sifra')");
        echo "Uspesno ste se registrovali!";


        header("Location: domaci_dashboard.php");
        exit();
    }


// file: domaci_dashboard.php



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <p>Sta zelite da uradite:</p>
    <ul>
        <li><a href="domaci_addProduct.php">Dodaj proizvod</a></li>
        <li><a href="domaci_listProducts.php">Izlistaj proizvode</a></li>
        <li><a href="domaci_searchProduct.php">Pretrazi proizvod</a></li>
    </ul>
    
</body>
</html>



// file: domaci_addProduct.php


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="GET" action = "domaci_addProductLogic.php">
        <input type="text" name="ime" placeholder="ime" required>
        <input type="text" name="opis" placeholder="opis" required>
        <input type="number" name="cena" placeholder="cena" require>
        <input type="text" name="slika" placeholder="slika" required>
        <input type="number" name="kolicina" placeholder="kolicina" required>
        <button>Kreirajte proizvod</button>
    </form>
    
</body>
</html>



// file: domaci_addProductLogic.php


<?php

    if (!isset($_GET['ime']) || empty($_GET['ime']))
    {
        die("Niste uneli ime!");
    }

    if (!isset($_GET['opis']) || empty($_GET['opis']))
    {
        die("Niste uneli opis!");
    }

    if (!isset($_GET['cena']) || empty($_GET['cena']))
    {
        die("Niste uneli cenu!");
    }

    if (!isset($_GET['slika']) || empty($_GET['slika']))
    {
        die("Niste uneli sliku!");
    }

    if (!isset($_GET['kolicina']) || empty($_GET['kolicina']))
    {
        die("Niste uneli kolicinu!");
    }
    
    require_once "baza.php";

    $ime = $_GET['ime'];
    $opis = $_GET['opis'];
    $cena = $_GET['cena'];
    $slika = $_GET['slika'];
    $kolicina = $_GET['kolicina'];

    $q = $baza->query("SELECT * FROM proizvodi WHERE ime = '$ime'");

    if ($q->num_rows == 1)
    {
        echo "ovaj proizvod vec postoji!";
    }
    else
    {
        $rezultat = $baza->query("INSERT INTO proizvodi (ime, opis, cena, slika, kolicina) VALUES ('$ime', '$opis', '$cena', '$slika', '$kolicina')");
        echo "Uspesno ste dodali $ime";
    }



// file: domaci_listProducts.php


<?php


    require_once "baza.php";

    $rezultat = $baza->query("SELECT * FROM proizvodi");

    $proizvodi = $rezultat->fetch_all(MYSQLI_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izlistavanje proizvoda</title>
</head>
<body>
    <form method="GET" action = "domaci_listProductsLogic.php">
            <h1>Izlistani proizvodi: </h1>
            <?php foreach($proizvodi as $proizvod):   ?>
                <div>
                    <h1><?= $proizvod['ime'] ?></h1>
                    <p><?= $proizvod['opis'] ?></p>
                    <p>Cena proizvoda:<?= $proizvod['cena'] ?></p>
                    <p>Na stanju:<?= $proizvod['kolicina'] ?></p>
                    <?php if ($proizvod['kolicina'] == 0): ?>
                        <p>Nema na stanju!</p>
                    <?php else:   ?>
                        <p>Ima na stanju</p>
                    <?php  endif;  ?>

                    <a href="domaci_productPage.php?id=<?=$proizvod['id'] ?>">Pogledaj proizvod</a>
                </div>
            <?php endforeach;  ?>
    </form>
    
</body>
</html>



// file: domaci_productPage.php



<?php
    require_once "baza.php";

    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Proizvod nije pronađen!");
    }

    
    $id = $_GET['id'];

    
    $rezultat = $baza->query("SELECT * FROM proizvodi WHERE id = $id");

    if ($rezultat->num_rows > 0) {
        $proizvod = $rezultat->fetch_assoc();
    } else {
        die("Proizvod nije pronađen!");
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>

    <h1><?php echo $proizvod['ime']; ?></h1>
    <p><?php echo $proizvod['opis']; ?></p>
    <p>Cena: <?php echo $proizvod['cena']; ?> din</p>
    <p>Količina na stanju: <?php echo $proizvod['kolicina']; ?></p>
    
    <?php if ($proizvod['kolicina'] == 0): ?>
        <p>Nema na stanju!</p>
    <?php else: ?>
        <p>Na stanju</p>
    <?php endif; ?>

</body>
</html>





// file: domaci_searchProduct.php


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="GET" action = "domaci_searchProductLogic.php">
        <input type = "text" name = "ime" placeholder = "Unesite ime proizvoda">
        <button>Pretraga</button>
    </form>

    
</body>
</html>





// file: domaci_searchProductLogic.php


<?php


    if (!isset($_GET['ime']) || empty($_GET['ime']))
    {
        die("Niste uneli ime proizvoda!");
    }


    require_once "baza.php";

    $ime = $_GET['ime'];

    $rezultat = $baza->query("SELECT * FROM proizvodi WHERE ime LIKE '%$ime%' OR opis LIKE '%$ime%'");



     if ($rezultat->num_rows >= 1) {
         echo "Rezultati pretrage: ". $rezultat->num_rows. " proizvoda pronadjena!";
     } else {
         echo "Nema proizvoda koji odgovaraju pretrazi!";
     }










