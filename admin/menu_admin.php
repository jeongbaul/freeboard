<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";

// 관리자 체크
if(!isset($_SESSION['user_level']) || $_SESSION['user_level'] != 1){
    echo "접근 권한이 없습니다.";
    exit;
}

// 메뉴 가져오기
$sql = "SELECT id, name, link FROM menu ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

$menus = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $menus[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>메뉴관리</title>
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
<h1>메뉴관리</h1>

<h2>메뉴 추가</h2>
<form method="post" action="menu_action.php">
    <input type="hidden" name="action" value="add">
    <input type="text" name="name" placeholder="메뉴명" required>
    <input type="text" name="link" placeholder="링크" required>
    <button type="submit">추가</button>
</form>

<h2>메뉴 리스트</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>메뉴명</th>
            <th>링크</th>
            <th>관리</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($menus as $menu): ?>
        <tr>
            <td><?= $menu['id'] ?></td>
            <td><?= htmlspecialchars($menu['name']) ?></td>
            <td><?= htmlspecialchars($menu['link']) ?></td>
            <td>
                <form method="post" action="menu_action.php" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $menu['id'] ?>">
                    <button type="submit" onclick="return confirm('삭제하시겠습니까?')">삭제</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
