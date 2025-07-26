<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>bu 갤러리</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
    }
    nav {
      background-color: #333;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
    }
    .nav-left, .nav-right {
      display: flex;
      gap: 15px;
    }
    a {
      color: white;
      text-decoration: none;
      padding: 8px 12px;
      border-radius: 4px;
    }
    a:hover {
      background-color: #555;
    }
  </style>
</head>
<body>

  <nav>
    <div class="nav-left">
      <a href="board_list.php">자유게시판</a>
      <a href="qna_list.php">Q&A</a>
    </div>
    <div class="nav-right">
      <a href="/pages/user/join.php">회원가입</a>
      <a href="/pages/user/login.php">로그인</a>
      <a href="/pages/user/list.php">회원 리스트</a>
    </div>
  </nav>

  <main style="padding: 20px;">
    <h1>메인 페이지에 오신 걸 환영합니다!</h1>
    <p>여기서 게시판과 Q&A, 회원 기능을 사용할 수 있어요.</p>
  </main>

</body>
</html>
