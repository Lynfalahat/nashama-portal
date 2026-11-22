<?php
session_start();
require_once 'db.php'; // <--- هنا يوضع الكود الثاني

// بقية كود الصفحة...
?>

<?php
// تفعيل أعلى درجات إظهار الأخطاء عشان السيرفر يكتبلنا شو المشكلة بدل الشاشة البيضاء
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// حماية الصفحة: إذا لم يسجل الطالب دخوله يتم توجيهه لصفحة الدخول فوراً
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$host     = "localhost";
$db_user  = "root";
$db_pass  = "";
$db_name  = "nashama_db";

$success_msg = "";
$error_msg   = "";

// معالجة وحفظ الاقتراح أو الشكوى بقاعدة البيانات
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_suggestion'])) {
    $conn = new mysqli($host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");

    $student_id   = $_SESSION['student_id']; 
    $student_name = isset($_POST['student_name']) ? mysqli_real_escape_string($conn, $_POST['student_name']) : '';
    $msg_type     = isset($_POST['msg_type']) ? mysqli_real_escape_string($conn, $_POST['msg_type']) : '';
    $message      = isset($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : '';

    if (!empty($msg_type) && !empty($message)) {
        $query = "INSERT INTO suggestions (student_id, student_name, msg_type, message) 
                  VALUES ('$student_id', '$student_name', '$msg_type', '$message')";
        
        if ($conn->query($query) === TRUE) {
            $success_msg = "✅ تم إرسال رسالتك بنجاح لقائمة النشامى! شغالين على متابعتها فوراً.";
        } else {
            $error_msg = "❌ عذراً، حدث خطأ أثناء الإرسال: " . $conn->error;
        }
    } else {
        $error_msg = "⚠️ الرجاء ملء الحقول المطلوبة!";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى الرقمية - الصفحة الرئيسية</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #111111;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #b4031a;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-logo {
            width: 60px;
            height: auto;
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            color: #111111;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .student-info {
            font-size: 14px;
            font-weight: 600;
            color: #666666;
            background-color: #f8f9fa;
            padding: 6px 12px;
            border-radius: 20px;
            border: 1px solid #e0e0e0;
        }

        .btn-logout {
            color: #ffffff;
            background-color: #b4031a;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #900214;
        }

        main {
            max-width: 1200px;
            width: 90%;
            margin: 40px auto;
            flex: 1;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .welcome-section h1 {
            font-size: 28px;
            color: #111111;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #666666;
            font-size: 15px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            padding: 30px 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-bottom: 4px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(180, 3, 26, 0.1);
            border-bottom-color: #b4031a;
        }

        .card-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .card h3 {
            font-size: 18px;
            font-weight: 700;
            color: #111111;
            margin-bottom: 12px;
        }

        .card p {
            font-size: 13px;
            color: #666666;
            line-height: 1.6;
            margin-bottom: 20px;
            flex: 1;
        }

        .card-btn {
            display: inline-block;
            background-color: #111111;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .card-btn:hover {
            background-color: #b4031a;
        }

        footer {
            background-color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #888888;
            border-top: 1px solid #eeeeee;
            margin-top: auto;
        }

        /* ==================== ستايل صندوق الشكاوى والاقتراحات الفخم ==================== */

/* عنوان القسم */
.home-section-title {
    font-size: 19px;
    font-weight: 700;
    color: #b4031a;
    margin: 45px 0 20px 0;
    border-right: 4px solid #b4031a;
    padding-right: 12px;
    text-align: right;
}

/* الحاوية الرئيسية للفورم */
.form-container {
    background-color: #fafafa;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 35px 30px;
    margin-top: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
}

/* تنظيم الصفوف */
.form-row {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
    margin-bottom: 22px;
}

/* تنظيم الأعمدة */
.form-col {
    flex: 1;
    min-width: 260px;
}

/* بوكس المجموعة */
.form-group-box {
    display: flex;
    flex-direction: column;
    text-align: right;
}

/* استايل العناوين الصغيرة (Labels) */
.form-group-box label {
    font-size: 13.5px;
    font-weight: 600;
    color: #333333;
    margin-bottom: 8px;
}

/* استايل حقول الإدخال، القائمة المنسدلة، ونص الرسالة */
.form-input-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #cccccc;
    border-radius: 8px;
    font-size: 14px;
    background-color: #ffffff;
    color: #111111;
    text-align: right;
    outline: none;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* تأثير التفاعل عند النقر بداخل الحقل (Focus) */
.form-input-control:focus {
    border-color: #b4031a;
    box-shadow: 0 0 0 3px rgba(180, 3, 26, 0.1);
}

/* تخصيص الـ Textarea لمنع التمدد الأفقي وتخريب التناسق */
textarea.form-input-control {
    resize: vertical;
    min-height: 110px;
    line-height: 1.6;
}

/* ستايل زر الإرسال الفخم */
.btn-submit-suggestion {
    background-color: #111111;
    color: #ffffff;
    border: none;
    padding: 12px 35px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
}

/* تأثير مرور الماوس فوق زر الإرسال */
.btn-submit-suggestion:hover {
    background-color: #b4031a;
    box-shadow: 0 5px 15px rgba(180, 3, 26, 0.2);
}

/* تأثير كبسة الماوس (اضغط) */
.btn-submit-suggestion:active {
    transform: scale(0.98);
}

/* استايل تنبيهات النجاح أو الفشل (Alerts) */
.alert-box {
    padding: 14px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 25px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
}

/* في حال النجاح */
.alert-success {
    background-color: #e8f5e9;
    color: #2e7d32;
    border: 1px solid #a5d6a7;
}

/* في حال الفشل أو نقص الحقول */
.alert-danger {
    background-color: #ffebee;
    color: #c62828;
    border: 1px solid #ef9a9a;
}
    </style>
</head>
<body>

    <header>
        <div class="header-right">
            <img src="logo.png" alt="شعار النشامى" class="header-logo">
            <span class="header-title">بوابة النشامى الرقمية</span>
        </div>
        <div class="header-left">
            <<div>
    الرقم الجامعي: <?php echo htmlspecialchars($_SESSION['student_id']); ?>
</div>
            <a href="logout.php" class="btn-logout">تسجيل الخروج</a>
        </div>
    </header>

    <main>
        <section class="welcome-section">
            <h1>أهلاً بك في بوابة النشامى 🌟</h1>
            <p>منصتك الطلابية الشاملة لتسهيل رحلتك الجامعية بكفاءة وسرعة.</p>
        </section>

        <section class="services-grid">
            
            <div class="card">
                <div>
                    <div class="card-icon">📖</div>
                    <h3>دليل الطالب</h3>
                    <p>كل ما تود معرفته عن الأنظمة الجامعية، الخطة الدراسية، وكيفية حساب المعدلات الأكاديمية.</p>
                </div>
                <a href="guide.php" class="card-btn">تصفح الدليل</a>
            </div>

            <div class="card">
                <div>
                    <div class="card-icon">🏛️</div>
                    <h3>مجموعات الكليات</h3>
                    <p>روابط مباشرة لمجموعات الكليات، التخصصات، السنافر، وامتحانات المستوى لتبقى على اطلاع.</p>
                </div>
                <a href="groups.php" class="card-btn">دخول المجموعات</a>
            </div>

            <div class="card">
    <div class="card-icon" style="background-color: #fff3cd; color: #ffc107;">📝</div>
    <h3>امتحانات المستوى الاستدراكية</h3>
    <p>تصفح النماذج الرسمية والمقترحة لامتحانات الكفاءة (عربي، إنجليزي، حاسوب) للتعفي من مواد 99.</p>
    <a href="placement_tests.php" class="card-btn">عرض النماذج المقترحة 👁️</a>
</div>

            <div class="card">
                <div>
                    <div class="card-icon">📂</div>
                    <h3>المكتبة الرقمية</h3>
                    <p>بنك متكامل يحتوي على التلاخيص، أسئلة السنوات السابقة، والدفاتر الدراسية لكل كلية.</p>
                </div>
                <a href="library.php" class="card-btn">دخول المكتبة</a>
            </div>

            <div class="card">
                <div>
                    <div class="card-icon">🚌</div>
                    <h3>المواصلات الجامعية</h3>
                    <p>دليلك الكامل لقروبات الباصات، الجولات اليومية، ومسارات النقل لتسهيل حركتك وتنقلك للجامعة.</p>
                </div>
                <a href="transport.php" class="card-btn">استكشف المواصلات</a>
            </div>

            <div class="card">
    <div class="card-icon" style="background-color: #e8f5e9; color: #2e7d32;">🌐</div>
    <h3>روابط سريعة تهمك</h3>
    <p>وصول مباشر للمنظومة، التعليم الإلكتروني، ومواقع الجامعة الرسمية بضغطة زر.</p>
    <a href="links.php" class="card-btn">تصفح الروابط 🔗</a>
</div>


<div class="card">
    <div class="card-icon" style="background-color: #e1f5fe; color: #0288d1;">🏢</div>
    <h3>دليل المباني وفك شفرة القاعة</h3>
    <p>تعرّف على أرقام مباني الكليات داخل الحرم الجامعي الجديد، وتعلّم طريقة قراءة رمز قاعتك من جدولك الدراسي بسهولة.</p>
    <a href="buildings_guide.php" class="card-btn">تصفح دليل القاعات 🧭</a>
</div>

<div class="card">
    <div class="card-icon" style="background-color: #e8f5e9; color: #388e3c;">🗺️</div>
    <h3>خريطة الجامعة والموقع الجغرافي</h3>
    <p>تصفح المخطط الكروكي الشامل لكافة مباني كليات الزيتونة، واحصل على رابط الموقع المباشر للحرم الجامعي على Google Maps.</p>
    <a href="campus_map.php" class="card-btn">عرض الخريطة والموقع 📍</a>
</div>
        </section>

         <!-- 📝 صندوق الشكاوى والاقتراحات الطلابي المدمج بأسفل الكروت مباشرة 📝 -->
        <div class="home-section-title">📝 صندوق الشكاوى والاقتراحات الطلابية المباشر</div>
        <div class="form-container">
            
            <!-- تنبيهات حالة الإرسال والداتابيز -->
            <?php if (!empty($success_msg)): ?>
                <div class="alert-box alert-success"><?php echo $success_msg; ?></div>
            <?php elseif (!empty($error_msg)): ?>
                <div class="alert-box alert-danger"><?php echo $error_msg; ?></div>
            <?php endif; ?>

            <form action="home.php" method="POST">
                <div class="form-row">
                    <!-- حقل الاسم (اختياري لسرية الهوية) -->
                    <div class="form-col">
                        <div class="form-group-box">
                            <label for="student_name">الاسم الكريم (اختياري)</label>
                            <input type="text" id="student_name" name="student_name" class="form-input-control" placeholder="أدخل اسمك أو اتركه فارغاً لسرية الهوية">
                        </div>
                    </div>
                    <!-- حقل اختيار نوع الرسالة -->
                    <div class="form-col">
                        <div class="form-group-box">
                            <label for="msg_type">نوع الرسالة *</label>
                            <select id="msg_type" name="msg_type" class="form-input-control" required>
                                <option value="" disabled selected>اختر النوع...</option>
                                <option value="اقتراح">💡 اقتراح تطويري</option>
                                <option value="شكوى">⚠️ شكوى أكاديمية / خدمية</option>
                                <option value="أخرى">💬 استفسار آخر</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- نص الرسالة -->
                <div class="form-row" style="margin-bottom: 15px;">
                    <div class="form-col">
                        <div class="form-group-box">
                            <label for="message">تفاصيل الشكوى أو الاقتراح *</label>
                            <textarea id="message" name="message" class="form-input-control" rows="4" placeholder="اكتب تفاصيل اقتراحك أو مشكلتك هنا لتصل لممثلي قائمة النشامى..." required></textarea>
                        </div>
                    </div>
                </div>

                <div style="text-align: left;">
                    <button type="submit" name="submit_suggestion" class="btn-submit-suggestion">إرسال الرسالة للنشامى 🚀</button>
                </div>
            </form>
       
  
    </main>

    <footer>
        <p>قول , فعل , إنجاز | جميع الحقوق محفوظة © 2026</p>
    </footer>

</body>
</html>