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
$pw = $_POST['pw'] ?? '';
$content = $_POST['content'] ?? '';

if (!$no || !$subject || !$writer || !$content || !$pw) {
    die("모든 항목을 입력해주세요.");
}

$no = (int)$no;

$sql = "SELECT pw FROM board WHERE no=$no";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
    die("존재하지 않는 글입니다.");
}

$row = mysqli_fetch_assoc($result);
if ($row['pw'] !== $pw) {
    die("비밀번호가 틀립니다.");
}

$subject_esc = mysqli_real_escape_string($conn, $subject);
$writer_esc = mysqli_real_escape_string($conn, $writer);
$content_esc = mysqli_real_escape_string($conn, $content);
$edate = date("Y-m-d H:i:s");
$sql = "UPDATE board 
        SET subject='$subject_esc', 
            writer='$writer_esc', 
            content='$content_esc', 
            edate='$edate' 
        WHERE no=$no";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('글이 수정되었습니다.'); location.href='/board/list';</script>";
} else {
    echo "수정 실패: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
