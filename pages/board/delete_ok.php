<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /list");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "freeboard");
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$no = $_POST['no'] ?? null;
if (!$no) {
    die("글 번호가 없습니다.");
}

$no = (int)$no;
$sql = "DELETE FROM board WHERE no = $no";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('글이 삭제되었습니다.'); location.href='/board/list';</script>";
} else {
    echo "삭제 실패: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
