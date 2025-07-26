<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "freeboard");
    if ($conn->connect_error) {
        die("DB 연결 실패: " . $conn->connect_error);
    }

    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $pw = $_POST['pw'] ?? '';
    $level = 2;

    $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

    $sql = "INSERT INTO member (id, pw, name, level) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $id, $hashed_pw, $name, $level);
    $result = $stmt->execute();

    if ($result) {
        header("Location: /pages/user/join_ok.php");
        exit;
    } else {
        echo "회원가입 실패: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>회원가입</title>
</head>
<body>
  <h1>회원가입</h1>
  <form method="POST">
    ID: <input type="text" name="id" required><br>
    NAME: <input type="text" name="name" required><br>
    PW: <input type="password" name="pw" required><br>
    <button type="submit">회원가입</button>
  </form>
</body>
</html>
