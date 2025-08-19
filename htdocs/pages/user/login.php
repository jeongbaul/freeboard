<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "freeboard");
    if (!$conn) {
        die("DB 연결 실패: " . mysqli_connect_error());
    }

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
</head>
<body>
  <h1>로그인</h1>

  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

  <form method="POST">
    ID: <input type="text" name="id" required><br>
    PW: <input type="password" name="pw" required><br>
    <button type="submit">로그인</button>
  </form>
</body>
</html>
