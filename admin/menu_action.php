<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";

// 관리자만 처리
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] != 1){
    echo "<script>alert('관리자만 접근 가능합니다.'); location.href='/';</script>";
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if($action == 'add'){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $ord = (int)($_POST['ord'] ?? 0);

    $sql = "INSERT INTO menu (title, link, ord) VALUES ('$title', '$link', $ord)";
    mysqli_query($conn, $sql);
    header("Location: menu_admin.php");
    exit;
}
elseif($action == 'delete'){
    $id = (int)($_GET['id'] ?? 0);
    if($id > 0){
        $sql = "DELETE FROM menu WHERE id=$id";
        mysqli_query($conn, $sql);
    }
    header("Location: menu_admin.php");
    exit;
}
