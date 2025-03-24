
<!-- file domaci_5_html.php: -->

<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Document</title>
</head>
<body>

    <form method="GET" action="domaci_5_php.php">
        <input type="text" name="broj"><br>
        <select name="izbor">
            <option>Hrana</option>
            <option>Oprema za racunare</option>
        </select><br>
        <label>
        <input type="checkbox" name="provera_sigurnosti"> Izracunaj porez
        </label><br>
        <button>Izracunaj cenu</button><br>


    </form>
    
</body>
</html>

<!-- file domaci_5_php.php -->
 
<?php



if (isset($_GET["provera_sigurnosti"]))
{
    if ($_GET["izbor"] == "Hrana")
    {
        echo ($_GET["broj"] + 50) * 1.10;
    }
    else if ($_GET["izbor"] == "Oprema za racunare")
    {
        echo ($_GET["broj"] + 350) * 1.10;
    }
    
}
else 
{
    if ($_GET["izbor"] == "Hrana")
    {
        echo $_GET["broj"] + 50;
    }
    else if ($_GET["izbor"] == "Oprema za racunare")
    {
        echo $_GET["broj"] + 350;
    }
}

?>