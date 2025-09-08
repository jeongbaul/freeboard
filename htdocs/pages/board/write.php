<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>자유게시판 글쓰기</title>
<style>
body {
    font-family: 'Noto Sans KR', sans-serif;
    background-color: #f9f9f9;
    color: #333;
    line-height: 1.6;
}
h1, h2, h3 {
    margin: 0 0 10px 0;
    text-align: left;
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
    text-align: left;
    margin-bottom: 20px;
}
.btn {
    padding: 8px 15px;
    margin: 0 5px 10px 0;
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

</style>
</head>
<body>
<div class="container">
<h1>자유게시판 글쓰기</h1>
<form method="post" action="/board/write_ok">
    <p>
        <label for="subject">제목</label>
        <input type="text" id="subject" name="subject" required>
    </p>
    <p>
        <label for="writer">작성자</label>
        <input type="text" id="writer" name="writer" required>
    </p>
    <p>
        <label for="pw">비밀번호</label>
        <input type="password" id="pw" name="pw" required placeholder="수정/삭제 시 필요">
    </p>
    <p>
        <label for="content">내용</label>
        <textarea id="content" name="content" required></textarea>
    </p>
    <p style="text-align:center;">
        <button type="submit">등록</button>
    </p>
</form>
<a class="back-link" href="/board/list">← 목록으로 돌아가기</a>
</div>
</body>
</html>
