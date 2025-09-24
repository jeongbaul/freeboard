<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';
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

<h1>회원가입</h1>

<form method="POST">
    <p>
        <label for="id">ID</label>
        <input type="text" id="id" name="id" required>
    </p>
    <p>
        <label for="name">NAME</label>
        <input type="text" id="name" name="name" required>
    </p>
    <p>
        <label for="pw">PW</label>
        <input type="password" id="pw" name="pw" required>
    </p>
    <p>
        <button type="submit">회원가입</button>
    </p>
</form>
