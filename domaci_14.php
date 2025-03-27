

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <form method="POST" action="registracija.php">
        <input type="email" name="email" placeholder="email" required>
        <input type="password" name="sifra" placeholder="sifra" required>
        <button>Registruj me</button>
    </form>
    
</body>
</html>


<?php // file registracija.php: 


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

$baza->query(" INSERT INTO korisnici (email, sifra) VALUES ('$email', '$sifra') ");


?>
