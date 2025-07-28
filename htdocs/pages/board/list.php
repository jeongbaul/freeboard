<?php
date_default_timezone_set('Asia/Seoul');  
try {
    $pdo = new PDO("mysql:host=localhost;dbname=freeboard;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}

$search = $_GET['search'] ?? '';
$search_param = "%" . $search . "%";

$page = $_GET['page'] ?? 1;
$page = max(1, (int)$page);
$limit = 10;
$offset = ($page - 1) * $limit;

$count_sql = "SELECT COUNT(*) FROM board WHERE subject LIKE :search";
$count_stmt = $pdo->prepare($count_sql);
$count_stmt->bindParam(':search', $search_param, PDO::PARAM_STR);
$count_stmt->execute();
$total = $count_stmt->fetchColumn();

$total_pages = ceil($total / $limit);

$sql = "SELECT no, subject, writer, wdate FROM board 
        WHERE subject LIKE :search 
        ORDER BY no DESC 
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':search', $search_param, PDO::PARAM_STR);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="제목 검색" style="padding:5px; width:200px;">
    <button type="submit" class="btn">검색</button>
  </form>

  <div class="top-buttons" style="max-width:900px;">
    <button onclick="location.href='/pages/board/write.php'" class="btn">글쓰기</button>
  </div>

  <table>
    <thead>
      <tr>
        <th>순번</th>
        <th>제목</th>
        <th>작성자</th>
        <th>작성일</th>
        <th>관리</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($rows) > 0): ?>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?= $row['no'] ?></td>
            <td><a href="/pages/board/view.php?no=<?= $row['no'] ?>"><?= htmlspecialchars($row['subject']) ?></a></td>
            <td><?= htmlspecialchars($row['writer']) ?></td>
            <td><?= date("Y-m-d H:i:s", strtotime($row['wdate'])) ?></td>
            <td>
              <a href="/pages/board/modify.php?no=<?= $row['no'] ?>" class="btn">수정</a>
              <a href="/pages/board/delete.php?no=<?= $row['no'] ?>" class="btn">삭제</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">자유게시판을 이용해주세요.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <div class="pagination" style="max-width:900px;">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <?php if ($i == $page): ?>
        <strong><?= $i ?></strong>
      <?php else: ?>
        <a href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>

</body>
</html>
<button onclick="location.href='/'">메인페이지</button>
