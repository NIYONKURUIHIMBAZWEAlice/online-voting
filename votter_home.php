<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";

$data = getdata("SELECT * FROM post");
?>

<div class="container mt-5">
    <h3 class="mb-4 text-center text-primary">Available Posts</h3>
    <div class="row">
        <?php
        $no = 0;
        foreach($data as $post){
            $no++;
            ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg h-100 border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="vote.php?id=<?=$post['post_id']?>" class="text-decoration-none fw-bold text-dark">
                                <?=$post["post_name"]?>
                            </a>
                        </h5>
                        <p class="card-text">
                            Status: <span class="badge bg-info"><?=$post["status"]?></span>
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light">
                        <small class="text-muted">Post #<?=$no?></small>
                        <a href="vote.php?id=<?=$post['post_id']?>" 
                           class="btn btn-sm btn-success">
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

