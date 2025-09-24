<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";

$search_type = $_GET['search_type'] ?? 'subject';
$search = $_GET['search'] ?? '';
$search_escaped = mysqli_real_escape_string($conn, $search);

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$where = "1";
if ($search !== '') {
    switch ($search_type) {
        case 'subject': $where = "subject LIKE '%$search_escaped%'"; break;
        case 'writer':  $where = "writer LIKE '%$search_escaped%'"; break;
        case 'content': $where = "content LIKE '%$search_escaped%'"; break;
        case 'all':     $where = "(subject LIKE '%$search_escaped%' OR content LIKE '%$search_escaped%')"; break;
        default:        $where = "subject LIKE '%$search_escaped%'"; 
    }
}

$count_sql = "SELECT COUNT(*) AS cnt FROM board WHERE $where";
$total = mysqli_fetch_assoc(mysqli_query($conn, $count_sql))['cnt'] ?? 0;
$total_pages = ceil($total / $limit);

$sql = "SELECT no, subject, writer, wdate FROM board WHERE $where ORDER BY no DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

$rows = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
}
?>

<h1>자유게시판</h1>

<form method="get" action="" class="search-form">
  <select name="search_type">
    <option value="subject" <?= $search_type=='subject' ? 'selected' : '' ?>>제목</option>
    <option value="writer" <?= $search_type=='writer' ? 'selected' : '' ?>>작성자</option>
    <option value="content" <?= $search_type=='content' ? 'selected' : '' ?>>내용</option>
    <option value="all" <?= $search_type=='all' ? 'selected' : '' ?>>제목+내용</option>
  </select>
  <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="검색어 입력">
  <button type="submit" class="btn">검색</button>
</form>

<a href="/board/write" class="btn">글쓰기</a>

<table>
  <thead>
    <tr>
      <th scope="col">순번</th>
      <th scope="col">제목</th>
      <th scope="col">작성자</th>
      <th scope="col">작성일</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($rows): ?>
      <?php foreach ($rows as $row): ?>
        <tr>
          <td><?= $row['no'] ?></td>
          <td><a href="/board/view?no=<?= $row['no'] ?>"><?= htmlspecialchars($row['subject']) ?></a></td>
          <td><?= htmlspecialchars($row['writer']) ?></td>
          <td><?= date("Y-m-d H:i:s", strtotime($row['wdate'])) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="4">자유게시판을 이용해주세요.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<div class="pagination">
  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <?php if ($i == $page): ?>
      <strong><?= $i ?></strong>
    <?php else: ?>
      <a href="?search_type=<?= $search_type ?>&search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
    <?php endif; ?>
  <?php endfor; ?>
</div>

<a href="/" class="btn">메인페이지</a>
