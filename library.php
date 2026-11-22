<?php
session_start();

// حماية الصفحة: إذا لم يسجل الطالب دخوله يتم توجيهه لصفحة الدخول فوراً
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

// مصفوفة مواد متطلبات الجامعة مقسمة مادة بمادة لتضيفي لينكاتها برمجياً بكل سهولة
$university_materials = [
    // متطلبات إجبارية
    ['name' => 'العلوم العسكرية', 'desc' => 'الملخصات والكتيبات المعتمدة لمساق العلوم العسكرية.', 'url' => '#', 'icon' => '🪖'],
    ['name' => 'ثقافة إسلامية', 'desc' => 'الدراسات والتلخيصات الشاملة لمادة الثقافة الإسلامية.', 'url' => '#', 'icon' => '🕌'],
    ['name' => 'ثقافة وطنية', 'desc' => 'ملفات الشرح والأسئلة المقترحة لمساق التربية الوطنية.', 'url' => '#', 'icon' => '🇯🇴'],
    ['name' => 'ريادة وابتكار وقيادة', 'desc' => 'مادة مساق الريادة وبناء المشاريع والقيادة الطلابية.', 'url' => '#', 'icon' => '💡'],
    ['name' => 'مسؤولية مجتمعية', 'desc' => 'ملخصات مساق المسؤولية المجتمعية والعمل التطوعي.', 'url' => '#', 'icon' => '🤝'],
    ['name' => 'الاتصال والتواصل باللغة العربية', 'desc' => 'مهارات اللغة العربية، النحو، البلاغة، وفنون الاتصال.', 'url' => '#', 'icon' => '✍️'],
    ['name' => 'الاتصال والتواصل باللغة الإنجليزية', 'desc' => 'قواعد الاستيعاب والكتابة والمحادثة بالإنجليزية المعتمدة.', 'url' => '#', 'icon' => '🗣️'],
    
    // متطلبات اختيارية
    ['name' => 'مهارات حياتية', 'desc' => 'تطوير الذات، التفكير الإبداعي، وإدارة الوقت والأزمات.', 'url' => '#', 'icon' => '🌱'],
    ['name' => 'ثقافة رقمية', 'desc' => 'مفاهيم التكنولوجيا الحديثة، المواطنة الرقمية، والأمن السيبراني.', 'url' => '#', 'icon' => '🌐'],
    ['name' => 'رياضة وصحة', 'desc' => 'مفاهيم اللياقة البدنية، التغذية السليمة، والأنشطة الرياضية.', 'url' => '#', 'icon' => '🏃‍♂️'],
    ['name' => 'أساسيات علم نفس', 'desc' => 'مدخل إلى علم النفس السلوكي، التكيف النفسي، والصحة النفسية.', 'url' => '#', 'icon' => '🧠'],
    ['name' => 'إسعافات أولية', 'desc' => 'دليل الإجراءات الطبية الفورية والتعامل مع الحالات الطارئة.', 'url' => '#', 'icon' => '🚑'],
    ['name' => 'الحضارة الإنسانية', 'desc' => 'تاريخ وتطور الحضارات البشرية عبر العصور الإنسانية المختلفة.', 'url' => '#', 'icon' => '🏛️'],
    ['name' => 'التنمية والبيئة', 'desc' => 'قضايا الاستدامة، الحفاظ على البيئة، والموارد الطبيعية.', 'url' => '#', 'icon' => '🌳'],
    ['name' => 'أساسيات اللغة الألمانية', 'desc' => 'مبادئ وأساسيات المحادثة والقواعد البسيطة للغة الألمانية.', 'url' => '#', 'icon' => '🇩🇪'],
    ['name' => 'القانون في حياتنا', 'desc' => 'مدخل إلى الثقافة القانونية، الحقوق، والواجبات المدنية العامة.', 'url' => '#', 'icon' => '📜'],
    
    // مواد استدراكية
    ['name' => 'اللغة العربية الاستدراكية (99)', 'desc' => 'مساق علاجي لتمكين مهارات وقواعد اللغة العربية الأساسية.', 'url' => '#', 'icon' => '📖'],
    ['name' => 'اللغة الإنجليزية الاستدراكية (99)', 'desc' => 'مساق علاجي لتطوير أساسيات ومفردات اللغة الإنجليزية.', 'url' => '#', 'icon' => '🔤'],
    ['name' => 'مهارات الحاسوب الاستدراكية (99)', 'desc' => 'مبادئ تشغيل الحاسوب والتعامل مع برمجيات المكتب الأساسية.', 'url' => '#', 'icon' => '🖥️']
];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى - المكتبة الرقمية للمتطلبات</title>
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
            max-width: 1100px;
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

        /* شبكة عرض المواد مادة بمادة */
        .materials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .material-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            border-top: 4px solid #b4031a;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .material-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
        }

        .material-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .material-icon {
            font-size: 24px;
            background-color: #f9f9f9;
            padding: 6px;
            border-radius: 6px;
            border: 1px solid #eee;
        }

        .material-name {
            font-size: 15px;
            font-weight: 700;
            color: #111111;
            line-height: 1.4;
        }

        .material-desc {
            font-size: 13px;
            color: #666666;
            line-height: 1.6;
        }

        .btn-download {
            display: block;
            text-align: center;
            text-decoration: none;
            background-color: #111111;
            color: #ffffff;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            transition: background-color 0.3s;
        }

        .btn-download:hover {
            background-color: #b4031a;
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
        <h2 class="page-title">المكتبة الرقمية لمتطلبات الجامعة ✨</h2>
        <p class="page-subtitle">تصفح مواد متطلبات الجامعة الإجبارية والاختيارية بشكل منفصل، واحصل على كافة الملفات والشروحات الخاصة بكل مساق.</p>

        <div class="materials-grid">
            <?php foreach ($university_materials as $material): ?>
                <div class="material-card">
                    <div>
                        <div class="material-header">
                            <span class="material-icon"><?php echo $material['icon']; ?></span>
                            <div class="material-name"><?php echo $material['name']; ?></div>
                        </div>
                        <p class="material-desc" style="margin-top: 10px;"><?php echo $material['desc']; ?></p>
                    </div>
                    <a href="<?php echo $material['url']; ?>" target="_blank" class="btn-download">تصفح ملفات المادة 📥</a>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

</body>
</html>