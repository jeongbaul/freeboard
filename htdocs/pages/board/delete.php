<?php
date_default_timezone_set('Asia/Seoul');

$conn = mysqli_connect("localhost", "root", "", "freeboard");
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

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
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 500px;
      margin: 100px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #f9f9f9;
      text-align: center;
    }
    button {
      padding: 10px 20px;
      margin: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1em;
    }
    .btn-confirm {
      background-color: #dc3545;
      color: white;
    }
    .btn-cancel {
      background-color: #6c757d;
      color: white;
    }
  </style>
</head>
<body>

  <h1>글 삭제 확인</h1>
  <p>정말 삭제하시겠습니까?</p>
  <p><strong><?= htmlspecialchars($post['subject']) ?></strong></p>

  <form method="post" action="/board/delete_ok">
    <input type="hidden" name="no" value="<?= htmlspecialchars($no) ?>">
    <button type="submit" class="btn-confirm">삭제</button>
    <button type="button" class="btn-cancel" onclick="history.back()">취소</button>
  </form>

</body>
</html>
