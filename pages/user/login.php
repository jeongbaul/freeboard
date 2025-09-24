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

<h1>로그인</h1>

<?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>

<form method="POST">
    <p>
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required>
    </p>
    <p>
        <label for="pw">PW:</label>
        <input type="password" id="pw" name="pw" required>
    </p>
    <p>
        <button type="submit">로그인</button>
    </p>
</form>

<p><a class="back-link" href="/">메인페이지로 돌아가기</a></p>
