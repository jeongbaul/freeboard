<?php

if(!isset($_SESSION['user_id'])){
    die("로그인이 필요합니다.");
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>문의 작성</title>
</head>
<body>
<h1>문의 작성</h1>

<p>작성자: <?= htmlspecialchars($_SESSION['user_name']) ?></p>

<form method="POST" action="/qa/write_ok">
    문의 제목: <input type="text" name="subject" required><br><br>
    문의 내용: <br>
    <textarea name="content" rows="8" cols="50" required></textarea><br><br>
    <button type="submit">작성</button>
</form>

<a href="/qa/list">목록으로 돌아가기</a>
</body>
</html>
