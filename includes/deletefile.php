<button onclick="location.href='events.php'">Domov</button>
<?php
echo
'<div>
        <form class="form-control text-dark" action="includes/gallery-upload.inc.php" method="post" enctype="multipart/form-data">
            <input type="text" name="filename" placeholder="Názov súboru:"  >
            <input type="text" name="filetitle" placeholder="Názov obrázku:" >
            <input type="text" name="filedesc" placeholder="Popis:" >
            <input type="file" name="file">
            <button type="submit" name="submit">UPLOAD</button>
        </form>
    </div>';
?>
<?php
include_once 'includes/dbhgallery.inc.php';

if(empty($conn2)){
    $conn2 = new stdClass();
}

$sql = "SELECT * FROM gallery ORDER BY idGallery DESC;";
$vys = mysqli_query($conn2, $sql);
while ($row = mysqli_fetch_assoc($vys)) { // kluc je stlpec a hodnota je hodnota v riadku
    echo '<div>
            <img src="images/gallery/' . $row['imgFullNameGallery'] . '" alt="' . $row['titleGallery'] . '">
            <form method="post">
                <input type="text" name="imgId" value="' . $row['idGallery'] . '">
                <label for="title">Názov obrázku:</label>
                <input type="text" name="title" value="' . $row['titleGallery'] . '">
                <label for="desc">Popis:</label>
                <input type="text" name="desc" value="' . $row['descGallery'] . '">
                <input type="text" name="imgFullNameGallery" value="' . $row['imgFullNameGallery'] . '">
                <button type="submit" name="update">Aktualizovať</button>
                <button type="submit" name="delete">Vymazať</button>
            </form>
          </div>';
    if (isset($_POST['delete'])) {
        $imgId = $_POST['imgId'];

        // Vymazanie obrázka z databázy
        $sql = "DELETE FROM gallery WHERE idGallery = ?;";
        $stmt = mysqli_stmt_init($conn2);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL dozaz zlyhal";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $imgId);
            mysqli_stmt_execute($stmt);
        }

        // Vymazanie obrázka zo zložky na serveri
        $file = "images/gallery/" . $_POST['imgFullNameGallery']; // cesta
        if (!unlink($file)) {
            echo "Chyba pri vymazávaní súboru";
        }

        header("Location: event.php?delete=success");
        exit();
    }

    if (isset($_POST['update']) && $_POST['imgId'] == $row['idGallery']) {
        $title = $_POST['title'];
        $desc = $_POST['desc'];

        // Aktualizácia názvu a popisu
        $sql = "UPDATE gallery SET titleGallery=?, descGallery=? WHERE idGallery=?;";
        $stmt = mysqli_stmt_init($conn2);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL dotaz zlyhal";
        } else {
            mysqli_stmt_bind_param($stmt, "sss", $title, $desc, $row['idGallery']);
            mysqli_stmt_execute($stmt);
            echo "Aktualizácia úspešná";
        }
    }
}
?>
