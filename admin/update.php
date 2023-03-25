<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$row = update_get();
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
                    <label for="update_title">Title</label>
                    <input type="text" name="update_title" class="form-control" id="update_title" placeholder="Title" value="<?php echo $row['title']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="update_category">Category</label>
                    <input type="text" name="update_category" class="form-control" id="update_category" placeholder="Category" value="<?php echo $row['category']; ?>">
                </div>
                <div class="form-group">
                    <label for="update_content">Content</label>
                    <textarea class="form-control" id="update_content" name="update_content" rows="4" cols="50" value="ad" required><?php echo $row['content']; ?>
            </textarea>
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