<?php

$conn = mysqli_connect("localhost", "root", "", "freeboard");
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$sql = "SELECT id, name, level FROM member ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>회원 리스트</title>
  <style>
    table {
      border-collapse: collapse;
      width: 60%;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px 12px;
      text-align: center;
    }
    th {
      background-color: #eee;
    }
  </style>
</head>
<body>
  <h1>회원 리스트</h1>

  <table>
    <thead>
      <tr>
        <th>아이디</th>
        <th>이름</th>
        <th>레벨</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['level']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="3">회원이 없습니다.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
  
  <p><a href="/">메인페이지로 돌아가기</a></p>
</body>
</html>

<?php
mysqli_close($conn);
?>
