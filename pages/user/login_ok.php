<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /user/login");
    exit;
}
?>

<h1>환영합니다, <?= htmlspecialchars($_SESSION['user_name']) ?>님!</h1>
<p>로그인에 성공했습니다.</p>

<p><a href="/" class="back-link">메인페이지로 이동</a></p>
