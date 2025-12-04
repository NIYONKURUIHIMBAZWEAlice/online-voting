
<?php
require_once("inc/conn.php");
$id=$_GET['id'];
if(!isset($id)){
    header('location:candidates.php');
}else{
    $query="DELETE FROM candidates WHERE cand_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i",$id);
    if($stmt->execute()){
          echo "<script>alert('candidate destroyed success fully'); location.href='candidates.php';</script>";
    }
}

?>