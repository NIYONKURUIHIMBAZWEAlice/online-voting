<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";

// number of records per page
$perPage = 3;

// get current page from URL, default to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
          ? (int) $_GET['page']
          : 1;

// compute OFFSET for SQL
$start_from = ($page - 1) * $perPage;

// get total number of voters (for pagination count)
$result_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM votters");
$row_total    = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total'];
$total_pages   = ceil($total_records / $perPage);

// fetch only the subset for this page
$query = "SELECT * FROM votters ORDER BY votter_id ASC LIMIT ?, ?";
$stmt  = $conn->prepare($query);
$stmt->bind_param("ii", $start_from, $perPage);
$stmt->execute();
$data  = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Registered Votters</h3>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = $start_from;
                foreach($data as $post){
                    $no++;
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?= htmlspecialchars($post["fullname"]) ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- pagination links — left aligned by default -->
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <!-- previous page link -->
        <?php if($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
          </li>
        <?php else: ?>
          <li class="page-item disabled">
            <span class="page-link">Previous</span>
          </li>
        <?php endif; ?>

        <!-- page number links -->
        <?php for($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= $i === $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <!-- next page link -->
        <?php if($page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
          </li>
        <?php else: ?>
          <li class="page-item disabled">
            <span class="page-link">Next</span>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
</div>
