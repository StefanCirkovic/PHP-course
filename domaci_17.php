<?php


    $baza = mysqli_connect("localhost", "root", "", "web_shop");

    
// file: index.php


<?php

    require_once "modeli/baza.php";

    $rezultat = $baza->query("SELECT * FROM proizvodi");

    $proizvodi = $rezultat->fetch_all(MYSQLI_ASSOC);
    

    if (session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }


?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <a href="index.php">Glavna</a>

        <?php if(isset($_SESSION['ulogovan'])):   ?>

            <a href="logout.php">logout</a>

        <?php else:   ?>

            <a href="login.php">login</a>

        <?php  endif; ?>
        
    </div>

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

                <a href="proizvod.php?id=<?=$proizvod['id'] ?>">Pogledaj proizvod</a>
            </div>
    <?php endforeach;  ?>
    
</body>
</html>



// file: login.php



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="POST" action="modeli/loginUser.php">
        <input type="email" name="email" placeholder="Unesite email">
        <input type="password" name="sifra" placeholder="Unesite sifru">
        <button>Registruj me</button>
    </form>
    
</body>
</html>



// file: modeli/loginUser.php



<?php

    if (!isset($_POST['email']) || empty($_POST['email']))
    {
        die("Niste uneli email!");
    }

    if (!isset($_POST['sifra']) || empty($_POST['sifra']))
    {
        die("Niste uneli sifru!");
    }


    require_once "baza.php";


    $email = $_POST['email'];
    $sifra = $_POST['sifra'];

    $rezultat = $baza->query("SELECT * FROM korisnici WHERE email = '$email'");

    if ($rezultat->num_rows == 1)
    {
        $korisnik = $rezultat->fetch_assoc();

        if (password_verify($sifra, $korisnik['sifra']))
        {

            if (session_status() == PHP_SESSION_NONE)
            {
                session_start();
            }
            
            $_SESSION['ulogovan'] = true;
            $_SESSION['user_id'] = $korisnik['id'];

            header("Location: ../index.php");
        }
        else
        {
            echo "lozinke se ne poklapaju!";
        }
    }
    else
    {
        echo "korisnik ne postoji!";
    }





