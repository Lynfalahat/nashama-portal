<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// حماية الصفحة: إذا لم يسجل الطالب دخوله يتم توجيهه لصفحة الدخول
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

// مصفوفة الخطط الدراسية (خمس كليات فقط)
$faculty_plans = [
    'it' => ['name' => 'كلية العلوم وتكنولوجيا المعلومات (علم حاسوب، هندسة برمجيات، ذكاء اصطناعي، أمن سيبراني)', 'hours' => '133 ساعة', 'link' => '#'],
    'pharmacy' => ['name' => 'كلية الصيدلة (الصيدلة)', 'hours' => '160 ساعة', 'link' => '#'],
    'nursing' => ['name' => 'كلية التمريض (التمريض)', 'hours' => '132 ساعة', 'link' => '#'],
    'business' => ['name' => 'كلية الأعمال (إدارة، محاسبة، تسويق رقمي، ذكاء أعمال، لوجستية)', 'hours' => '132 ساعة', 'link' => '#'],
    'law' => ['name' => 'كلية الحقوق (الحقوق)', 'hours' => '141 ساعة', 'link' => '#'],
    'therapy' => ['name' => 'كلية العلوم الطبية التطبيقية (العلاج الطبيعي)', 'hours' => '132 ساعة', 'link' => '#']
];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى - دليل الطالب والأدوات الأكاديمية</title>
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

        .header-logo { width: 50px; height: auto; }

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
        .btn-back:hover { background-color: #b4031a; }

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
            gap: 15px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            background: none;
            border: none;
            color: #666666;
            position: relative;
            transition: color 0.3s ease;
        }

        .tab-btn:hover { color: #b4031a; }
        .tab-btn.active { color: #b4031a; }
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

        .tab-content { display: none; animation: fadeIn 0.4s ease; }
        .tab-content.active { display: block; }

        /* حاسبة المعدل الفصلي */
        .gpa-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #fafafa;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #eaeaea;
        }

        .gpa-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .gpa-table th, .gpa-table td { padding: 10px; text-align: center; border-bottom: 1px solid #e0e0e0; }
        .gpa-table th { background-color: #111111; color: #ffffff; font-size: 14px; }
        .gpa-input { width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; text-align: center; font-size: 14px; }
        .gpa-btn-box { display: flex; gap: 10px; justify-content: center; margin-bottom: 20px; }
        
        .btn-gpa {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .btn-calc { background-color: #b4031a; color: #ffffff; }
        .btn-calc:hover { background-color: #d6041e; }
        .btn-add-row { background-color: #111111; color: #ffffff; }
        .btn-add-row:hover { background-color: #333333; }

        .gpa-result-box {
            background-color: #e3f2fd;
            border: 1px solid #90caf9;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            color: #0d47a1;
            display: none;
        }

        /* الخطط وساعات التخرج */
        .guide-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .plan-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.01);
            border-top: 4px solid #b4031a;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 15px;
        }

        .plan-card h3 { font-size: 14px; color: #333333; font-weight: 700; }
        .plan-card p { font-size: 12px; color: #666666; }
        .btn-download { background-color: #111111; color: #ffffff; text-decoration: none; padding: 8px 15px; border-radius: 4px; font-size: 13px; font-weight: 600; transition: background-color 0.3s; }
        .btn-download:hover { background-color: #b4031a; }

        /* الجداول والتقويم */
        .calendar-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .calendar-table th, .calendar-table td { padding: 12px 15px; text-align: right; border-bottom: 1px solid #e0e0e0; font-size: 14px; }
        .calendar-table th { background-color: #f4f4f4; color: #111111; font-weight: 700; }

        /* صناديق الدليل الواجهات الإرشادية */
        .guide-section-box {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .guide-section-title {
            font-size: 18px;
            font-weight: 700;
            color: #b4031a;
            margin-bottom: 15px;
            border-right: 4px solid #b4031a;
            padding-right: 10px;
        }

        .guide-alert-box {
            background-color: #fff3cd;
            border-right: 4px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .guide-list { list-style: none; display: flex; flex-direction: column; gap: 12px; }
        .guide-list li { font-size: 14px; color: #333333; line-height: 1.6; position: relative; padding-right: 20px; }
        .guide-list li::before { content: "•"; position: absolute; right: 0; color: #b4031a; font-size: 20px; font-weight: bold; top: -2px; }
        .badge-info { background-color: #111111; color: #ffffff; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; margin-right: 5px; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
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
        <h2 class="page-title">دليل الطالب والأدوات الأكاديمية الذكية</h2>

        <div class="tabs-container">
            <button class="tab-btn active" onclick="openTab(event, 'gpa-tab')">حساب المعدل الفصلي 🧮</button>
            <button class="tab-btn" onclick="openTab(event, 'plans-tab')">الخطط وساعات الكليات 📑</button>
            <button class="tab-btn" onclick="openTab(event, 'calendar-tab')">التقويم الجامعي 📅</button>
            <button class="tab-btn" onclick="openTab(event, 'rights-tab')">دليل اللوائح والحقوق ⚖️</button>
        </div>

        <!-- تبويب 1: حاسبة المعدل الفصلي التفاعلية -->
        <div id="gpa-tab" class="tab-content active">
            <div class="gpa-container">
                <h3 style="text-align: center; margin-bottom: 20px; font-size: 16px;">أدخل علامات المواد الحالية من 100 لتوقع معدلك الفصلي</h3>
                <table class="gpa-table" id="gpaTable">
                    <thead>
                        <tr>
                            <th>المادة (اختياري)</th>
                            <th>عدد الساعات</th>
                            <th>العلامة (من 100)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="gpa-input" placeholder="مادة 1"></td>
                            <td><input type="number" class="gpa-input hours" min="1" max="6" value="3"></td>
                            <td><input type="number" class="gpa-input grade" min="35" max="100" placeholder="مثال: 85"></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="gpa-input" placeholder="مادة 2"></td>
                            <td><input type="number" class="gpa-input hours" min="1" max="6" value="3"></td>
                            <td><input type="number" class="gpa-input grade" min="35" max="100" placeholder="مثال: 78"></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="gpa-input" placeholder="مادة 3"></td>
                            <td><input type="number" class="gpa-input hours" min="1" max="6" value="3"></td>
                            <td><input type="number" class="gpa-input grade" min="35" max="100" placeholder="مثال: 90"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="gpa-btn-box">
                    <button class="btn-gpa btn-add-row" onclick="addRow()">➕ إضافة مادة جديدة</button>
                    <button class="btn-gpa btn-calc" onclick="calculateGPA()">🧮 احسب المعدل الفصلي</button>
                </div>

                <div class="gpa-result-box" id="gpaResult"></div>
            </div>
        </div>

        <!-- تبويب 2: الخطط وساعات الكليات -->
        <div id="plans-tab" class="tab-content">
            <div class="guide-grid">
                <?php foreach ($faculty_plans as $key => $plan): ?>
                    <div class="plan-card">
                        <h3><?php echo $plan['name']; ?></h3>
                        <p>⏱️ الحد الأدنى لساعات التخرج المعتمدة: <strong><?php echo $plan['hours']; ?></strong></p>
                        <a href="<?php echo $plan['link']; ?>" target="_blank" class="btn-download">تحميل الخطة الدراسية 📥</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- تبويب 3: التقويم الجامعي والأجندة الزمنية -->
        <div id="calendar-tab" class="tab-content">
            <div class="guide-section-box">
                <div class="guide-section-title">📅 الأجندة الزمنية والتقويم الأكاديمي الرسمي</div>
                <table class="calendar-table">
                    <thead>
                        <tr>
                            <th>الحدث الأكاديمي الرسمي</th>
                            <th>الفترة الزمنية المقررة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>فترة السحب والإضافة الإلكترونية المجانية</strong></td><td>الأسبوع الأول من انطلاق الفصل الدراسي العادي</td></tr>
                        <tr><td><strong>امتحانات منتصف الفصل الدراسي (Midterm Exams)</strong></td><td>الأسبوع السابع والثامن من بدء الدراسة للفصل</td></tr>
                        <tr><td><strong>الحد الأقصى للانسحاب من المساقات (درجة W)</strong></td><td>نهاية الأسبوع الثاني عشر من التدريس المباشر</td></tr>
                        <tr><td><strong>فترة الامتحانات النهائية (Final Exams)</strong></td><td>الأسبوع الخامس عشر والسادس عشر وفق الجداول المعلنة</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- تبويب 4: دليل اللوائح والحقوق المفرغ من كتاب الدليل الرسمي -->
        <div id="rights-tab" class="tab-content">
            <div class="guide-section-box">
                <div class="guide-section-title">💰 الرسوم الإدارية والفصلية المعتمدة (البكالوريوس والماجستير)</div>
                <ul class="guide-list">
                    <li><span class="badge-info">الرسوم</span> رسم طلب الالتحاق: 20 ديناراً للبكالوريوس و 25 ديناراً لبرامج الماجستير.</li>
                    <li><span class="badge-info">الرسوم</span> رسم التسجيل الفصلي الثابت: 380 ديناراً لدرجة البكالوريوس و 300 ديناراً للماجستير لكل فصل عادي.</li>
                    <li><span class="badge-info">الرسوم</span> رسم التسجيل للفصل الصيفي: 190 ديناراً للبكالوريوس و 300 ديناراً للماجستير.</li>
                    <li><span class="badge-info">الرسوم</span> رسم الهوية الجامعية: 5 دنانير (وتعد الهوية وسيلتك لاستخدام الحافلات وتأمينك الصحي).</li>
                </ul>
            </div>

            <div class="guide-section-box">
                <div class="guide-section-title">📉 غرامات وتعليمات الانسحاب المالي من الساعات المسجلة</div>
                <div class="guide-alert-box">⚠️ يفقد الطالب رسم التسجيل ورسم امتحان المستوى فوراً بعد فترة السحب والإضافة المجانية، ويخصم من رسوم ساعاته النسب التالية:</div>
                <ul class="guide-list">
                    <li><strong>خصم 25%:</strong> إذا انسحب الطالب في الأسبوعين الأولين من بدء الدراسة بالفصل الدراسي العادي (والأسبوع الأول للصيفي).</li>
                    <li><strong>خصم 50%:</strong> إذا انسحب الطالب في الأسبوعين الثالث والرابع من الفصل العادي (والأسبوع الثاني للصيفي).</li>
                    <li><strong>خصم 75%:</strong> إذا انسحب الطالب في الأسبوع الخامس من بدء الدراسة (والأسبوع الثالث للفصل الصيفي).</li>
                    <li><strong>خصم 100%:</strong> يفقد الطالب الرسوم كاملة ولا يسترد شيئاً إذا تم الانسحاب بعد هذه الفترات المقررة.</li>
                </ul>
            </div>

            <div class="guide-section-box">
                <div class="guide-section-title">❌ قوانين المواظبة والغياب والحرمان الأكاديمي</div>
                <ul class="guide-list">
                    <li>لا يسمح للطالب أن يتجاوز مجموع غياباته في المساق الواحد عن <strong>(15%)</strong> من الساعات المقررة دون عذر طبي أو قهري معتمد.</li>
                    <li>في أنظمة الدراسة الهجينة والمدمجة، تحسب الـ 15% بواقع: <strong>8 غيابات للقاء الوجاهي</strong> و <strong>5 غيابات للمساقات الإلكترونية المتزامنة</strong>.</li>
                    <li>إذا غاب الطالب أكثر من (20%) بعذر مرضي أو قهري يقبله العميد، يُعتبر منسحباً حكماً من الفصل أو المادة وتثبت له ملاحظة (منسحب).</li>
                </ul>
            </div>

            <div class="guide-section-box">
                <div class="guide-section-title">⚠️ الأنظمة والإنذارات الأكاديمية والفصل من التخصص</div>
                <ul class="guide-list">
                    <li>يُوجّه للطالب <strong>(إنذار أول)</strong> أكاديمي إذا انخفض معدله التراكمي عن <strong>(60%)</strong> في أي فصل دراسي (باستثناء الفصل الأول والصيفي).</li>
                    <li>إذا لم يتمكن الطالب من رفع معدله إلى 60% الفصل التالي، يُوجه له <strong>(إنذار ثانٍ)</strong> ويُمنح بعده فصلين دراسيين كفرصة أخيرة للتصويب.</li>
                </ul>
            </div>

            <div class="guide-section-box">
                <div class="guide-section-title">⚖️ لائحة العقوبات التأديبية وقوانين ضبط الغش</div>
                <ul class="guide-list">
                    <li><strong>عقوبة الغش في الامتحان:</strong> إذا ضُبط الطالب متلبساً بالغش أو الشروع فيه، يُعتبر <strong>راسباً في المادة</strong>، ويُلغى تسجيله في كافة المواد الأخرى للفصل الدراسي مع تغريمه رسومها كاملة، ويُفصل من الجامعة فصلاً تأديبياً لمدة فصل دراسي واحد يليه.</li>
                    <li><strong>عقوبة انتحال الشخصية:</strong> الطالب الذي يتفق مع شخص آخر لتأدية الامتحان بدلاً منه، يُعتبر راسباً ويُلغى فصله ويُفصل من الجامعة **فصلين دراسيين على الأقل**، ويُحال الشخص الآخر (من خارج الجامعة) إلى الجهات القضائية والأمنية المختصة فوراً.</li>
                </ul>
            </div>
        </div>
    </main>

    <script>
        function openTab(evt, tabId) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) { tabcontent[i].classList.remove("active"); }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) { tablinks[i].classList.remove("active"); }
            document.getElementById(tabId).classList.add("active");
            if (evt) evt.currentTarget.classList.add("active");
            window.scrollTo({top: 0, behavior: 'smooth'});
        }

        function addRow() {
            var table = document.getElementById("gpaTable").getElementsByTagName('tbody')[0];
            var rowCount = table.rows.length + 1;
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            cell1.innerHTML = '<input type="text" class="gpa-input" placeholder="مادة ' + rowCount + '">';
            cell2.innerHTML = '<input type="number" class="gpa-input hours" min="1" max="6" value="3">';
            cell3.innerHTML = '<input type="number" class="gpa-input grade" min="35" max="100" placeholder="العلامة">';
        }

        function calculateGPA() {
            var hoursInputs = document.getElementsByClassName("hours");
            var gradeInputs = document.getElementsByClassName("grade");
            var totalHours = 0, totalPoints = 0, validSubjects = 0;

            for (var i = 0; i < hoursInputs.length; i++) {
                var hours = parseFloat(hoursInputs[i].value);
                var grade = parseFloat(gradeInputs[i].value);
                if (!isNaN(hours) && !isNaN(grade) && grade >= 35 && grade <= 100) {
                    totalHours += hours;
                    totalPoints += (grade * hours);
                    validSubjects++;
                }
            }

            var resultBox = document.getElementById("gpaResult");
            if (validSubjects > 0 && totalHours > 0) {
                var finalGPA = (totalPoints / totalHours).toFixed(2);
                var estimation = "";
                if (finalGPA >= 84) estimation = "امتياز 🔥";
                else if (finalGPA >= 76) estimation = "جيد جداً ✨";
                else if (finalGPA >= 68) estimation = "جيد 👍";
                else if (finalGPA >= 60) estimation = "مقبول";
                else estimation = "ضعيف";

                resultBox.innerHTML = "🎯 معدلك الفصلي المتوقع هو: <strong>" + finalGPA + "%</strong> (" + estimation + ")";
                resultBox.style.display = "block";
                resultBox.style.backgroundColor = "#e3f2fd";
                resultBox.style.borderColor = "#90caf9";
                resultBox.style.color = "#0d47a1";
            } else {
                resultBox.innerHTML = "⚠️ الرجاء إدخال علامات صحيحة (بين 35 و 100) لحساب المعدل.";
                resultBox.style.display = "block";
                resultBox.style.backgroundColor = "#ffebee";
                resultBox.style.borderColor = "#ef9a9a";
                resultBox.style.color = "#c62828";
            }
        }
    </script>

</body>
</html>