<?php
date_default_timezone_set('Asia/Seoul');

$conn = mysqli_connect("localhost", "root", "", "freeboard");
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$search_type = $_GET['search_type'] ?? 'subject';
$search = $_GET['search'] ?? '';
$search_escaped = mysqli_real_escape_string($conn, $search);

$page = $_GET['page'] ?? 1;
$page = max(1, (int)$page);
$limit = 10;
$offset = ($page - 1) * $limit;

$where = "1";
if ($search !== '') {
    switch ($search_type) {
        case 'subject':
            $where = "subject LIKE '%$search_escaped%'";
            break;
        case 'writer':
            $where = "writer LIKE '%$search_escaped%'";
            break;
        case 'content':
            $where = "content LIKE '%$search_escaped%'";
            break;
        case 'all':
            $where = "(subject LIKE '%$search_escaped%' OR content LIKE '%$search_escaped%')";
            break;
        default:
            $where = "subject LIKE '%$search_escaped%'";
    }
}

$count_sql = "SELECT COUNT(*) AS cnt FROM board WHERE $where";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total = $count_row['cnt'] ?? 0;

$total_pages = ceil($total / $limit);

$sql = "SELECT no, subject, writer, wdate, pw 
        FROM board 
        WHERE $where 
        ORDER BY no DESC 
        LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

$rows = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>자유게시판</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      max-width: 900px;
      margin-bottom: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #f4f4f4;
    }
    .btn {
      padding: 5px 10px;
      margin: 0 2px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      text-decoration: none;
      font-size: 0.9em;
    }
    .btn:hover {
      background-color: #0056b3;
    }
    .btn.disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }
    .pagination a {
      margin: 0 3px;
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }
    .pagination a:hover {
      text-decoration: underline;
    }
    .top-buttons {
      max-width: 900px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <h1>자유게시판</h1>

  <form method="get" action="" style="max-width:900px; margin-bottom:20px;">
    <select name="search_type" style="padding:5px;">
      <option value="subject" <?= $search_type=='subject' ? 'selected' : '' ?>>제목</option>
      <option value="writer" <?= $search_type=='writer' ? 'selected' : '' ?>>작성자</option>
      <option value="content" <?= $search_type=='content' ? 'selected' : '' ?>>내용</option>
      <option value="all" <?= $search_type=='all' ? 'selected' : '' ?>>제목+내용</option>
    </select>
    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="검색어 입력" style="padding:5px; width:200px;">
    <button type="submit" class="btn">검색</button>
  </form>

  <div class="top-buttons" style="max-width:900px;">
    <button onclick="location.href='/board/write'" class="btn">글쓰기</button>
  </div>

<table>
  <thead>
    <tr>
      <th>순번</th>
      <th>제목</th>
      <th>작성자</th>
      <th>작성일</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($rows) > 0): ?>
      <?php foreach ($rows as $row): ?>
        <tr>
          <td><?= $row['no'] ?></td>
          <td><a href="/board/view?no=<?= $row['no'] ?>"><?= htmlspecialchars($row['subject']) ?></a></td>
          <td><?= htmlspecialchars($row['writer']) ?></td>
          <td><?= date("Y-m-d H:i:s", strtotime($row['wdate'])) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="4">자유게시판을 이용해주세요.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>


  <div class="pagination" style="max-width:900px;">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <?php if ($i == $page): ?>
        <strong><?= $i ?></strong>
      <?php else: ?>
        <a href="?search_type=<?= $search_type ?>&search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>

  <button onclick="location.href='/'">메인페이지</button>
</body>
</html>
