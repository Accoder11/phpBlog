<?php

// require_once 'db_connection.php';

function check_login($con)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "select * from users where user_id = '$id' limit 1";

        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    //redirect to login
    header("Location: login.php");
    die;
}


function random_num($length)
{
    $text = "";
    if ($length < 5) {
        $length = 5;
    }
    $len = rand(4, $length);
    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}

// Users/Admin Database and Table

function get_admin_data()
{
    global $con;
    $get_admin = mysqli_query($con, "SELECT * FROM users");

    if (mysqli_num_rows($get_admin) > 0) {
        echo '
        <div class="col-8 pt-5"><h1>Admin/Users Data</h1></div>
        <table class="table">
        <tr>
        <th scope="col">id</th>
        <th scope="col">User Id</th>
        <th scope="col">User Name</th>
        <th scope="col">Password</th>
        </tr>';

        while ($row = mysqli_fetch_assoc($get_admin)) {
            echo '
        <tr>
        <td scope="row">' . $row['id'] . '</td>
        <td>' . $row['user_id'] . '</td>
        <td>' . $row['user_name'] . '</td>
        <td>' . $row['password'] . '</td>
        <td>
        <a href="updateUser.php?id=' . $row['id'] . '">Edit</a>
        |
      <a href="deleteUser.php?id=' . $row['id'] . '">Delete</a>
        </td>
        </tr>
    ';
        }
        echo '
        </table>';
    } else {
        echo "<h3>Database is not working</h3>";
    }
}


//updateUser.php and Edit User

if (isset($_POST['update_username']) && isset($_POST['update_password'])) {

    //check if items are empty

    if (!empty($_POST['update_username']) &&  !empty($_POST['update_password'])) {

        // Escape special characters.

        $username = mysqli_real_escape_string($con, htmlspecialchars($_POST['update_username']));
        $password = mysqli_real_escape_string($con, htmlspecialchars($_POST['update_password']));

        $id = $_GET['id'];

        $update_query = mysqli_query($con, "UPDATE users SET user_name='$username',password='$password' WHERE id=$id");

        if ($update_query) {
            echo "<script>alert('User/Admin Updated');window.location.href = 'signup.php';</script>";
            exit;
        } else {
            echo "<h3>Sorry, that didn't work</h3>";
        }
    } else {
        echo "<h4>Please fill all fields</h4>";
    }
}

// Delete User

//Delete.php

function delete_user()
{
    global $con;
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {

        $userid = $_GET['id'];
        $delete_user = mysqli_query($con, "DELETE FROM users WHERE id='$userid'");

        if ($delete_user) {
            echo "<script>alert('Data Deleted');window.location.href = 'signup.php';</script>";
            exit;
        } else {
            echo "I think something went wrong";
        }
    }
}

// All Posts Database and Table

function get_post_data()
{
    global $con;
    $get_posts = mysqli_query($con, "SELECT * FROM posts");

    if (mysqli_num_rows($get_posts) > 0) {
        echo '
        <div class="col-8 pt-5"><h1>All Posts</h1></div>
        <table class="table">
        <tr>
        <th scope="col">id</th>
        <th scope="col">Title</th>
        <th scope="col">Category</th>
        <th scope="col">Content</th>
        <th scope="col">Image</th>
        <th scope="col">Published Date</th>
        </tr>';

        while ($row = mysqli_fetch_assoc($get_posts)) {
            echo '
        <tr>
        <td scope="row">' . $row['id'] . '</td>
        <td>' . $row['title'] . '</td>
        <td>' . $row['category'] . '</td>
        <td>' . $row['content'] . '</td>
        <td>' . $row['image'] . '</td>
        <td>' . $row['created_at'] . '</td>
        <td>
        <a href="update.php?id=' . $row['id'] . '">Edit</a>
        |
      <a href="delete.php?id=' . $row['id'] . '">Delete</a>
        </td>
        </tr>
    ';
        }
        echo '
        </table>';
    } else {
        echo "<h3>Database is not working</h3>";
    }
}

// Reserve for now

function get_all_data()
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM posts");

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="col-12 pt-5"><h1>All Posts</h1></div>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="col-md-4">
            <div class="card mb-4 box-shadow">
            <img class="card-img-top" src="https://via.placeholder.com/150x100" alt="Card image cap">
            <div class="card-body">
            <h4><a class="text-secondary" href="single.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h4>
            <strong class="card-text text-info">' . $row['category'] . '</strong>

            <p class="card-text">' . htmlspecialchars_decode(substr($row['content'], 0, 100)) . '...</p>
            <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
            <a href="single.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">View</a>
            <a href="update.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Edit</a>
            </div>
            <small class="text-muted"><a class="text-secondary" href="single.php?id=' . $row['id'] . '">' . $row['created_at'] . '</a></small>
            </div>
            </div>
            </div>
            </div>
            ';
        }
    } else {
        echo "<h3>Database is not working</h3>";
    }
}

// Latest Posts

function get_all_data2()
{
    global $con;
    $result = mysqli_query($con, "SELECT * FROM posts");

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="col-12 pt-5"><h1>Latest Posts</h1></div>';

        while ($row = mysqli_fetch_assoc($result)) {
            $file = $row['image'];
            echo '
            <div class="col-md-4">
            <div class="card mb-4 box-shadow">
            <img class="card-img-top" src=' . $file . ' alt="Card image cap">
            <div class="card-body">
            <h4><a class="text-secondary" href="single.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h4>
            <strong class="card-text text-info">' . $row['category'] . '</strong>

            <p class="card-text">' . htmlspecialchars_decode(substr($row['content'], 0, 100)) . '...</p>
            <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
            <a href="single.php?id=' . $row['id'] . '" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">View</a>
            </div>
            <small class="text-muted"><a class="text-secondary" href="single.php?id=' . $row['id'] . '">' . $row['created_at'] . '</a></small>
            </div>
            </div>
            </div>
            </div>
            ';
        }
    } else {
        echo "<h3>Database is not working</h3>";
    }
}

// Insert or Add Post

if (isset($_POST['title']) && isset($_POST['category']) && isset($_POST['content']) && isset($_POST['file'])) {

    //check if the field is empty
    if (!empty($_POST['title']) && !empty($_POST['category']) && !empty($_POST['content']) && !empty($_POST['file'])) {

        //escape special characters
        $title = mysqli_real_escape_string($con, htmlspecialchars($_POST['title']));
        $category = mysqli_real_escape_string($con, htmlspecialchars($_POST['category']));
        $content = mysqli_real_escape_string($con, htmlspecialchars($_POST['content']));
        $file = mysqli_real_escape_string($con, htmlspecialchars($_POST['file']));

        //check duplicate title

        $check_content = mysqli_query($con, "SELECT 'title' FROM posts WHERE content = '$title'");

        if (mysqli_num_rows($check_content) > 0) {
            echo "<h3>This title already exists</h3>";
        } else {

            // insert data into database

            $insert_query = mysqli_query($con, "INSERT INTO posts(title,category,content,image) VALUES('$title','$category','$content','$file')");

            // check if data has been inserted in db

            if ($insert_query) {
                echo "<script>alert('Data inserted');window.location.href = 'insert.php';</script>";
                exit;
            } else {
                echo "<h3>Data was not inserted!</h3>";
            }
        }
    } else {
        echo "<h4>Please fill all fields</h4>";
    }
}


// Edit data and Post table

function get_all_edit_data()
{
    global $con;
    $get_data = mysqli_query($con, "SELECT * FROM posts");
    if (mysqli_num_rows($get_data) > 0) {
        echo '<table>
              <tr>
                <th><h2>Edit Data</h2></th>
              </tr>';
        while ($row = mysqli_fetch_assoc($get_data)) {

            echo '<tr>
            <td>' . $row['title'] . '</td>
            <td>
            <a href="update.php?id=' . $row['id'] . '">Edit</a> |
            <a href="delete.php?id=' . $row['id'] . '">Delete</a>
            </td>
            </tr>';
        }
        echo '</table>';
    } else {
        echo "<h3>Please add some more posts</h3>";
    }
}

//Update data 

function update_get()
{
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        global $con;
        $id = $_GET['id'];
        $get_id = mysqli_query($con, "SELECT * FROM posts WHERE id='$id'");
        if (mysqli_num_rows($get_id) === 1) {
            $row = mysqli_fetch_assoc($get_id);
            return ($row);
        }
    }
}

//Update.php - Update data

if (isset($_POST['update_title']) && isset($_POST['update_category']) && isset($_POST['update_content']) && isset($_POST['update_file'])) {

    //check if items are empty

    if (!empty($_POST['update_title']) && !empty($_POST['update_category']) && !empty($_POST['update_content']) && !empty($_POST['update_file'])) {

        // Escape special characters.

        $title = mysqli_real_escape_string($con, htmlspecialchars($_POST['update_title']));
        $category = mysqli_real_escape_string($con, htmlspecialchars($_POST['update_category']));
        $content = mysqli_real_escape_string($con, htmlspecialchars($_POST['update_content']));
        $file = mysqli_real_escape_string($con, htmlspecialchars($_POST['update_file']));

        $id = $_GET['id'];

        $update_query = mysqli_query($con, "UPDATE posts SET title='$title',category='$category',content='$content',file='$file' WHERE id=$id");

        if ($update_query) {
            echo "<script>alert('Post Updated');window.location.href = 'insert.php';</script>";
            exit;
        } else {
            echo "<h3>Sorry, that didn't work</h3>";
        }
    } else {
        echo "<h4>Please fill all fields</h4>";
    }
}


//Delete.php

function delete()
{
    global $con;
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {

        $userid = $_GET['id'];
        $delete_user = mysqli_query($con, "DELETE FROM posts WHERE id='$userid'");

        if ($delete_user) {
            echo "<script>alert('Data Deleted');window.location.href = 'insert.php';</script>";
            exit;
        } else {
            echo "I think something went wrong";
        }
    }
}

// Update User

//Update data 

function update_get_admin()
{
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        global $con;
        $id = $_GET['id'];
        $get_id = mysqli_query($con, "SELECT * FROM users WHERE id='$id'");
        if (mysqli_num_rows($get_id) === 1) {
            $row = mysqli_fetch_assoc($get_id);
            return ($row);
        }
    }
}
