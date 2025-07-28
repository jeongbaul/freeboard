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

// 게시글 조회
$sql = "SELECT no, subject, writer, content, wdate FROM board WHERE no = :no";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':no', $no, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("존재하지 않는 글입니다.");
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>게시글 보기</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 700px;
      margin: 50px auto;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 8px;
    }
    h1, h2 {
      text-align: center;
    }
    .post-info {
      margin-bottom: 20px;
      font-size: 0.9em;
      color: #666;
      text-align: center;
    }
    .content {
      white-space: pre-wrap;
      border-top: 1px solid #ccc;
      padding-top: 15px;
    }
    .btn-group {
      margin-top: 20px;
      text-align: center;
    }
    .btn {
      padding: 8px 15px;
      margin: 0 5px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      font-size: 0.9em;
    }
    .btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <h1>게시글 보기</h1>

  <h2><?= htmlspecialchars($post['subject']) ?></h2>

  <div class="post-info">
    작성자: <?= htmlspecialchars($post['writer']) ?> | 작성일: <?= htmlspecialchars($post['wdate']) ?>
  </div>

  <div class="content"><?= nl2br(htmlspecialchars($post['content'])) ?></div>

  <div class="btn-group">
    <button onclick="location.href='/pages/board/list.php'">목록</button>
    <button onclick="location.href='/pages/board/modify.php?no=<?= $post['no'] ?>'">수정</button>
    <button onclick="if(confirm('정말 삭제하시겠습니까?')) location.href='/pages/board/delete.php?no=<?= $post['no'] ?>'">삭제</button>
  </div>

</body>
</html>
