<?php
require_once "inc/conn.php";
include_once "inc/header.php";
include_once "inc/utils.php";
if (isset($_GET['id'])) {
    $candidate_id = intval($_GET['id']); // candidate being voted for
    
    // Example: get current logged-in voter ID (adjust based on your auth system)
    $votter_id = $_SESSION['user']["user_id"]; 
    
    // Prevent duplicate votes (optional)
    $check = getdata("SELECT * FROM votte WHERE candidate_id='$candidate_id' AND votter_id='$votter_id'");
    if (!empty($check)) {
        echo "<script>alert('You have already voted for this candidate!'); location.href='votter_home.php';</script>";
        exit;
    }

    // Insert vote
    $query = "INSERT INTO votte(candidate_id, votter_id) VALUES('$candidate_id', '$votter_id')";
    // die($query);
    if (saveData($query)) {
        echo "<script>alert('Vote recorded successfully!'); location.href='votter_home.php';</script>";
    } else {
        echo "Failed to record vote.";
    }
}
?>
