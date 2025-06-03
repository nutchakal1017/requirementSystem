<?php 
session_start();
include 'config.php';

$id_toea = !empty($_POST['id_toea']) ? $_POST['id_toea'] : null;

$requirement_name = trim($_POST['requirement_name']);
$customer_name = trim($_POST['customer_name']);
$date_save = trim($_POST['date_save']);
$date_finish = trim($_POST['date_finish']);
$name_save = trim($_POST['name_save']);
$requirement_detail = trim($_POST['requirement_detail']);
$status_requirement = trim($_POST['status_requirement']);

$search = !empty($_POST['search']) ? $_POST['search'] : '';
$search_url = $search ? '?search=' . urlencode($search) : '';

$image_name = $_FILES['requirement_pic']['name'];
$image_tmp = $_FILES['requirement_pic']['tmp_name'];
$folder = 'upload_image/';
$image_location = $folder . $image_name;

// ถ้าเป็นการอัปเดต
if ($id_toea) {
    if (!empty($image_name)) {
        move_uploaded_file($image_tmp, $image_location);
        $query = mysqli_query($conn, "
            UPDATE requirement_user SET
                requirement_name = '$requirement_name',
                customer_name = '$customer_name',
                date_save = '$date_save',
                date_finish = '$date_finish',
                name_save = '$name_save',
                requirement_detail = '$requirement_detail',
                requirement_pic = '$image_name',
                status_requirement = '$status_requirement'
            WHERE id_toea = '$id_toea'
        ");
    } else {
        $query = mysqli_query($conn, "
            UPDATE requirement_user SET
                requirement_name = '$requirement_name',
                customer_name = '$customer_name',
                date_save = '$date_save',
                date_finish = '$date_finish',
                name_save = '$name_save',
                requirement_detail = '$requirement_detail',
                status_requirement = '$status_requirement'
            WHERE id_toea = '$id_toea'
        ");
    }

    $_SESSION['message'] = $query ? 'Requirement updated successfully' : 'Failed to update Requirement';
} else {
    $query = mysqli_query($conn, "
        INSERT INTO requirement_user (
            requirement_name,
            customer_name,
            date_save,
            date_finish,
            name_save,
            requirement_detail,
            requirement_pic,
            status_requirement
        ) VALUES (
            '$requirement_name',
            '$customer_name',
            '$date_save',
            '$date_finish',
            '$name_save',
            '$requirement_detail',
            '$image_name',
            '$status_requirement'
        )
    ");

    if ($query) {
        move_uploaded_file($image_tmp, $image_location);
    }

    $_SESSION['message'] = $query ? 'Requirement saved successfully' : 'Failed to save Requirement';
}

header('Location: ' . $base_url . '/index.php' . $search_url);
exit();
?>