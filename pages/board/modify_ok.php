<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location:/board/list");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "freeboard");
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$no = $_POST['no'] ?? null;
$subject = $_POST['subject'] ?? '';
$writer = $_POST['writer'] ?? '';
$content = $_POST['content'] ?? '';

if (!$no || !$subject || !$writer || !$content) {
    die("모든 항목을 입력해주세요.");
}

$no = (int)$no;
$subject_esc = mysqli_real_escape_string($conn, $subject);
$writer_esc = mysqli_real_escape_string($conn, $writer);
$content_esc = mysqli_real_escape_string($conn, $content);

$sql = "UPDATE board SET subject='$subject_esc', writer='$writer_esc', content='$content_esc' WHERE no=$no";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('글이 수정되었습니다.'); location.href='/board/list';</script>";
} else {
    echo "수정 실패: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
