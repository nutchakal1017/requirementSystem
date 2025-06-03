<?php
session_start();
include 'config.php';

if (!empty($_GET['id_toea'])) {
    $id_toea = $_GET['id_toea'];

    // ดึงชื่อไฟล์ก่อนลบ
    
    $select = mysqli_query($conn, "SELECT requirement_pic FROM requirement_user WHERE id_toea='$id_toea'");
    $data = mysqli_fetch_assoc($select);

    // ลบรูปออกจากโฟลเดอร์ (ถ้ามี)
    if (!empty($data['requirement_pic'])) {
        $image_path = 'upload_image/' . $data['requirement_pic'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    

    // ลบข้อมูลจากฐานข้อมูล
    $query = mysqli_query($conn, "DELETE FROM requirement_user WHERE id_toea='$id_toea'");

    $_SESSION['message'] = $query ? 'ลบ Requirement เรียบร้อยแล้วนะคะ ' : 'ลบไม่สำเร็จค่ะ ลองใหม่อีกทีน้า ';
} else {
    $_SESSION['message'] = 'ไม่พบข้อมูลที่ต้องการลบค่ะ ';
}

header('Location: ' . $base_url . '/index.php');
exit();
?>
?>