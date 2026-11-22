<?php
session_start();
session_unset();
session_destroy();

// التوجيه الفوري لصفحة تسجيل الدخول بعد تصفير المتصفح
header("Location: index.php");
exit();