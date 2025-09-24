<?php
include $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';

$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $perPage;

$countSql = "SELECT COUNT(*) as cnt FROM qa";
$countResult = mysqli_query($conn, $countSql);
$totalRows = ($countResult) ? mysqli_fetch_assoc($countResult)['cnt'] : 0;
$totalPages = ceil($totalRows / $perPage);

$sql = "SELECT no, name, id, subject, content, reply, wdate 
        FROM qa 
        ORDER BY wdate DESC 
        LIMIT $perPage OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<h1>Q&A 목록</h1>

<?php if(isset($_SESSION['user_id'])): ?>
    <a href="/qa/write" class="btn write-btn">문의 작성</a>
<?php else: ?>
    <p>문의 작성을 위해 <a href="/user/login">로그인</a> 해주세요.</p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>번호</th>
            <th>작성자</th>
            <th>문의 제목</th>
            <th>문의 내용 / 관리</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $hasReply = !empty($row['reply']);
            $rowClass = $hasReply ? "reply-complete" : "";

            echo "<tr class='$rowClass'>";
            echo "<td>".$row['no']."</td>";
            echo "<td>".htmlspecialchars($row['name'])."</td>";
            echo "<td><a href='/qa/view?no=".$row['no']."'>".htmlspecialchars($row['subject'])."</a></td>";

            echo "<td>";
            echo nl2br(htmlspecialchars($row['content']));

            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['id']){
                echo " <a href='/qa/delete?no=".$row['no']."' class='delete-btn' onclick=\"return confirm('정말 삭제하시겠습니까?');\">[삭제]</a>";
            }

            if($hasReply){
                echo "<br><strong class='reply-label'>[답변 완료]</strong>";
            }

            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>등록된 질문이 없습니다.</td></tr>";
    }
    ?>
    </tbody>
</table>

<div class="pagination">
    <?php
    if ($totalPages > 1) {
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = ($i == $page) ? "active" : "";
            echo "<a href='?page=$i' class='$active'>$i</a>";
        }
    }
    ?>
</div>
