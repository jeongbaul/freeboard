<?php

include $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';

if(!isset($_SESSION['user_id'])){
    die("로그인이 필요합니다.");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $id      = $_SESSION['user_id'];
    $name    = $_SESSION['user_name'];
    // $wdate   = date('Y-m-d H:i:s');
    $wdate   = "now()";
    
    if(!$subject || !$content){
        die("제목과 내용을 모두 입력해주세요.");
    }

    $sql = "INSERT INTO qa (name, id, subject, content, wdate) 
            VALUES ('$name', '$id', '$subject', '$content', $wdate)";
    
    if(mysqli_query($conn, $sql)){

        header("Location: /qa/list");
        exit;
    } else {
        die("문의 저장 실패: ".mysqli_error($conn));
    }
} else {
    die("잘못된 접근입니다.");
}
