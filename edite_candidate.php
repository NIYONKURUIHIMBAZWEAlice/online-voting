<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";

// Get candidate ID from URL
if(!isset($_GET['id'])){
    echo "<script>alert('No candidate selected'); location.href='candidates.php';</script>";
    exit();
}
$id = intval($_GET['id']);

// Fetch candidate info
$candidate = getdata("SELECT * FROM candidates WHERE cand_id = $id");
if(!$candidate){
    echo "<script>alert('Candidate not found'); location.href='candidates.php';</script>";
    exit();
}
$candidate = $candidate[0];

// Fetch posts for dropdown
$posts = getdata("SELECT post_id as id, post_name as name FROM post");

// Handle update
if(isset($_POST['update'])){
    $fname  = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname  = mysqli_real_escape_string($conn, $_POST["lname"]);
    $fullname = $fname . " " . $lname;
    $post_id = mysqli_real_escape_string($conn, $_POST["post"]);

    // Handle file upload (optional)
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0){
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file);
    } else {
        $target_file = $candidate['image']; // keep old image if not changed
    }

    $query = "UPDATE candidates 
              SET fullname='$fullname', post_id='$post_id', image='$target_file' 
              WHERE cand_id='$id'";

    if(saveData($query)){
        echo "<script>alert('Candidate updated successfully!'); location.href='candidates.php';</script>";
    } else {
        echo "Failed to update candidate";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Candidate</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" name="fname" id="fname" class="form-control" 
                                   value="<?=htmlspecialchars(explode(' ', $candidate['fullname'])[0])?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" name="lname" id="lname" class="form-control" 
                                   value="<?=htmlspecialchars(explode(' ', $candidate['fullname'])[1] ?? '')?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="profile_pic" class="form-label">Profile Picture</label>
                            <?php if(!empty($candidate['image'])): ?>
                                <div class="mb-2">
                                    <img src="<?=$candidate['image']?>" alt="Profile" width="80" height="80" class="rounded-circle border">
                                </div>
                            <?php endif; ?>
                            <input type="file" name="profile_pic" id="profile_pic" class="form-control" accept="image/*">
                            <small class="text-muted">Leave blank to keep current picture</small>
                        </div>

                        <div class="mb-3">
                            <label for="post" class="form-label">Select Post</label>
                            <select name="post" id="post" class="form-select" required>
                                <?php foreach($posts as $post){ ?>
                                    <option value="<?=$post['id']?>" 
                                        <?=$post['id']==$candidate['post_id'] ? 'selected' : ''?>>
                                        <?=$post['name']?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <button type="submit" name="update" class="btn btn-warning w-100"> Update Candidate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
