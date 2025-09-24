<?php
session_start();    
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>BU 갤러리</title>
  <link rel="stylesheet" href="/index.css">
  <style>
    body { font-family: Arial, sans-serif; margin: 0; }
    nav { background-color: #333; display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; }
    .nav-left, .nav-right { display: flex; gap: 15px; }
    a { color: white; text-decoration: none; padding: 8px 12px; border-radius: 4px; }
    a:hover { background-color: #555; }
    span { color: white; }
  </style>
</head>
<body>
<nav>
    <div class="nav-left">
        <a href="/">Home</a>
        <a href="/board/list">Free board</a>
        <a href="/qa/list">Q&A</a>
        <a href="/admin/menu_admin">메뉴관리</a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/user/list">Member list</a>
        <?php endif; ?>
    </div>
    <div class="nav-right">
        <?php if(isset($_SESSION['user_id'])): ?>
            <span><?= htmlspecialchars($_SESSION['user_id']) ?> 님 환영합니다!</span>
            <a href="/user/logout">로그아웃</a>
        <?php else: ?>
            <a href="/user/join">회원가입</a>
            <a href="/user/login">로그인</a>
        <?php endif; ?>
    </div>
</nav>
