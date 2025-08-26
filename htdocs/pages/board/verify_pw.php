<?php
$conn = mysqli_connect("localhost", "root", "", "freeboard");
if (!$conn) { die("DB 연결 실패: " . mysqli_connect_error()); }

$no = $_POST['no'] ?? null;
$pw = $_POST['pw'] ?? null;
$action = $_POST['action'] ?? null;

if (!$no || !$pw || !$action) {
    die("잘못된 접근입니다.");
}

$no = (int)$no;
$pw = mysqli_real_escape_string($conn, $pw);

$sql = "SELECT pw FROM board WHERE no = $no";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
    die("글이 존재하지 않습니다.");
}

$row = mysqli_fetch_assoc($result);

if ($row['pw'] !== $pw) {
    echo "<script>alert('비밀번호가 틀립니다.'); history.back();</script>";
    exit;
}

if ($action === 'modify') {
    header("Location: /board/modify?no=$no");
    exit;
} elseif ($action === 'delete') {
    header("Location: /board/delete?no=$no");
    exit;
} else {
    die("잘못된 요청입니다.");
}
?>
