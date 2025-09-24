<?php
session_start();    
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>BU 갤러리</title>
  <link rel="stylesheet" href="/css/index.css">
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
