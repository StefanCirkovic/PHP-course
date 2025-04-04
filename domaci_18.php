<?php


// html_delovi/navigacija.php:


<?php

    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

?>

<div class="col-12 bg-dark p-2 d-flex justify-content-center align-items-center">
    <div class="m-2">
        <a class="nav-link" href="index.php">Glavna</a>
    </div>

    <?php if(isset($_SESSION['ulogovan'])): ?>
            <a class="nav-link" href="logout.php">Logout</a>
            <a class="nav-link" href="moja_korpa.php">Korpa</a>
        <?php else: ?>
            <a class="nav-link" href="login.php">Login</a>
        <?php endif; ?> 

</div>



// modeli/baza.php



<?php

    $baza = mysqli_connect("localhost", "root", "", "web_shop");




// modeli/loginUser.php



<?php 

    if( !isset($_POST['email']) || empty($_POST['email']) )
    {
        die("Niste uneli email!");
    }

    if( !isset($_POST['sifra']) || empty($_POST['sifra']) )
    {
        die("Niste uneli sifru!");
    }

    require_once "baza.php";

    $email = $_POST['email'];
    $sifra = $_POST['sifra'];



    $rezultat = $baza->query(" SELECT * FROM korisnici WHERE email = '$email' ");

    if($rezultat->num_rows == 1)
    {
        $korisnik = $rezultat->fetch_assoc();


        $verifikovanaSifra = password_verify($sifra, $korisnik['sifra']);
        
        if($verifikovanaSifra == true)
        {
            if(session_status() == PHP_SESSION_NONE)
            {
                session_start();
            }

            $_SESSION['ulogovan'] = true;
            $_SESSION['user_id'] = $korisnik['id'];
            
            header("Location: ../index.php");
        }
        else {
            echo "Sifra nije tacna";
        }


    }
    else 
    {
        echo "Korisnik ne postoji";
    }




// index.php:




<?php
    require_once "modeli/baza.php";


    $rezultat = $baza->query("SELECT * FROM proizvodi");


    $proizvodi = $rezultat->fetch_all(MYSQLI_ASSOC);



?>


<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php require_once "html_delovi/navigacija.php" ?>
        
        <div class="container d-flex flex-wrap">
            <?php foreach($proizvodi as $proizvod): ?>
                <div class="col-md-4 col-12 p-2 mt-2">
                    <h1><?= $proizvod['ime'] ?></h1>
                    <p><?= $proizvod['opis'] ?></p>
                    <p>Cena proizvoda: <?= $proizvod['cena'] ?></p>
                    <p>Na stanju: <?= $proizvod['kolicina'] ?></p>

                    <?php if($proizvod['kolicina'] == 0): ?>
                        <p>Nema na stanju</p>
                    <?php else: ?>
                        <p>Ima na stanju</p>
                    <?php endif; ?>

                    <a class="btn btn-outline-primary" href="proizvod.php?id=<?= $proizvod['id'] ?>">Pogledaj proizvod</a>
                </div>
            <?php endforeach; ?>
        </div>
    </body>

</html>



// korpa.php:



<?php 



    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

 
    if(!isset($_POST['id_proizvoda']) || empty($_POST['id_proizvoda']))
    {
        die("Morate uneti ID proizvoda");
    }

    if(!isset($_POST['kolicina']) || empty($_POST['kolicina']))
    {
        die("Morate uneti kolicinu");
    }


    require_once "modeli/baza.php";

    $idProizvoda = $_POST['id_proizvoda'];
    $kolicina = $_POST['kolicina'];
    $idKorisnika = $_SESSION['user_id'];
    
    $rezultat = $baza->query("SELECT cena FROM proizvodi WHERE id = $idProizvoda");
    
    $redIzBaze = $rezultat->fetch_assoc(); 
    $cena = $redIzBaze['cena'];
    $cena = $cena * $kolicina; 

    
    $baza->query("INSERT INTO narudzbine (id_proizvoda, id_korisnika, kolicina, cena) VALUES ($idProizvoda, $idKorisnika, $kolicina, $cena) ");

    header("Location: moja_korpa.php");



// login.php:





<!-- ukrao sam ti malo html kod haha lepo mi izgledao login, nadam se da je to okej -->  



<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>

    <body>

        <?php require_once "html_delovi/navigacija.php" ?>

        <div class="container d-flex justify-content-center mt-4">
            <form class="col-md-4 col-12" action="modeli/loginUser.php" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email adresa</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1">
                </div>
                <div class="mb-3">
                    <label for="examplePassword" class="form-label">Lozinka</label>
                    <input type="password" name="sifra" class="form-control" id="examplePassword">
                </div>
                <button class="btn btn-primary w-100">Uloguj me</button>
            </form>
        </div>
        
    </body>

</html>



// logout.php:


<?php

    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    session_destroy();

    header("Location: index.php");




// moja_korpa.php:




<?php 

    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    if(!isset($_SESSION['ulogovan']))
    {
        die("Morate biti ulogovani da bi videli ovu stranicu");
    }


    require_once "modeli/baza.php";

    $userId = $_SESSION['user_id'];

    $rezultat = $baza->query("SELECT narudzbine.kolicina, narudzbine.cena, proizvodi.ime 
        FROM narudzbine 
        INNER JOIN proizvodi ON proizvodi.id = narudzbine.id_proizvoda
        WHERE narudzbine.id_korisnika = $userId
    ");


    $narudzbine = $rezultat->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>

<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php require_once "html_delovi/navigacija.php" ?>
        <?php if($rezultat->num_rows == 0): ?>
            <h1>Nemate nijedan proizvod u korpi!</h1>
        <?php else: ?>

            <div class="container mt-2">
                <?php foreach($narudzbine as $narudzba): ?>
                    <div class="col-12 d-flex justify-content-center">
                    <p class="p-2">Proizvod: <?= $narudzba['ime'] ?></p>
                        <p class="p-2">Kolicina: <?= $narudzba['kolicina'] ?></p>
                        <p class="p-2">Cena: <?= $narudzba['cena'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </body>

</html>



// proizvod.php:


<?php 

    if( !isset($_GET['id']) || empty($_GET['id']) )
    {
        die("Fali ID proizvoda!");
    }

    require_once "modeli/baza.php";

    $idProizvoda = $_GET['id'];



    $rezultat = $baza->query(" SELECT * FROM proizvodi WHERE id = $idProizvoda ");
    
    if($rezultat->num_rows == 0)
    {
        die("Ovaj proizvod ne postoji");
    }

    $proizvod = $rezultat->fetch_assoc();



    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php require_once "html_delovi/navigacija.php" ?>
        
        <div class="container d-flex flex-column justify-content-center align-items-center mt-3">
            <h1><?= $proizvod['ime'] ?></h1>
            <p><?= $proizvod['opis'] ?></p>
            <p>Cena proizvoda: <?= $proizvod['cena'] ?></p>

            <?php if($proizvod['kolicina'] == 0): ?>
                <p>Nema na stanju</p>
            <?php else: ?>
                <p>Ima na stanju</p>
            <?php endif; ?>

            <?php if(isset($_SESSION['ulogovan'])): ?>
                <form class="d-flex flex-column justify-content-center" method="POST" action="korpa.php">
                    <div>
                        <input class="form-control" type="number" name="kolicina" placeholder="Unesite kolicinu proizvoda">
                    </div>
                    <input type="hidden" name="id_proizvoda" value="<?= $proizvod['id'] ?>">
                    <button class="btn btn-outline-primary mt-2">Dodaj u korpu</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Kliknite da se ulogujete kako bi dodali u korpu!</a>
            <?php endif; ?>

        </div>
    </body>

</html>