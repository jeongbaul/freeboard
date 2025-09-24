<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";

$no = $_GET['no'] ?? null;
if (!$no) {
    die("글 번호가 없습니다.");
}

$no = (int)$no;
$sql = "SELECT * FROM board WHERE no = $no";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("존재하지 않는 글입니다.");
}

$row = mysqli_fetch_assoc($result);
?>

<h1>자유게시판 글수정</h1>

<form method="post" action="/board/modify_ok">
    <input type="hidden" name="no" value="<?= $row['no'] ?>">

    <p>
        <label for="subject">제목</label>
        <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($row['subject']) ?>" required>
    </p>
    <p>
        <label for="writer">작성자</label>
        <input type="text" id="writer" name="writer" value="<?= htmlspecialchars($row['writer']) ?>" required readonly>
    </p>
    <p>
        <label for="pw">비밀번호</label>
        <input type="password" id="pw" name="pw" required placeholder="수정 시 필요">
    </p>
    <p>
        <label for="content">내용</label>
        <textarea id="content" name="content" required><?= htmlspecialchars($row['content']) ?></textarea>
    </p>
    <p>
        <button type="submit">수정하기</button>
    </p>
</form>

<a class="back-link" href="/board/list">← 목록으로 돌아가기</a>
