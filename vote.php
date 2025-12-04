<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";
$id = $_GET['id'];
$votter_id = $_SESSION['user']["user_id"]; 


// Fetch candidates with their posts
$data = getdata("SELECT candidates.*, post.post_name 
                 FROM candidates 
                 INNER JOIN post ON post.post_id = candidates.post_id 
                 WHERE post.post_id ='$id'");
?>

<div class="container mt-4">
    <h3 class="mb-4 text-center">Available Candidates for <?=$data[0]['post_name'] ?? ''?></h3>
    <div class="row">
        <?php
        $no = 0;
        foreach($data as $candidate){
            $no++;
            ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg h-100 border-0">
                    <!-- Candidate Image -->
                    <?php if(!empty($candidate['image'])): ?>
                        <img src="<?=$candidate['image']?>" class="card-img-top" alt="Profile" style="height:200px; object-fit:cover;">
                    <?php else: ?>
                        <img src="default.png" class="card-img-top" alt="No Image" style="height:200px; object-fit:cover;">
                    <?php endif; ?>

                    <div class="card-body text-center">
                        <h5 class="card-title"><?=$candidate['fullname']?></h5>
                        <p class="card-text">
                            <span class="badge bg-info"><?=$candidate['post_name']?></span>
                        </p>
                    </div>
                    <div class="card-footer text-center bg-light">
                        <a href="vote_candidate.php?id=<?=$candidate['cand_id']?>" 
                           class="btn btn-success btn-sm">
                            Vote
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
$votedata=getdata("SELECT COUNT(*) as n_vote FROM votte INNER JOIN candidates  ON votte.candidate_id = candidates.cand_id WHERE votte.votter_id = '$votter_id' AND candidates.post_id = '$id'");
$nvote=$votedata[0]["n_vote"];
 if (!empty($nvote)) {
        echo "<script>alert('You have already voted for this candidate!'); location.href='votter_home.php';</script>";
        exit;
    }

    ?>
