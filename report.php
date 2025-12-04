<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";

// Query: count votes per candidate grouped by post
$query = "
    SELECT c.cand_id, c.fullname, p.post_name, COUNT(v.votte_id) AS total_votes
    FROM candidates c
    INNER JOIN post p ON p.post_id = c.post_id
    LEFT JOIN votte v ON v.candidate_id = c.cand_id
    GROUP BY c.cand_id, c.fullname, p.post_name
    ORDER BY p.post_id, total_votes DESC
";
$data = getdata($query);
?>

<div class="container mt-4">
    <h3 class="mb-4"> Candidate Scores</h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Rank</th>
                    <th>Candidate</th>
                    <th>Post</th>
                    <th>Total Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $currentPost = null;
                $rank = 0;
                foreach($data as $row){
                    // Reset rank when post changes
                    if($currentPost !== $row['post_name']){
                        $currentPost = $row['post_name'];
                        $rank = 1;
                    } else {
                        $rank++;
                    }
                    ?>
                    <tr>
                        <td><?=$rank?></td>
                        <td><?=$row['fullname']?></td>
                        <td><?=$row['post_name']?></td>
                        <td><span class="badge bg-success"><?=$row['total_votes']?></span></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
