<?php
$conn = mysqli_connect("localhost", "root", "", "freeboard");
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$board_sql = "SELECT no, subject, wdate FROM board ORDER BY no DESC LIMIT 5";
$board_result = mysqli_query($conn, $board_sql);
$boards = [];
if ($board_result) {
    while ($row = mysqli_fetch_assoc($board_result)) {
        $boards[] = $row;
    }
}

$qa_sql = "SELECT no, content, wdate FROM qa ORDER BY no DESC LIMIT 5";
$qa_result = mysqli_query($conn, $qa_sql);
$qas = [];
if ($qa_result) {
    while ($row = mysqli_fetch_assoc($qa_result)) {
        $qas[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>메인 페이지</title>
<style>
    .board  table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
    .board  th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
    .board th { background-color: #f4f4f4; }
    .board a { text-decoration: none; color:#000;} 
    .board a:hover { text-decoration: underline; }
</style>
</head>
<body>
<main style="padding: 20px;">
  <h1>메인 페이지에 오신 걸 환영합니다!</h1>
  <p>여기서 게시판과 Q&A, 회원 기능을 사용할 수 있어요.</p>

  <h2>최신 게시 5건</h2>
  <table class="board">
    <thead>
      <tr>
        <th>번호</th>
        <th>제목</th>
        <th>작성일</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($boards as $b): ?>
      <tr>
        <td><?= $b['no'] ?></td>
        <td><a href="/board/view?no=<?= $b['no'] ?>"><?= htmlspecialchars($b['subject']) ?></a></td>
        <td><?= $b['wdate'] ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h2>최신 Q&A 5건</h2>
  <table class="qa">
    <thead>
      <tr>
        <th>번호</th>
        <th>질문</th>
        <th>작성일</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($qas as $q): ?>
      <tr>
        <td><?= $q['no'] ?></td>
        <td><a href="/qa/view?no=<?= $q['no'] ?>"><?= htmlspecialchars($q['content']) ?></a></td>
        <td><?= $q['wdate'] ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
</body>
</html>
