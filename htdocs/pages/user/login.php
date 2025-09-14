<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';
mysqli_set_charset($conn, "utf8mb4");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $pw = $_POST['pw'] ?? '';

    $id_escaped = mysqli_real_escape_string($conn, $id);

    $sql = "SELECT * FROM member WHERE id = '$id_escaped'";
    $result = mysqli_query($conn, $sql);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($pw, $user['pw'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_level'] = $user['level'];

            mysqli_close($conn);
            header("Location: /user/login_ok");
            exit;
        } else {
            $error = "비밀번호가 일치하지 않습니다.";
        }
    } else {
        $error = "존재하지 않는 아이디입니다.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>로그인</title>
  <link rel="stylesheet" href="/css/index.css">
</head>
<body class="user-login-page">
  <h1>로그인</h1>

  <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>

  <form method="POST">
    <label>ID:</label>
    <input type="text" name="id" required><br>
    
    <label>PW:</label>
    <input type="password" name="pw" required><br>
    
    <button type="submit">로그인</button>
  </form>

  <p><a class="back-link" href="/">메인페이지로 돌아가기</a></p>
</body>
</html>
