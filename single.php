<?php
session_start();

include("./admin/connection.php");
include("./admin/functions.php");
$row = update_get();
$user_data = check_login($con);
?>

<?php
include './include/header.php';
?>



<div class="container">
    <div class="row">
        <div class="col-12 pt-5">
            <img class="card-img-top" src="https://via.placeholder.com/300x100" alt="Card image cap">
            <h2 class="pt-5"><?php echo $row['title'] ?></h2>
            <p><?php echo htmlspecialchars_decode($row['content']) ?></p>
        </div>
    </div>
</div>


<?php
include './include/footer.php';
?>