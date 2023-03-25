<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

        //save to database
        $user_id = random_num(20);
        $query = "insert into users (user_id,user_name,password) values ('$user_id','$user_name','$password')";

        mysqli_query($con, $query);

        header("Location: signup.php");
        die;
    } else {
        echo "Please enter some valid information!";
    }
}
?>

<?php
include './includes/adminHeader.php';
?>

<div class="container col-md-4 bg-info mt-4 p-3 border-shadow rounded">

    <h2 class="form-header">Add User</h2>

    <form method="post" class="border-shadow p-2 rounded">
        <div class="mb-3">
            <label for="user_name" class="form-label">User Name</label>
            <input type="text" class="form-control" name="user_name">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password">
        </div>

        <button type="submit" class="btn btn-outline-light">Add</button>

    </form>
</div>

<div class="container">
    <div class="row">
        <?php get_admin_data(); ?>
    </div>
</div>

<?php
include './includes/adminFooter.php';
include './includes/scripts.php';
?>