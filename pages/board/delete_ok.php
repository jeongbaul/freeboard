<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /board/list");
    exit;
}

$no = $_POST['no'] ?? null;
$inputPw = $_POST['pw'] ?? '';

if (!$no) {
    die("글 번호가 없습니다.");
}

$no = (int)$no;

$sql = "SELECT pw FROM board WHERE no = $no";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("존재하지 않는 글입니다.");
}

$row = mysqli_fetch_assoc($result);
$storedHash = $row['pw'];

if (!password_verify($inputPw, $storedHash)) {
    die("<script>alert('비밀번호가 틀렸습니다.'); history.back();</script>");
}

$sql = "DELETE FROM board WHERE no = $no";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('글이 삭제되었습니다.'); location.href='/board/list';</script>";
} else {
    echo "삭제 실패: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
