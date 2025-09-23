<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';

if(!isset($_SESSION['user_id'])){
    die("로그인이 필요합니다.");
}

$no = $_GET['no'] ?? '';
if(!$no){
    die("잘못된 접근입니다.");
}

$sql = "SELECT id FROM qa WHERE no = '$no'";
$result = mysqli_query($conn, $sql);

if($row = mysqli_fetch_assoc($result)){
    if($row['id'] !== $_SESSION['user_id']){
        die("본인이 작성한 글만 삭제할 수 있습니다.");
    }

    $del_sql = "DELETE FROM qa WHERE no = '$no'";
    if(mysqli_query($conn, $del_sql)){
        header("Location: /qa/list");
        exit;
    } else {
        die("삭제 실패: ".mysqli_error($conn));
    }
} else {
    die("존재하지 않는 글입니다.");
}
