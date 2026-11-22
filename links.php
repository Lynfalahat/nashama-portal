<?php
session_start();

// حماية الصفحة: منع الدخول بدون تسجيل مسجل
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

// مصفوفة الروابط الرسمية والشاملة لجامعة الزيتونة بناءً على مدخلاتك الحقيقية
$important_links = [
    [
        'title' => 'بوابة الطالب الإلكترونية (Portal)',
        'desc' => 'تنزيل المواد، السحب والإضافة، عرض كشف العلامات، والخطة الدراسية عبر المتصفح.',
        'url' => 'https://portal.zuj.edu.jo/',
        'icon' => '🌐',
        'color' => '#b4031a',
        'app_links' => [
            ['platform' => 'تطبيق الآيفون (iOS)', 'link_url' => 'https://apps.apple.com/app/id1600035356']
        ]
    ],
    [
        'title' => 'منصة التعليم الإلكتروني (e-Learning)',
        'desc' => 'متابعة المحاضرات، حل الواجبات، وتقديم الكويزات والامتحانات الإلكترونية للمساقات.',
        'url' => 'https://elearning.zuj.edu.jo/',
        'icon' => '💻',
        'color' => '#0088cc',
        'app_links' => [
            ['platform' => 'تطبيق الآيفون (iOS)', 'link_url' => 'https://apps.apple.com/app/id1572102799'],
            ['platform' => 'تطبيق الأندرويد (Android)', 'link_url' => 'https://bit.ly/3zYIffs']
        ]
    ],
    [
        'title' => 'منصة المحاضرات المرئية (Zoom)',
        'desc' => 'البرنامج المعتمد لحضور المحاضرات التفاعلية والاجتماعات وعروض مشاريع التخرج عن بُعد.',
        'url' => 'https://apps.apple.com/app/id546505307',
        'icon' => '🎥',
        'color' => '#2d8cff',
        'app_links' => [
            ['platform' => 'تطبيق الآيفون والملحقات', 'link_url' => 'https://apps.apple.com/app/id546505307']
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى - الروابط الهامة والمنصات</title>
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

        .links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .link-card {
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

        .link-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.06);
        }

        .link-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .link-icon {
            font-size: 24px;
            background-color: #f9f9f9;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #eee;
        }

        .link-title {
            font-size: 16px;
            font-weight: 700;
            color: #111111;
        }

        .link-desc {
            font-size: 13px;
            color: #666666;
            line-height: 1.6;
            margin-top: 10px;
        }

        .apps-section {
            margin-top: 15px;
            background-color: #fafafa;
            padding: 12px;
            border-radius: 6px;
            border: 1px dashed #ddd;
        }

        .apps-section h4 {
            font-size: 12px;
            color: #555;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .app-buttons-container {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .app-link {
            display: block;
            text-align: center;
            text-decoration: none;
            background-color: #111111;
            color: #ffffff;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .app-link:hover {
            background-color: #b4031a;
        }

        .btn-visit {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #ffffff;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            transition: opacity 0.2s;
            margin-top: 10px;
        }

        .btn-visit:hover {
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
        <h2 class="page-title">المنصات والروابط الرسمية 🌐</h2>
        <p class="page-subtitle">تجميع ذكي لكافة روابط البوابات الإلكترونية وتطبيقات الهواتف الذكية المعتمدة للجامعة.</p>

        <div class="links-grid">
            <?php foreach ($important_links as $item): ?>
                <div class="link-card" style="border-top: 4px solid <?php echo $item['color']; ?>;">
                    <div>
                        <div class="link-header">
                            <span class="link-icon"><?php echo $item['icon']; ?></span>
                            <div class="link-title"><?php echo $item['title']; ?></div>
                        </div>
                        <p class="link-desc"><?php echo $item['desc']; ?></p>
                        
                        <div class="apps-section">
                            <h4>📱 تحميل تطبيقات الهواتف الذكية:</h4>
                            <div class="app-buttons-container">
                                <?php foreach ($item['app_links'] as $app): ?>
                                    <a href="<?php echo $app['link_url']; ?>" target="_blank" class="app-link">
                                        <?php echo $app['platform']; ?> 📥
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?php echo $item['url']; ?>" target="_blank" class="btn-visit" style="background-color: <?php echo $item['color']; ?>;">دخول المنصة عبر المتصفح 🔗</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>