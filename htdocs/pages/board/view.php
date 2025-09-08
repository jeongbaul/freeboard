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

$sql = "SELECT no, subject, writer, content, wdate, pw FROM board WHERE no = " . intval($no);
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
  <title>게시글 보기</title>
<style>
body {
    font-family: 'Noto Sans KR', sans-serif;
    background-color: #f9f9f9;
    color: #333;
    margin: 0;
    padding: 0;
}
.container {
    max-width: 700px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 6px;
}
h1, h2, h3 {
    margin: 0 0 10px 0;
    text-align: left; /* 제목도 왼쪽 */
}
.section-title {
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 5px;
}
hr {
    border: 0;
    border-top: 1px solid #ddd;
    margin: 10px 0 20px 0;
}
.post-info, .reply-info {
    font-size: 0.85em;
    color: #666;
    margin-bottom: 10px;
}
.content, .reply-content {
    white-space: pre-wrap;
    line-height: 1.6;
    margin-bottom: 20px;
    text-align: left;
}
.btn {
    padding: 8px 15px;
    margin: 0 5px;
    font-size: 0.9em;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.btn:hover {
    background-color: #0056b3;
}
textarea {
    width: 100%;
    padding: 8px;
    font-size: 0.9em;
    border-radius: 4px;
    border: 1px solid #ccc;
    resize: vertical;
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
  <button onclick="location.href='/board/list'">목록</button>
  <button onclick="modifyPost()">수정</button>
  <button onclick="deletePost()">삭제</button>
</div>

<script>
function modifyPost() {
  const pw = prompt("수정하려면 비밀번호를 입력하세요:");
  if(!pw) return;
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = '/board/verify_pw';
  form.innerHTML = `<input type="hidden" name="no" value="<?= $post['no'] ?>">
                    <input type="hidden" name="pw" value="`+pw+`">
                    <input type="hidden" name="action" value="modify">`;
  document.body.appendChild(form);
  form.submit();
}

function deletePost() {
  const pw = prompt("삭제하려면 비밀번호를 입력하세요:");
  if(!pw) return;
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = '/board/verify_pw';
  form.innerHTML = `<input type="hidden" name="no" value="<?= $post['no'] ?>">
                    <input type="hidden" name="pw" value="`+pw+`">
                    <input type="hidden" name="action" value="delete">`;
  document.body.appendChild(form);
  form.submit();
}
</script>


</body>
</html>
