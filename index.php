<?php
$team = 'IT Log';
$topic = 'ระบบบันทึกงานประจำวันของบริษัท/แผนก';
$problem = 'ไม่มีระบบเก็บบันทึกสถิติและติดตามสถานะการแจ้งซ่อมอุปกรณ์ไอที ทำให้อุปกรณ์ชำรุดตกหล่น และไม่ทราบภาระงานประจำวันของเจ้าหน้าที่ไอที';
$members = ['ชนาทิป เทียมเสมอ (Developer A)', 'ณัฐวัชต์ จันทร์กุล (Developer B)'];
?>
<!DOCTYPE html>
<html lang="th">
<head><meta charset="UTF-8"><title><?php echo $topic; ?></title></head>
<body>
  <h1><?php echo $topic; ?></h1>
  <p>ทีม: <?php echo $team; ?></p>
  <p>ปัญหาที่แก้: <?php echo $problem; ?></p>
  <h2>สมาชิก</h2>
  <ul>
    <?php foreach ($members as $m): ?>
      <li><?php echo $m; ?></li>
    <?php endforeach; ?>
  </ul>
  <p>อัปเดตล่าสุด: <?php echo date('d/m/Y H:i'); ?></p>
</body>
</html>
