<?php
// تفعيل بدء الجلسة (Session) لحفظ تتبع دخول الطالب عبر الصفحات
session_start();

// إعدادات الاتصال بقاعدة البيانات (MySQL)
$host     = "localhost";
$db_user  = "root";      // اسم المستخدم الافتراضي في السيرفر المحلي
$db_pass  = "";          // كلمة المرور الافتراضية (تكون فارغة غالباً)
$db_name  = "alnashama_db"; // اسم قاعدة البيانات اللي رح تعمليها

// إنشاء الاتصال
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// فحص إذا كان هناك خطأ في الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// التأكد من أن البيانات قادمة عبر طريقة POST من صفحة الدخول
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // استقبال الرقم الجامعي وحمايته من ثغرات الـ SQL Injection
    $student_id = trim($_POST['student_id']);
    $student_id = mysqli_real_escape_string($conn, $student_id);

    if (!empty($student_id)) {
        
        // استعلام لفحص إذا كان الرقم الجامعي مسجل مسبقاً أم لا
        $check_query = "SELECT * FROM students WHERE student_id = '$student_id'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            // الطالب مسجل مسبقاً -> نقوم بتحديث وقت آخر دخول له تلقائياً
            $update_query = "UPDATE students SET login_time = NOW() WHERE student_id = '$student_id'";
            $conn->query($update_query);
        } else {
            // الطالب يدخل لأول مرة -> نقوم بإنشاء سجل جديد له وحفظ بياناته
            $insert_query = "INSERT INTO students (student_id) VALUES ('$student_id')";
            $conn->query($insert_query);
        }

        // حفظ الرقم الجامعي في الجلسة (Session) لاستخدامه في الصفحة الرئيسية لاحقاً
        $_SESSION['student_id'] = $student_id;

        // توجيه الطالب مباشرة إلى الصفحة الرئيسية بعد نجاح الدخول
        header("Location: home.html");
        exit();

    } else {
        echo "<script>alert('الرجاء إدخال الرقم الجامعي!'); window.location.href='index.html';</script>";
    }
}

$conn->close();
?>