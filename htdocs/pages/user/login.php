<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "freeboard");
    if ($conn->connect_error) {
        die("DB 연결 실패: " . $conn->connect_error);
    }

    $id = $_POST['id'] ?? '';
    $pw = $_POST['pw'] ?? '';

    $sql = "SELECT * FROM member WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($pw, $user['pw'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_level'] = $user['level'];

            header("Location: /pages/user/login_ok.php");
            exit;
        } else {
            $error = "비밀번호가 일치하지 않습니다.";
        }
    } else {
        $error = "존재하지 않는 아이디입니다.";
    }

    $conn->close();
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
