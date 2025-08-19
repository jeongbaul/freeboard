<?php
$conn = mysqli_connect("localhost", "root", "", "freeboard");
if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id'] ?? '');
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $pw = $_POST['pw'] ?? '';
    $level = 2;

    if (!$id || !$name || !$pw) {
        die("모든 항목을 입력해주세요.");
    }
    $check_sql = "SELECT * FROM member WHERE id='$id'";
    $check_result = mysqli_query($conn, $check_sql);
    if(mysqli_num_rows($check_result) > 0){
        die("이미 존재하는 아이디입니다.");
    }
    
    $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

    $sql = "INSERT INTO member (id, pw, name, level) VALUES ('$id', '$hashed_pw', '$name', $level)";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('회원가입 성공! 로그인해주세요.'); location.href='/user/login';</script>";
        exit;
    } else {
        die("회원가입 실패: " . mysqli_error($conn));
    }
}

mysqli_close($conn);
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
