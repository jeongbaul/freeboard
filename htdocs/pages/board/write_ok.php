<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "freeboard");
    if ($conn->connect_error) {
        die("DB 연결 실패: " . $conn->connect_error);
    }

    $subject = $_POST['subject'] ?? '';
    $writer = $_POST['writer'] ?? '';
    $content = $_POST['content'] ?? '';
    $wdate = date("Y-m-d H:i:s");

    if (!$subject || !$writer || !$content) {
        die("모든 항목을 입력해주세요.");
    }

    $sql = "INSERT INTO board (subject, writer, content, wdate) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $subject, $writer, $content, $wdate);

    if ($stmt->execute()) {
        echo "<script>alert('글이 등록되었습니다.'); location.href='/pages/board/list.php';</script>";
    } else {
        echo "등록 실패: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
