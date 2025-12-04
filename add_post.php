<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";

if(isset($_POST['save'])){
    $name = mysqli_real_escape_string($conn,$_POST["name"]);
    $query = "INSERT INTO post(`post_name`) VALUES('$name')";
    if(saveData($query)){
        echo "<script>alert('Post added!'); location.href='add_post.php';</script>";
    } else {
        echo "Failed";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add New Post</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Post Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Post Name" required>
                        </div>
                        <button type="submit" name="save" class="btn btn-success w-100">Save Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
