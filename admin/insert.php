<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>

<?php
include './includes/adminHeader.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 pt-5">
            <h2>Add Post</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data
            ">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="title">
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" name="category" class="form-control" id="category" placeholder="category">
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <br>
                    <textarea class="form-control" name="content" id="content" cols="50" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="file">Image</label>
                    <input type="file" name="file" class="form-control" id="file" accept=".jpg, .jpeg, .png, .pdf" value="">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
        <div class="col-md-7 pt-5">
            <div class="container">
                <div class="row">
                    <?php get_post_data(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include './includes/adminFooter.php';
include './includes/scripts.php';
?>