<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";

$no = $_GET['no'] ?? null;
if (!$no) {
    die("글 번호가 없습니다.");
}

$no = mysqli_real_escape_string($conn, $no);
$sql = "SELECT subject FROM board WHERE no = '$no'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("존재하지 않는 글입니다.");
}

$post = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>글 삭제 확인</title>
  <link rel="stylesheet" href="/css/index.css">
</head>
<body class="delete-page">

  <h1>글 삭제 확인</h1>

  <form method="post" action="/board/delete_ok">
    <p>정말 삭제하시겠습니까?</p>
    <p><strong><?= htmlspecialchars($post['subject']) ?></strong></p>
    <input type="hidden" name="no" value="<?= htmlspecialchars($no) ?>">
    <p>
      <button type="submit" class="btn-confirm">삭제</button>
      <button type="button" class="btn-cancel" onclick="history.back()">취소</button>
    </p>
  </form>

  <a href="/board/list" class="back-link">← 목록으로 돌아가기</a>

</body>
</html>
