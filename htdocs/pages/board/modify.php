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

$no = (int)$no;
$sql = "SELECT subject, writer, content FROM board WHERE no = $no";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("존재하지 않는 글입니다.");
}

$row = mysqli_fetch_assoc($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>글 수정</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #f9f9f9;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    form p {
      margin-bottom: 15px;
    }
    input[type="text"], textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    textarea {
      resize: vertical;
    }
    button {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
      font-size: 1em;
    }
    button:hover {
      background-color: #45a049;
    }
    a {
      display: inline-block;
      margin-top: 15px;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <h1>글 수정</h1>

  <form method="post" action="/board/modify_ok">
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

  <a href="/board/list">← 목록으로 돌아가기</a>

</body>
</html>
