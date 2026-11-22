<?php
session_start();

// حماية الصفحة
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى - دليل المباني والقاعات</title>
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
            max-width: 900px;
            width: 90%;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .page-title { text-align: center; margin-bottom: 10px; color: #b4031a; font-size: 24px; }
        .page-subtitle { text-align: center; color: #666666; font-size: 14px; margin-bottom: 35px; }

        .section-box {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #b4031a;
            margin-bottom: 15px;
            border-right: 4px solid #b4031a;
            padding-right: 10px;
        }

        .alert-box {
            background-color: #fff3cd;
            border-right: 4px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .hall-explainer {
            background-color: #ffffff;
            border: 2px dashed #b4031a;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 15px;
            text-align: center;
        }

        .explainer-step {
            background-color: #f8f9fa;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 6px;
            flex: 1;
            min-width: 150px;
        }

        .explainer-step h4 { color: #b4031a; font-size: 15px; margin-bottom: 5px; }
        .explainer-step strong { font-size: 20px; color: #111; }

        .calendar-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .calendar-table th, .calendar-table td { padding: 12px 15px; text-align: right; border-bottom: 1px solid #e0e0e0; font-size: 14px; }
        .calendar-table th { background-color: #f4f4f4; color: #111111; font-weight: 700; }
        .calendar-table tr:hover { background-color: #f9f9f9; }
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
        <h2 class="page-title">دليل المباني وفك شفرة القاعة 🏢</h2>
        <p class="page-subtitle">شرح تفصيلي لمساعدتك في معرفة مكان قاعتك الدراسية وأرقام مباني الكليات داخل الحرم الجامعي بكل سهولة.</p>

        <div class="section-box">
            <div class="section-title">💡 كيف تقرأ رمز القاعة في جدولك الدراسي؟</div>
            <div class="alert-box">إذا كان رمز القاعة المكتوب في جدولك هو (20311)، يتم فك الشفرة من اليسار إلى اليمين كالتالي:</div>
            
            <div class="hall-explainer">
                <div class="explainer-step">
                    <h4>رقم المبنى</h4>
                    <p>أول رقمين من اليسار</p>
                    <strong>20</strong>
                    <p style="color:#777; font-size:11px; margin-top:4px;">(مجمع الأعمال والهندسة)</p>
                </div>
                <div class="explainer-step" style="border-right: 1px solid #ddd; border-left: 1px solid #ddd;">
                    <h4>الطابق</h4>
                    <p>الرقم الأوسط</p>
                    <strong>3</strong>
                    <p style="color:#777; font-size:11px; margin-top:4px;">(الطابق الثالث)</p>
                </div>
                <div class="explainer-step">
                    <h4>رقم القاعة</h4>
                    <p>آخر رقمين من اليمين</p>
                    <strong>11</strong>
                    <p style="color:#777; font-size:11px; margin-top:4px;">(قاعة رقم 11 في الممر)</p>
                </div>
            </div>
        </div>

        <div class="section-box">
            <div class="section-title">🏫 دليل إشغال وأرقام مباني الكليات المعتمد</div>
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th>رقم المبنى في الجدول</th>
                        <th>اسم الكلية أو المرافق والمكاتب الموجودة داخل المبنى</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>مبنى 1</strong></td><td>المكتبة المركزية العامة للجامعة</td></tr>
                    <tr><td><strong>مبنى 2</strong></td><td>كلية الصيدلة</td></tr>
                    <tr><td><strong>مبنى 3</strong></td><td>دائرة القبول والتسجيل، الدائرة المالية، مركز الحاسوب</td></tr>
                    <tr><td><strong>مبنى 8</strong></td><td>كلية الآداب وكلية الحقوق</td></tr>
                    <tr><td><strong>مبنى 9</strong></td><td>كلية العلوم وتكنولوجيا المعلومات (IT)</td></tr>
                    <tr><td><strong>مبنى 10</strong></td><td>قسم تكنولوجيا الطاقة البديلة</td></tr>
                    <tr><td><strong>مبنى 11</strong></td><td>مختبرات كلية الهندسية والتكنولوجيا</td></tr>
                    <tr><td><strong>مبنى 12</strong></td><td>عمادة البحث العلمي والابتكار، عمادة الدراسات العليا</td></tr>
                    <tr><td><strong>مبنى 13</strong></td><td>كلية العلوم الطبية التطبيقية والتمريض</td></tr>
                    <tr><td><strong>مبنى 15</strong></td><td>المركز الصحي ومختبرات كلية التمريض</td></tr>
                    <tr><td><strong>مبنى 16</strong></td><td>المجمع الأكاديمي العام</td></tr>
                    <tr><td><strong>مبنى 17</strong></td><td>عمادة شؤون الطلبة ومقر الأنشطة</td></tr>
                    <tr><td><strong>مبنى 18</strong></td><td>المطعم المركزي، وقاعة كبار الزوار</td></tr>
                    <tr><td><strong>مبنى 19</strong></td><td>رئاسة الجامعة، الديوان، العلاقات العامة وشؤون العاملين</td></tr>
                    <tr><td><strong>مبنى 20</strong></td><td>مجمع الكليات (كلية الأعمال، كلية الهندسة والتكنولوجيا، كلية العمارة والتصميم)</td></tr>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>