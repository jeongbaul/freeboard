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
h1 {
    margin-bottom: 20px;
    text-align: left;
}
form p {
    margin: 15px 0;
}
label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}
input[type="text"], input[type="password"], textarea {
    width: 100%;
    padding: 8px;
    font-size: 1em;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
textarea {
    height: 180px;
    resize: vertical;
}
button {
    padding: 8px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.95em;
    margin-top: 10px;
}
button:hover {
    background-color: #0056b3;
}
a.back-link {
    margin-top: 20px;
    display: block;
    text-align: left;
    color: #007bff;
    text-decoration: none;
}
a.back-link:hover {
    text-decoration: underline;
}
</style>
</head>
<body>

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
    <p>
        <button type="submit">등록</button>
    </p>
</form>

<a class="back-link" href="/board/list">← 목록으로 돌아가기</a>

</body>
</html>
