<?php
$topic = 'ระบบแจ้งงานและติดตามสถานะงาน IT';
$goals = [
    'บันทึกรายการแจ้งซ่อมอุปกรณ์ไอที ได้แก่ ห้องที่ซ่อม วันที่ และเวลา',
    'ติดตามสถานะการซ่อมของแต่ละรายการได้ตลอดเวลา',
    'ลดปัญหาอุปกรณ์ชำรุดตกหล่นโดยไม่มีใครรับทราบ',
    'เก็บสถิติเพื่อดูภาระงานประจำวันของเจ้าหน้าที่ไอที',
];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เป้าหมายของระบบ - <?php echo $topic; ?></title>
</head>
<body>
    <nav>
        <a href="index.php">หน้าแรก</a> |
        <a href="about.php">เกี่ยวกับระบบ</a> |
        <a href="server.php">ข้อมูลเซิร์ฟเวอร์</a>
    </nav>

    <h1>เป้าหมายของระบบ</h1>
    <p><?php echo $topic; ?></p>

    <p>ระบบมีเป้าหมายทั้งหมด <?php echo count($goals); ?> ข้อ</p>
    <ol>
        <?php foreach ($goals as $g): ?>
            <li><?php echo $g; ?></li>
        <?php endforeach; ?>
    </ol>

    <p>อัปเดตล่าสุด: <?php echo date('d/m/Y H:i'); ?></p>
</body>
</html>