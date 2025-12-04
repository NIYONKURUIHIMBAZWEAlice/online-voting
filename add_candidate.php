<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";

$posts = getdata("SELECT post_id as id, post_name as name FROM post");

if(isset($_POST['save'])){
    $fname  = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname  = mysqli_real_escape_string($conn, $_POST["lname"]);
    $fullname = $fname . " " . $lname;
    $post_id = mysqli_real_escape_string($conn, $_POST["post"]);

    // Handle file upload
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0){
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file);
    } else {
        $target_file = null;
    }

    $query = "INSERT INTO candidates(fullname, post_id, image) 
              VALUES('$fullname', '$post_id', '$target_file')";

    if(saveData($query)){
        echo "<script>alert('Candidate added successfully!'); location.href='add_candidate.php';</script>";
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
                    <h5 class="mb-0">Add Candidate</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" name="fname" id="fname" class="form-control" placeholder="Enter First Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" name="lname" id="lname" class="form-control" placeholder="Enter Last Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="profile_pic" class="form-label">Profile Picture</label>
                            <input type="file" name="profile_pic" id="profile_pic" class="form-control" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="post" class="form-label">Select Post</label>
                            <select name="post" id="post" class="form-select" required>
                                <option value="" selected disabled>-- Select Post --</option>
                                <?php foreach($posts as $post){ ?>
                                    <option value="<?=$post['id']?>"><?=$post['name']?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <button type="submit" name="save" class="btn btn-success w-100"> Save Candidate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
