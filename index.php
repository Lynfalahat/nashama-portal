<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['student_id'])) {
    header("Location: nashama.php");
    exit();
}

$host     = "localhost";
$db_user  = "root";
$db_pass  = "";
$db_name  = "nashama_db";

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

    if (!empty($student_id)) {
        $query = "SELECT * FROM students WHERE student_id = '$student_id'";
        $result = $conn->query($query);

        if ($result) {
            if ($result->num_rows > 0) {
                $student_data = $result->fetch_assoc();
                $_SESSION['student_id']   = $student_data['student_id'];
                $_SESSION['student_name'] = $student_data['student_id']; // استخدام الرقم كاسم مؤقت
            } else {
                $insert_query = "INSERT INTO students (student_id) VALUES ('$student_id')";
                if ($conn->query($insert_query) === TRUE) {
                    $_SESSION['student_id']   = $student_id;
                    $_SESSION['student_name'] = $student_id;
                } else {
                    $error_message = "❌ حدث خطأ أثناء تهيئة الحساب: " . $conn->error;
                    $conn->close();
                    return;
                }
            }
            
            header("Location: nashama.php");
            exit();
        } else {
            $error_message = "❌ خطأ في استعلام الفحص الدراسي: " . $conn->error;
        }
    } else {
        $error_message = "⚠️ الرجاء إدخال الرقم الجامعي!";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl" id="htmlPage">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى - تسجيل الدخول</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        body {
            background-image: url('zuj.jpg'); background-size: cover; background-position: center;
            background-repeat: no-repeat; background-attachment: fixed; min-height: 100vh;
            display: flex; justify-content: center; align-items: center; position: relative;
        }
        body::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.55); z-index: 1; }
        .login-container {
            background: #ffffff; width: 100%; max-width: 400px; padding: 40px 30px; border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15); border-top: 5px solid #b4031a; text-align: center; z-index: 2;
        }
        .login-logo { width: 85px; height: auto; margin-bottom: 15px; }
        .login-container h2 { color: #111111; font-size: 22px; font-weight: 700; margin-bottom: 5px; }
        .login-container p { color: #555555; font-size: 13px; margin-bottom: 30px; line-height: 1.5; }
        .form-group { text-align: right; margin-bottom: 25px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #222222; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 12px 15px; border: 1px solid #cccccc; border-radius: 8px; font-size: 14px; background-color: #ffffff; text-align: right; }
        .btn-login { width: 100%; padding: 12px; background-color: #111111; color: #ffffff; border: none; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; }
        .btn-login:hover { background-color: #b4031a; }
        .error-box { background-color: #ffebee; color: #c62828; padding: 10px; border-radius: 6px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid #ef9a9a; text-align: center; }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="logo.png" alt="شعار النشامى" class="login-logo">
        <h2>بوابة النشامى الرقمية</h2>
        <p>مرحباً بك في المنصة الأكاديمية الموحدة لطلبة جامعة الزيتونة</p>
        <?php if (!empty($error_message)): ?>
            <div class="error-box"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="student_id">الرقم الجامعي</label>
                <input type="text" id="student_id" name="student_id" class="form-control" placeholder="أدخل رقمك الجامعي" required autocomplete="off">
            </div>
            <button type="submit" class="btn-login">تسجيل الدخول الفوري 🚀</button>
        </form>
    </div>
</body>
</html>