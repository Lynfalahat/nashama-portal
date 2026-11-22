<?php
session_start();

// حماية الصفحة: منع الدخول بدون تسجيل دخول
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

// مصفوفة روابط نماذج الامتحانات الاستدراكية الحقيقية بناءً على مدخلاتك
$level_tests = [
    [
        'title' => 'نموذج امتحان اللغة الإنجليزية الاستدراكي',
        'desc' => 'نموذج أسئلة مقترح وشامل يحاكي الامتحان الفعلي لمستوى اللغة الإنجليزية لمساعدتك على اجتيازه بنجاح.',
        'url' => 'https://drive.google.com/file/d/1vUq9Nqeyc-ItFa4AVaC5YPsGVRP_CDX3/view',
        'icon' => '🇬🇧',
        'color' => '#0088cc'
    ],
    [
        'title' => 'نموذج امتحان اللغة العربية الاستدراكي',
        'desc' => 'تجميع لأهم القواعد والنصوص والنماذج المقترحة لامتحان الكفاءة في اللغة العربية (مهارات استدراكية).',
        'url' => 'https://drive.google.com/file/d/1pLxf-Vby5v3gRcIBuBzkm6MaJkwf8bYY/view',
        'icon' => '🇯🇴',
        'color' => '#2e7d32'
    ],
    [
        'title' => 'نموذج امتحان الحاسوب الاستدراكي',
        'desc' => 'دليل ونموذج أسئلة مهارات الحاسوب الأساسية والأنظمة لتضمن تخطي مادة حاسوب 99 بكل سهولة.',
        'url' => 'https://drive.google.com/file/d/1fkdMuaqn-xvXRi6pgaqjKffAKRPKQlJK/view',
        'icon' => '💻',
        'color' => '#b4031a'
    ]
];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى - نماذج امتحانات المستوى</title>
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

        .header-logo {
            width: 50px;
            height: auto;
        }

        .btn-back {
            color: #ffffff;
            background-color: #111111;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #b4031a;
        }

        main {
            max-width: 1000px;
            width: 90%;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .page-title {
            text-align: center;
            margin-bottom: 10px;
            color: #b4031a;
            font-size: 26px;
        }

        .page-subtitle {
            text-align: center;
            color: #666666;
            font-size: 14px;
            margin-bottom: 40px;
        }

        .tests-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .test-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 22px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .test-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.06);
        }

        .test-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .test-icon {
            font-size: 24px;
            background-color: #f9f9f9;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #eee;
        }

        .test-title {
            font-size: 15px;
            font-weight: 700;
            color: #111111;
            line-height: 1.4;
        }

        .test-desc {
            font-size: 13px;
            color: #666666;
            line-height: 1.6;
        }

        .btn-view {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #ffffff;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            transition: opacity 0.2s;
        }

        .btn-view:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <header>
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="logo.png" alt="شعار النشامى" class="header-logo">
            <span style="font-weight: 700;">بوابة النشامى الرقمية</span>
        </div>
        <a href="home.php" class="btn-back">رجوع للرئيسية</a>
    </header>

    <main>
        <h2 class="page-title">نماذج امتحانات المستوى الاستدراكية 📝</h2>
        <p class="page-subtitle">توفيراً لوقتكم وجهدكم، جمعنا لكم النماذج الرسمية المقترحة لامتحانات الكفاءة لتضمنوا اجتيازها والتعفي من مواد الاستدراكي (99).</p>

        <div class="tests-grid">
            <?php foreach ($level_tests as $test): ?>
                <div class="test-card" style="border-top: 4px solid <?php echo $test['color']; ?>;">
                    <div>
                        <div class="test-header">
                            <span class="test-icon"><?php echo $test['icon']; ?></span>
                            <div class="test-title"><?php echo $test['title']; ?></div>
                        </div>
                        <p class="test-desc" style="margin-top: 12px;"><?php echo $test['desc']; ?></p>
                    </div>
                    <a href="<?php echo $test['url']; ?>" target="_blank" class="btn-view" style="background-color: <?php echo $test['color']; ?>;">عرض النموذج (PDF) 👁️</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>