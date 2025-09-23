<?php
include $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';

$no = $_GET['no'] ?? '';
if(!$no){
    die("잘못된 접근입니다.");
}

$sql = "SELECT * FROM qa WHERE no='$no'";
$result = mysqli_query($conn, $sql);
if(!$question = mysqli_fetch_assoc($result)){
    die("존재하지 않는 질문입니다.");
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'])){
    if(($_SESSION['user_level'] ?? '') != 1){
        die("답변 권한이 없습니다.");
    }

    $reply = mysqli_real_escape_string($conn, $_POST['reply']);
    $reply_name = $_SESSION['user_name'] ?? '관리자';
    $reply_id = $_SESSION['user_id'] ?? 'admin';
    $reply_date = date('Y-m-d H:i:s');

    $update_sql = "UPDATE qa 
                SET reply='$reply', reply_name='$reply_name', reply_id='$reply_id', reply_date='$reply_date'
                WHERE no='$no'";
    mysqli_query($conn, $update_sql);

    header("Location: /qa/view?no=$no");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Q&A 상세보기</title>
    <link rel="stylesheet" href="/css/index.css">
</head>
<body class="qa-view-page">

<div class="container">
    <h1>질문 상세보기</h1>

    <h3>제목: <?= htmlspecialchars($question['subject']) ?></h3>
    <p class="post-info">작성자: <?= htmlspecialchars($question['name']) ?> | 작성일: <?= $question['wdate'] ?></p>
    <div class="content"><?= nl2br(htmlspecialchars($question['content'])) ?></div>

    <hr>

    <?php if(empty($question['reply'])): ?>
        <?php if(($_SESSION['user_level'] ?? '') == 1): ?>
            <h3>답변 작성</h3>
            <form method="POST">
                <textarea name="reply" rows="5" required></textarea>
                <p><button type="submit" class="btn">답변 저장</button></p>
            </form>
        <?php else: ?>
            <p><strong>답변 권한이 없습니다. (관리자 전용)</strong></p>
        <?php endif; ?>
    <?php else: ?>
        <h3>답변</h3>
        <p class="reply-info">작성자: <?= htmlspecialchars($question['reply_name']) ?> | 작성일: <?= $question['reply_date'] ?></p>
        <div class="reply-content"><?= nl2br(htmlspecialchars($question['reply'])) ?></div>
    <?php endif; ?>

    <p><a href="/qa/list" class="back-link">← 목록으로 돌아가기</a></p>
</div>

</body>
</html>
