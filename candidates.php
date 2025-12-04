<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";


$rows_per_page = 3;  
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page < 1) { $page = 1; }
$offset = ($page - 1) * $rows_per_page;


$countData = getdata("SELECT COUNT(*) AS total FROM candidates");
$total_records = (int)$countData[0]['total'];
$total_pages = ceil($total_records / $rows_per_page);


$data = getdata("
    SELECT candidates.*, post.post_name
    FROM candidates
    INNER JOIN post ON post.post_id = candidates.post_id
    LIMIT $rows_per_page OFFSET $offset
");
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Available Candidates</h3>
        <a href="add_candidate.php" class="btn btn-primary">Add Candidate</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Names</th>
                    <th>Post</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = $offset;  
                foreach($data as $candidate){
                    $no++;
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td>
                      <?php if(!empty($candidate['image'])): ?>
                         <img src="<?=$candidate['image']?>" alt="Profile" width="50" height="50" class="rounded-circle border border-2" style="object-fit:cover;">
                      <?php else: ?>
                         <span class="text-muted">No Image</span>
                      <?php endif; ?>
                    </td>
                    <td><?=$candidate['fullname']?></td>
                    <td><span class="badge bg-info"><?=$candidate['post_name']?></span></td>
                    <td>
                      <a href="delete_candidate.php?id=<?=$candidate['cand_id']?>"
                         class="btn btn-sm btn-danger"
                         onclick="return confirm('Are you sure you want to delete this candidate?');">
                         Delete
                      </a>
                    </td>
                    <td>
                      <a href="edite_candidate.php?id=<?=$candidate['cand_id']?>"
                         class="btn btn-sm btn-success"
                         onclick="return confirm('Are you sure you want to edit this candidate?');">
                         Edit
                      </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

   
    <nav>
      <ul class="pagination">
        <?php if($page > 1): ?>
          <li class="page-item"><a class="page-link" href="?page=<?=$page-1?>">Previous</a></li>
        <?php endif; ?>

        <?php for($p = 1; $p <= $total_pages; $p++): ?>
          <li class="page-item <?=($p == $page?'active':'')?>">
            <a class="page-link" href="?page=<?=$p?>"><?=$p?></a>
          </li>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
          <li class="page-item"><a class="page-link" href="?page=<?=$page+1?>">Next</a></li>
        <?php endif; ?>
      </ul>
    </nav>
</div>
