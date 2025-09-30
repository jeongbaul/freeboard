<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'] ?? '';
    $writer  = $_POST['writer'] ?? '';
    $content = $_POST['content'] ?? '';
    $pw      = $_POST['pw'] ?? '';
    $wdate   = date("Y-m-d H:i:s");

    if (!$subject || !$writer || !$content || !$pw) {
        die("모든 항목을 입력해주세요.");
    }

    $subject = mysqli_real_escape_string($conn, $subject);
    $writer  = mysqli_real_escape_string($conn, $writer);
    $content = mysqli_real_escape_string($conn, $content);
    $wdate   = mysqli_real_escape_string($conn, $wdate);

    $hashedPw = password_hash($pw, PASSWORD_DEFAULT);

    $sql = "INSERT INTO board (subject, writer, content, wdate, pw) 
            VALUES ('$subject', '$writer', '$content', '$wdate', '$hashedPw')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('글이 등록되었습니다.');
                location.href='/board/list';
              </script>";
    } else {
        echo "등록 실패: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    exit;
}
?>
