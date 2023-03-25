<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$row = update_get_admin();
?>

<?php
include './includes/adminHeader.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 pt-5">
            <h2>Update Data</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['id']; ?>" method="post">
                <div class="form-group">
                    <label for="update_username">User Name</label>
                    <input type="text" name="update_username" class="form-control" id="update_username" placeholder="Username" value="<?php echo $row['user_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="update_password">Password</label>
                    <input type="text" name="update_password" class="form-control" id="update_password" placeholder="Password" value="<?php echo $row['password']; ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>





<?php
include './includes/adminFooter.php';
include './includes/scripts.php';
?>