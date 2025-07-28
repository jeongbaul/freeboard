<?php
date_default_timezone_set('Asia/Seoul');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: list.php");
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=freeboard;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}

$no = $_POST['no'] ?? null;
if (!$no) {
    die("글 번호가 없습니다.");
}

$sql = "DELETE FROM board WHERE no = :no";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':no', $no, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "<script>alert('글이 삭제되었습니다.'); location.href='list.php';</script>";
} else {
    echo "삭제 실패: " . implode(" ", $stmt->errorInfo());
}
