<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$host     = "sql104.infinityfree.com";
$db_user  = "if0_42640633";      
$db_pass  = "Lyn2005ibraheem";          
$db_name  = "if0_42640633_Nashama"; 


$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");


// دالة مسبقة لجلب مجموعات التخصصات والسنافر والكتب
function getGroups($conn, $category, $faculty = null) {
    if ($faculty) {
        $query = "SELECT * FROM academic_groups WHERE group_category = '$category' AND faculty_name = '$faculty'";
    } else {
        $query = "SELECT * FROM academic_groups WHERE group_category = '$category'";
    }
    return $conn->query($query);
}

$faculties = [
    'it' => 'كلية تكنولوجيا المعلومات',
    'business' => 'كلية الأعمال',
    'pharmacy' => 'كلية الصيدلة',
    'nursing' => 'كلية التمريض',
    'therapy' => 'كلية العلاج الطبيعي',
    'law' => 'كلية الحقوق',
    'arts' => 'كلية الآداب'
];


// أضيفي هذه المصفوفة تحت $faculties مباشرة وضعي الرابط بين العبارتين ' '
$sanfur_links = [
    'nursing'  => ['name' => 'جروب سنافر التمريض', 'link' => 'https://chat.whatsapp.com/GtwINok7EKjLeWMmXKLc7G?s=hd&p=i&mlu=4'],
    'pharmacy' => ['name' => 'جروب سنافر الصيدلة', 'link' => 'https://chat.whatsapp.com/Ccp1ZounUEYEIGxKmfaHID?s=cl&p=i&mlu=4'],
    'arts'     => ['name' => 'جروب سنافر الآداب', 'link' => 'https://chat.whatsapp.com/GeH2QTSpFDqKMu2xyVKpq4?s=hd&p=i&mlu=4'],
    'therapy'  => ['name' => 'جروب سنافر العلاج الطبيعي', 'link' => 'https://chat.whatsapp.com/Cpnqsk5vZVZBx24q7Zozi1?s=hd&p=i&mlu=4'],
    'law'      => ['name' => 'جروب سنافر الحقوق', 'link' => 'https://chat.whatsapp.com/GkCF6Ws3xykLmP759mCSon?s=hd&p=i&mlu=4'],
    'science'  => ['name' => 'جروب سنافر العلوم', 'link' => 'https://chat.whatsapp.com/H8NqxyhCGlrH3tlCnQuoEo?s=cl&p=i&mlu=4']
];

// مصفوفة تحتوي على كافة المواد التي ذكرتيها بالتفصيل لتنظيم العرض
$uni_categories = [
    'compulsory' => [
        'title' => 'المتطلبات الإجبارية',
        'subjects' => ['العلوم العسكرية', 'ثقافة إسلامية', 'ريادة وابتكار وقيادة', 'مسؤولية مجتمعية', 'وطنية', 'الاتصال والتواصل باللغة العربية', 'الاتصال والتواصل باللغة الإنجليزية']
    ],
    'elective' => [
        'title' => 'المتطلبات الاختيارية',
        'subjects' => ['ثقافة رقمية', 'مهارات حياتية', 'رياضة وصحة', 'أساسيات علم نفس', 'إسعافات أولية', 'الحضارة الانسانية', 'التنمية والبيئة', 'اساسيات اللغة الألمانية', 'القانون في حياتنا']
    ],
    'remedial' => [
        'title' => 'المواد الاستدراكية (99)',
        'subjects' => ['اللغة العربية الاستدراكية', 'اللغة الانجليزية الاستدراكية', 'مهارات الحاسوب الاستدراكية']
    ]
];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى - مجموعات وقنوات التواصل</title>
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
            margin-bottom: 30px;
            color: #b4031a;
            font-size: 26px;
        }

        .tabs-container {
            display: flex;
            justify-content: center;
            border-bottom: 2px solid #eeeeee;
            margin-bottom: 30px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 20px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            background: none;
            border: none;
            color: #666666;
            position: relative;
            transition: color 0.3s ease;
        }

        .tab-btn:hover {
            color: #b4031a;
        }

        .tab-btn.active {
            color: #b4031a;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #b4031a;
            border-radius: 3px;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .tab-content.active {
            display: block;
        }

        .faculty-section {
            margin-bottom: 35px;
            background-color: #fafafa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #eaeaea;
        }

        .faculty-title {
            font-size: 17px;
            font-weight: 700;
            color: #111111;
            margin-bottom: 15px;
            border-right: 4px solid #b4031a;
            padding-right: 10px;
        }

        /* تنسيق كارد المادة المخصصة للمتطلبات */
        .subject-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .subject-name {
            font-size: 16px;
            font-weight: 700;
            color: #b4031a;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sections-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
        }

        .section-item {
            background-color: #f8f9fa;
            border: 1px solid #edeec4;
            padding: 12px 15px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-right: 4px solid #111111;
        }

        .section-item h5 {
            font-size: 13px;
            color: #333333;
            font-weight: 600;
        }

        .groups-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 15px;
        }

        .group-item {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .group-info h4 {
            font-size: 14px;
            color: #333333;
            font-weight: 600;
        }

        .group-link-btn {
            background-color: #25d366;
            color: #ffffff;
            text-decoration: none;
            padding: 7px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            transition: background-color 0.3s;
            white-space: nowrap;
        }

        .group-link-btn:hover {
            background-color: #128c7e;
        }

        .book-btn { background-color: #111111; }
        .book-btn:hover { background-color: #b4031a; }

        .uni-btn { background-color: #0088cc; }
        .uni-btn:hover { background-color: #006699; }

        .no-data {
            color: #999999;
            font-size: 13px;
            font-style: italic;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
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
        <h2 class="page-title">بوابة المجموعات والروابط الطلابية</h2>

        <div class="tabs-container">
            <button class="tab-btn active" onclick="openTab(event, 'spec-tab')">مجموعات التخصصات</button>
            <button class="tab-btn" onclick="openTab(event, 'sanfur-tab')">مجموعات السنافر 👶</button>
            <button class="tab-btn" onclick="openTab(event, 'books-tab')">قروبات تبادل الكتب 📚</button>
            <button class="tab-btn" onclick="openTab(event, 'uni-tab')">متطلبات الجامعة 🏛️</button>
        </div>

        <div id="spec-tab" class="tab-content active">
            <?php foreach ($faculties as $key => $name): ?>
                <div class="faculty-section">
                    <div class="faculty-title"><?php echo $name; ?></div>
                    <div class="groups-list">
                        <?php 
                        $groups = getGroups($conn, 'specialization', $key);
                        if ($groups->num_rows > 0): 
                            while($row = $groups->fetch_assoc()):
                        ?>
                            <div class="group-item">
                                <div class="group-info"><h4><?php echo htmlspecialchars($row['group_name']); ?></h4></div>
                                <a href="<?php echo htmlspecialchars($row['group_link']); ?>" target="_blank" class="group-link-btn">انضم للقروب 💬</a>
                            </div>
                        <?php 
                            endwhile; 
                        else: 
                        ?>
                            <p class="no-data">لا توجد قروبات مضافة حالياً لهذه الكلية.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="sanfur-tab" class="tab-content">
    <?php foreach ($faculties as $key => $name): ?>
        <div class="faculty-section">
            <div class="faculty-title">سنافر - <?php echo $name; ?></div>
            <div class="groups-list">
                <?php if (array_key_exists($key, $sanfur_links)): ?>
                    <div class="group-item">
                        <div class="group-info"><h4><?php echo $sanfur_links[$key]['name']; ?></h4></div>
                        <a href="<?php echo $sanfur_links[$key]['link']; ?>" target="_blank" class="group-link-btn">قروب السنافر 👶</a>
                    </div>
                <?php else: ?>
                    <p class="no-data">لا توجد قروبات سنافر مضافة حالياً لهذه الكلية.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
                        <?php 
                            endwhile; 
                        else: 
                        ?>
                            <p class="no-data">لا توجد قروبات سنافر مضافة حالياً لهذه الكلية.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="books-tab" class="tab-content">
            <?php foreach ($faculties as $key => $name): ?>
                <div class="faculty-section">
                    <div class="faculty-title">تبادل كتب - <?php echo $name; ?></div>
                    <div class="groups-list">
                        <?php 
                        $groups = getGroups($conn, 'books', $key);
                        if ($groups->num_rows > 0): 
                            while($row = $groups->fetch_assoc()):
                        ?>
                            <div class="group-item">
                                <div class="group-info"><h4><?php echo htmlspecialchars($row['group_name']); ?></h4></div>
                                <a href="<?php echo htmlspecialchars($row['group_link']); ?>" target="_blank" class="group-link-btn book-btn">قروب الكتب 📚</a>
                            </div>
                        <?php 
                            endwhile; 
                        else: 
                        ?>
                            <p class="no-data">لا توجد قروبات تبادل كتب مضافة حالياً لهذه الكلية.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="uni-tab" class="tab-content">
            <?php foreach ($uni_categories as $cat_key => $cat_data): ?>
                <div class="faculty-section">
                    <div class="faculty-title"><?php echo $cat_data['title']; ?></div>
                    
                    <?php foreach ($cat_data['subjects'] as $subject_name): ?>
                        <div class="subject-card">
                            <div class="subject-name">📘 <?php echo $subject_name; ?></div>
                            <div class="sections-grid">
                                <?php 
                                // استعلام لجلب شُّعب هذه المادة بالتحديد من قاعدة البيانات
                                $safe_subject = mysqli_real_escape_string($conn, $subject_name);
                                $sections = $conn->query("SELECT * FROM academic_groups WHERE group_category = 'university' AND faculty_name = '$cat_key' AND subject_title = '$safe_subject'");
                                
                                if ($sections->num_rows > 0): 
                                    while($sec = $sections->fetch_assoc()):
                                ?>
                                    <div class="section-item">
                                        <h5><?php echo htmlspecialchars($sec['group_name']); ?></h5>
                                        <a href="<?php echo htmlspecialchars($sec['group_link']); ?>" target="_blank" class="group-link-btn uni-btn">انضم 🏛️</a>
                                    </div>
                                <?php 
                                    endwhile; 
                                else: 
                                ?>
                                    <p class="no-data">لا يوجد شُّعب أو قروبات مضافة لهذه المادة حالياً.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <script>
        function openTab(evt, tabId) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabId).classList.add("active");
            evt.currentTarget.classList.add("active");
            window.scrollTo({top: 0, behavior: 'smooth'});
        }
    </script>

</body>
</html>