<?php
session_start();
include 'config.php';

if (!empty($_GET['id_elic'])) {
    $id_elic = $_GET['id_elic'];

    // ดึงชื่อไฟล์ก่อนลบ
    
    $select = mysqli_query($conn, "SELECT picelic_elic FROM requireelic WHERE id_elic='$id_elic'");
    $data = mysqli_fetch_assoc($select);

    // ลบรูปออกจากโฟลเดอร์ (ถ้ามี)
    if (!empty($data['picelic_elic'])) {
        $image_path = 'upload_image_elic/' . $data['picelic_elic'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // ลบข้อมูลจากฐานข้อมูล
    $query = mysqli_query($conn, "DELETE FROM requireelic WHERE id_elic='$id_elic'");

    $_SESSION['message'] = $query ? 'ลบ Requirement เรียบร้อยแล้วนะคะ ' : 'ลบไม่สำเร็จค่ะ ลองใหม่อีกทีน้า ';
} else {
    $_SESSION['message'] = 'ไม่พบข้อมูลที่ต้องการลบค่ะ ';
}

header('Location: ' . $base_url . '/elicenseRe.php');
exit();
?>
?>