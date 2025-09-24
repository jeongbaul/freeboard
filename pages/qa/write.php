<?php
if(!isset($_SESSION['user_id'])){
    die("로그인이 필요합니다.");
}
?>

<h1>문의 작성</h1>

<p>작성자: <?= htmlspecialchars($_SESSION['user_name']) ?></p>

<form method="POST" action="/qa/write_ok">
    <p>
        <label for="subject">문의 제목</label>
        <input type="text" id="subject" name="subject" required>
    </p>
    <p>
        <label for="content">문의 내용</label>
        <textarea id="content" name="content" rows="8" required></textarea>
    </p>
    <p>
        <button type="submit">작성</button>
    </p>
</form>

<a href="/qa/list" class="back-link">← 목록으로 돌아가기</a>
