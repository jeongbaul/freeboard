<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/db.php";
include_once $_SERVER['DOCUMENT_ROOT']."/common/header.php";

// 관리자만 접근
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] != 1){
    echo "<script>alert('관리자만 접근 가능합니다.'); location.href='/';</script>";
    exit;
}

$sql = "SELECT * FROM menu ORDER BY ord ASC";
$result = mysqli_query($conn, $sql);
$menus = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $menus[] = $row;
    }
}
?>

<h1>메뉴 관리</h1>

<form method="post" action="menu_action">
    <input type="hidden" name="action" value="add">
    <input type="text" name="title" placeholder="메뉴 이름" required>
    <input type="text" name="link" placeholder="메뉴 링크" required>
    <input type="number" name="ord" placeholder="순서" value="0">
    <button type="submit">등록</button>
</form>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>메뉴 이름</th>
            <th>링크</th>
            <th>순서</th>
            <th>관리</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($menus as $menu): ?>
        <tr>
            <td><?= $menu['id'] ?></td>
            <td><?= htmlspecialchars($menu['title']) ?></td>
            <td><?= htmlspecialchars($menu['link']) ?></td>
            <td><?= $menu['ord'] ?></td>
            <td>
                <a href="menu_action?action=delete&id=<?= $menu['id'] ?>" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
