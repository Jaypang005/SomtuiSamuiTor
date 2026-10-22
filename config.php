<?php
// ค่าตั้งของระบบ ใช้ร่วมกันทุกหน้า แก้ที่นี่ที่เดียว
const APP_NAME = 'UniServe ระบบแจ้งซ่อม IT';
const TEAM_NAME = 'SomtuiSamuiTor';
const SLA_DAYS = 3;                 // ควรซ่อมเสร็จภายในกี่วันหลังแจ้ง
const ALERT_PENDING_PERCENT = 40;   // งานรอดำเนินการเกินกี่ % ให้เตือน

date_default_timezone_set('Asia/Bangkok');