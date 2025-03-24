

<!-- file domaci_6.php -->

<!DOCTYPE html>
<html>
<head>

</head>
<body>

<form method="POST" action="domaci_6_php.php">
        <input type="" name="ime">
        <button>proveri</button>
</form>
    
</body>
</html>


<!-- file domaci_6_php.php -->

<?php


$imena = ["petar", "marko", "toma"];

if (!isset($_POST["ime"]))
{
    die("Ime nije prosledjeno");
}



$ime = trim($_POST["ime"]);

if ($ime == "") {
    die("Morate uneti ime!");
}


if (strlen($ime) < 3)
{
    die("Ime mora imati minimum 3 karaktera");
}


$imena_lower = array_map('strtolower', $imena);

$ime_lower = strtolower($ime);

if (in_array($ime_lower,$imena_lower))
{
    echo "pronasli smo ime!";
}
else 
{
    echo "nismo pronasli ime!";
}

?>