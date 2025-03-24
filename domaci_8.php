<?php

    $navigation = [
        "Glavna" => "https://www.php.net/",
        "O nama" => "https://www.php.net/my.php",
        "Kontakt" => "https://www.php.net/contact.php"
    ];

?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <nav> <?php foreach($navigation as $text => $link): ?>
        <a href="<?= $link ?>"> <?= $text ?></a>
        <?php endforeach; ?>
    </nav>
    
</body>
</html>