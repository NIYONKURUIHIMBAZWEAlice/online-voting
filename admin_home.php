<?php
// session_start();
// if(!isset($_SESSION["user"])){
//     echo "<script>alert('You must login first'); location.href='index.php';</script>";
//     exit();
// }

require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";

// Fetch system info
$totalPosts = getdata("SELECT COUNT(*) as count FROM post")[0]['count'];
$totalCandidates = getdata("SELECT COUNT(*) as count FROM candidates")[0]['count'];
$totalVoters = getdata("SELECT COUNT(*) as count FROM votters")[0]['count'];
$totalVotes = getdata("SELECT COUNT(*) as count FROM votte")[0]['count'];
?>

<div class="container mt-4">
    <h2 class="mb-4 text-center"><u> Admin Dashboard</u></h2>

    <div class="row">
        <!-- Posts -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Posts</h5>
                    <p class="display-6 text-primary"><?=$totalPosts?></p>
                </div>
            </div>
        </div>

        <!-- Candidates -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Candidates</h5>
                    <p class="display-6 text-success"><?=$totalCandidates?></p>
                </div>
            </div>
        </div>

        <!-- Voters -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Voters</h5>
                    <p class="display-6 text-warning"><?=$totalVoters?></p>
                </div>
            </div>
        </div>

        <!-- Votes -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Votes</h5>
                    <p class="display-6 text-danger"><?=$totalVotes?></p>
                </div>
            </div>
        </div>
    </div>
</div>
