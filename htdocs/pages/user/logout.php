<?php
session_start();
session_destroy(); // 세션 전체 삭제
header("Location: /"); // 메인 페이지로 이동
exit;
