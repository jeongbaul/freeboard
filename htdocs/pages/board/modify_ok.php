<?php
date_default_timezone_set('Asia/Seoul');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location:/pages/board/list.php");
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=freeboard;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}

$no = $_POST['no'] ?? null;
$subject = $_POST['subject'] ?? '';
$writer = $_POST['writer'] ?? '';
$content = $_POST['content'] ?? '';

if (!$no || !$subject || !$writer || !$content) {
    die("모든 항목을 입력해주세요.");
}

$sql = "UPDATE board SET subject = :subject, writer = :writer, content = :content WHERE no = :no";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':subject', $subject);
$stmt->bindParam(':writer', $writer);
$stmt->bindParam(':content', $content);
$stmt->bindParam(':no', $no, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "<script>alert('글이 수정되었습니다.'); location.href='/pages/board/list.php';</script>";
} else {
    echo "수정 실패: " . implode(" ", $stmt->errorInfo());
}
