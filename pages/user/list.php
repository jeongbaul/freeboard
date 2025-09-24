<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';
mysqli_set_charset($conn, "utf8mb4");

$sql = "SELECT id, name, level FROM member ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

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

<p><a class="back-link" href="/">메인페이지로 돌아가기</a></p>

<?php
mysqli_close($conn);
