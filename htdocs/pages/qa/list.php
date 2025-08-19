<?php
include $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';

$sql = "SELECT no, name, id, subject, content, reply, wdate FROM qa ORDER BY wdate DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Q&A 목록</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        a { text-decoration: none; color: blue; }
        .write-btn { margin-bottom: 15px; display: inline-block; padding: 8px 12px; background-color: #4CAF50; color: white; border-radius: 4px; }
        .write-btn:hover { background-color: #45a049; }
        .delete-btn { color: red; margin-left: 10px; }
        .reply-complete { background-color: #e0f7e9; }
    </style>
</head>
<body>

<h1>Q&A 보기</h1>

<?php if(isset($_SESSION['user_id'])): ?>
    <a href="/qa/write" class="write-btn">문의 작성</a>
<?php else: ?>
    <p>문의 작성을 위해 <a href="/user/login">로그인</a> 해주세요.</p>
<?php endif; ?>

<table>
    <tr>
        <th>번호</th>
        <th>작성자</th>
        <th>문의 제목</th>
        <th>문의 내용 / 관리</th>
    </tr>

    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $hasReply = !empty($row['reply']);
            $rowClass = $hasReply ? "class='reply-complete'" : "";

            echo "<tr $rowClass>";
            echo "<td>".$row['no']."</td>";
            echo "<td>".htmlspecialchars($row['name'])."</td>";
            echo "<td><a href='/qa/view?no=".$row['no']."'>".htmlspecialchars($row['subject'])."</a></td>";

            echo "<td>";
            echo nl2br(htmlspecialchars($row['content']));
            
            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['id']){
                echo " <a href='/qa/delete?no=".$row['no']."' class='delete-btn' onclick=\"return confirm('정말 삭제하시겠습니까?');\">[삭제]</a>";
            }

            if($hasReply){
                echo "<br><strong style='color:green;'>[답변 완료]</strong>";
            }

            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>등록된 질문이 없습니다.</td></tr>";
    }
    ?>
</table>

</body>
</html>
