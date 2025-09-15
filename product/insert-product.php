<?php
require_once '../includes/user-class.php';

class Product {
    private $dbh;

    public function __construct() {
        $this->dbh = new DB();
    }

public function insertProduct($omschrijving, $foto, $prijs) {
    $sql = "INSERT INTO product (omschrijving, foto, prijsPerStuk) 
            VALUES (:omschrijving, :foto, :prijs)";
    return $this->dbh->run($sql, [":omschrijving" => $omschrijving,":foto" => $foto,":prijs" => $prijs]);
}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $omschrijving = $_POST['omschrijving'];
    $prijs = $_POST['prijs'];

    $filename = $_FILES['file']['name'];
    $location = "upload/" . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        $product = new Product();
        if ($product->insertProduct($omschrijving, $location, $prijs)) {
            echo "Product succesvol toegevoegd.";
        } else {
            echo "Fout bij toevoegen product.";
        }
    } else {
        echo "Fout bij uploaden van de foto.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="omschrijving" placeholder="Omschrijving" required>
        <input type="number" step="0.01" name="prijs" placeholder="Prijs per stuk" required>
        <input type="file" name="file" required />
        <input type="submit" name="knop" value="Toevoegen">
    </form>
</body>
</html>
