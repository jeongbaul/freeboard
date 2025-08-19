<?php

if (!isset($_SESSION['user_id'])) {

    header("Location: /user/login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>로그인 성공</title>
</head>
<body>
  <h1>환영합니다, <?= htmlspecialchars($_SESSION['user_name']) ?>님!</h1>
  <p>로그인에 성공했습니다.</p>
  
  <p><a href="/">메인페이지로 이동</a></p>
</body>
</html>
