<?php
date_default_timezone_set('Asia/Seoul');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=freeboard;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}

$no = $_GET['no'] ?? null;
if (!$no) {
    die("글 번호가 없습니다.");
}

$sql = "SELECT subject, writer, content FROM board WHERE no = :no";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':no', $no, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("존재하지 않는 글입니다.");
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>글 수정</title>
  <style>
  </style>
</head>
<body>

  <h1>글 수정</h1>

  <form method="post" action="/pages/board/modify_ok.php">
    <input type="hidden" name="no" value="<?= htmlspecialchars($no) ?>">
    <p>
      <label for="subject">제목</label>
      <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($row['subject']) ?>" required>
    </p>
    <p>
      <label for="writer">작성자</label>
      <input type="text" id="writer" name="writer" value="<?= htmlspecialchars($row['writer']) ?>" required>
    </p>
    <p>
      <label for="content">내용</label><br>
      <textarea id="content" name="content" rows="10" required><?= htmlspecialchars($row['content']) ?></textarea>
    </p>
    <p style="text-align:center;">
      <button type="submit">수정 완료</button>
    </p>
  </form>

  <a href="/pages/board/list.php">← 목록으로 돌아가기</a>

</body>
</html>
