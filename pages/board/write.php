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
