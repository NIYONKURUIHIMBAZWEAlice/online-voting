<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";

$data = getdata("SELECT * FROM post");
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Available Posts</h3>
        <a href="add_post.php" class="btn btn-primary"> Add Post</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                foreach($data as $post){
                    $no++;
                    ?>
                    <tr>
                        <td><?=$no?></td>
                        <td><?=$post["post_name"]?></td>
                        <td>
                            <?php if(!empty($post["status"])): ?>
                                <span class="badge bg-info"><?=$post["status"]?></span>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="delete_post.php?id=<?=$post['post_id']?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this post?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
