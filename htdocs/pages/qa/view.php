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
</head>
<body>
<h1>질문 상세보기</h1>

<h3>제목: <?= htmlspecialchars($question['subject']) ?></h3>
<p>작성자: <?= htmlspecialchars($question['name']) ?></p>
<p>문의 내용: <?= nl2br(htmlspecialchars($question['content'])) ?></p>
<p>작성일: <?= $question['wdate'] ?></p>

<hr>

<?php if(empty($question['reply'])): ?>
    <h3>답변 작성</h3>
    <form method="POST">
        <textarea name="reply" rows="5" cols="50" required></textarea><br>
        <button type="submit">답변 저장</button>
    </form>
<?php else: ?>
    <h3>답변</h3>
    <p>작성자: <?= htmlspecialchars($question['reply_name']) ?></p>
    <p>작성일: <?= $question['reply_date'] ?></p>
    <p>답변 내용: <?= nl2br(htmlspecialchars($question['reply'])) ?></p>
<?php endif; ?>

<p><a href="/qa/list">목록으로 돌아가기</a></p>


</body>
</html>
