<?php
session_start();

include("./admin/connection.php");
include("./admin/functions.php");

$user_data = check_login($con);

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;

                $fileDestination = 'uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                header("Location: index.php?uploadsuccess");

                $sql = "insert into 'posts' (title,category,content,image) values ('$title','$category','$content','$fileDestination')";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    echo "Data inserted successfully";
                } else {
                    die(mysqli_error($con));
                }
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}


?>

<?php
include './include/header.php';
?>


<div class="container">
    <div class="row">
        <?php get_all_data2(); ?>
    </div>
</div>


<?php
include './include/footer.php';
?>