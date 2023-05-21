<?php
if (isset($_POST['submit'])) {

    $newFileName = $_POST['filename'];
    if (empty($_POST['filename'])) {
        $newFileName = 'gallery';
    } else {
        $newFileName = strtolower(str_replace(" ", "_", $newFileName));#upravý názov na malé znaky a medzery na _
    }
    $imageTitle = $_POST['filetitle'];
    $imageDesc = $_POST['filedesc'];

    $file = $_FILES['file']; // info o subore

    $fileName = $file["name"]; // orig. nazov
    $fileType = $file["type"]; // jpg...
    $fileTempName = $file["tmp_name"];
    $fileError = $file["error"];
    $fileSize = $file["size"];

    $fileExt = explode(".", $fileName);#odstráni z názvu tú časť pred bodkou. a vytvorý pole rozdelene podla bodky
    $fileActualExt = strtolower(end($fileExt)); //Ak bude cast za bodkou CAP tak ju zmení na malé písmená end(ziska poslednu cast z pola)


    $allowed = array("jpg", "jpeg", "png");

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 2000000) {
                #vytvorý unikátny názov súboru aby sa v db nemohol prepísať (filename.id.extention);
                $imageFullName = $newFileName . "." . uniqid("", true) .".". $fileActualExt; // true = viac znakov
                $fileDestination = "../images/gallery/" . $imageFullName;

                require "dbhgallery.inc.php";
                if (empty($conn2)) {
                    $conn2 = new stdClass(); // zakladny objektovy typ

                }
                if (empty($imageTitle) || empty($imageDesc)) {
                    header("Location ../gallery.php?upload=empty");
                    echo "Všetky polia formulára musia byť vyplnené!";
                    exit();
                } else {
                    $sql = "SELECT * FROM gallery;";
                    $stmt = mysqli_stmt_init($conn2);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement failed";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt);
                        $rowCount = mysqli_num_rows($result);
                        $setImageOrder = $rowCount + 1;

                       $sql = "INSERT INTO gallery (titleGallery, descGallery, imgFullNameGallery, orderGallery) VALUES (?, ?, ? ,?);";
                       if (!mysqli_stmt_prepare($stmt, $sql)){
                           echo "SQL statement failed!";
                       } else {
                           mysqli_stmt_bind_param($stmt, "ssss", $imageTitle,$imageDesc, $imageFullName,$setImageOrder);
                           mysqli_stmt_execute($stmt);

                           move_uploaded_file($fileTempName, $fileDestination);
                           header("Location: ../events.php?upload=success");

                       }


                    }

                }

            } else {
                echo "Príliš veľký súbor";
                exit();
            }
        } else {
            echo "Nastala chyba";
            exit();
        }
    } else {
        echo "Nesprávny typ súboru";
        exit();
    }
}