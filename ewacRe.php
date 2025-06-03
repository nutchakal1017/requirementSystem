<?php 
session_start();
include 'config.php';
// requirement all
$query = mysqli_query($conn, "SELECT * FROM require_ew");

// 1. ดึงข้อมูลทั้งหมดก่อนลบ
$data = [];
$query = mysqli_query($conn, "SELECT * FROM require_ew ORDER BY idewac");
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

// 2. ลบทั้งหมด
mysqli_query($conn, "TRUNCATE TABLE require_ew");

// 3. ใส่ใหม่เรียง id ตั้งแต่ 1
$id = 1;
foreach ($data as $row) {
    mysqli_query($conn, "INSERT INTO require_ew 
        (idewac, reqnamewac, cusnamewac, datesaveewac, datefinishewac, namesavewac, detailewac, picewac, status_ewac) 
        VALUES 
        ('$id', '{$row['reqnamewac']}', '{$row['cusnamewac']}', '{$row['datesaveewac']}', '{$row['datefinishewac']}', '{$row['namesavewac']}', '{$row['detailewac']}', '{$row['picewac']}', '{$row['status_ewac']}')");
    $id++;
}

//var require form
  $result= [
    'idewac' => '',
    'reqnamewac' => '',
    'cusnamewac' => '',
    'datesaveewac' => '',
    'datefinishewac' => '',
    'namesavewac' => '',
    'detailewac' => '',
    'picewac' => '',
    'status_ewac' => '',

  ];


// requirement select edit
if (!empty($_GET['idewac'])) {
    $query_product = mysqli_query($conn, "SELECT * FROM require_ew WHERE idewac='{$_GET['idewac']}'");
    $row_product = mysqli_num_rows($query_product);

    if ($row_product == 0) {
        header('location:' . $base_url . '/ewacRe.php');
    }

    $result = mysqli_fetch_assoc($query_product);

    
}

$rows = mysqli_num_rows($query);

// serarch 
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM require_ew WHERE 1=1";

if (!empty($search)) {
    $search_esc = mysqli_real_escape_string($conn, $search);
    $sql .= " AND (reqnamewac LIKE '%$search_esc%' OR cusnamewac LIKE '%$search_esc%')";
}

if (!empty($status_filter)) {
    $status_esc = mysqli_real_escape_string($conn, $status_filter);
    $sql .= " AND status_ewac = '$status_esc'";
}

$query = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($query);

$query = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการ Requirement</title>
     <link href="<?php echo $base_url; ?>/asset/css/bootstrap.min.css" rel="stylesheet" >
     <link href="<?php echo $base_url; ?>/asset/fontawesome/css/fontawesome.min.css" rel="stylesheet" >
     <link href="<?php echo $base_url; ?>/asset/fontawesome/css/brands.min.css" rel="stylesheet" >
     <link href="<?php echo $base_url; ?>/asset/fontawesome/css/solid.min.css" rel="stylesheet" >
</head>
<body>
    <?php include 'include/menu.php'; ?>   
     <div class="container" style="margint-top: 30px;">
        <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
         <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']);?>
        <?php endif; ?>
       
        <h4> Requirement Manage</h4>
            <div class = "row g-5">
                <div class="col-md-8 col-sm-12">  
                    
                    <form action ="<?php echo $base_url; ?>/ewac_crud.php" method="post" enctype="multipart/form-data">
                        <div class="row g-3 mb-3">

                                    <?php if (!empty($result['idewac'])): ?>
                                    <input type="hidden" name="idewac" value="<?php echo $result['idewac']; ?>">
                                    <?php endif; ?>
                                                         
                                    
                                    
                            <div class="class col-sm-6">
                                <lable class = "form-label" >ชื่อ Requirement</lable>
                                <input type="text" name ="reqnamewac" class="form-control" value="<?php echo $result['reqnamewac'];?>" required>
                            </div>
                            
                            <div class="class col-sm-6">
                                <lable class = "form-label" >ชื่อผู้ให้ข้อมูล</lable>
                                <input type="text" name ="cusnamewac" class="form-control" value="<?php echo $result['cusnamewac'];?>" required>
                            </div>

                            <div class="form-group class col-sm-4">
                             <label for="datesaveewac">วันที่บันทึก</label>
                            <input type="date" name="datesaveewac" class="form-control" value="<?php echo date($result['datesaveewac']); ?>" required>

                            </div>
                            

                           <div class="form-group class col-sm-4 ">
                            <label for="datefinishewac">วันที่สิ้นสุด</label>
                            <input type="date" name="datefinishewac" class="form-control" value="<?php echo date($result['datefinishewac']); ?>"required>
                             </div>
                        
                            
                            <div class="class col-sm-12">
                                <lable class = "form-label" >ชื่อผู้บันทึก</lable>
                                <input type="text" name ="namesavewac" class="form-control" value="<?php echo $result['namesavewac'];?>" required>
                            </div>

                            
                            <div class="col-sm-12">
                             <label for="form-label">รายละเอียด Requirement</label>
                            <textarea name="detailewac"  class="form-control" rows="8" placeholder="ระบุรายละเอียด Requirement" required><?php echo $result['detailewac'];?></textarea>
                            </div>

                        
                            <div class="class col-sm-6">
                                <label for="formfile" class="form-label">รูปภาพประกอบ</label>
                                <input type="file" name="picewac" class="form-control" accept="image/png,image/jpg,image/jpeg">
                                
                                <?php if (!empty($result['picewac'])): ?>
                                    <div class="mt-2">
                                        <p>รูปภาพเดิม:</p>
                                        <img src="<?php echo $base_url; ?>/upload_image_ewac/<?php echo $result['picewac']; ?>" alt="รูปภาพประกอบ" style="max-width: 200px;">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                               <label for="status_ewac">สถานะ:</label>
                        <select name="status_ewac" id="status_ewac" required class="form-control">
                                <option value="">-- กรุณาเลือกสถานะ --</option>
                                <option value="รอดำเนินการ" <?php echo ($result['status_ewac'] == 'รอดำเนินการ') ? 'selected' : ''; ?>>รอดำเนินการ</option>
                                <option value="กำลังดำเนินการ" <?php echo ($result['status_ewac'] == 'กำลังดำเนินการ') ? 'selected' : ''; ?>>กำลังดำเนินการ</option>
                                <option value="เสร็จสิ้น" <?php echo ($result['status_ewac'] == 'เสร็จสิ้น') ? 'selected' : ''; ?>required>เสร็จสิ้น</option>
                        </select>
            </div>


                        </div>
                        <?php if(empty($result['idewac'])): ?>
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk me-1"></i>Create</button>
                        <?php else: ?>
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk me-1"></i>Update</button>
                        <?php endif; ?>

                            <a role ="button" class ="btn btn-secondary" href="<?php echo $base_url; ?>/ewacRe.php" ><i class="fa-solid fa-ban me-1"></i>Cancle</a> 
                         <hr class="my-4">

     



                    </form>
                    <form method="get" action="<?php echo $base_url; ?>/ewacRe.php" class="mb-3 d-flex" role="search">
                        <input
                            type="search"
                            name="search"
                            class="form-control me-2"
                            placeholder="ค้นหาโดยชื่อ Requirement หรือชื่อผู้ให้ข้อมูล"
                            value="<?php echo htmlspecialchars($search); ?>"
                            aria-label="Search"
                        >
                        
                        <!-- ปุ่มล้างค่า search -->
                        <?php if (!empty($search)) : ?>
                            <a href="<?php echo $base_url; ?>/ewacRe.php" class="btn btn-outline-secondary ms-2">ล้าง</a>
                        <?php endif; ?>
            
            
                                <select name="status" class="form-select" style="max-width: 200px;">
                                    <option value="">-- เลือกสถานะ --</option>
                                    <option value="รอดำเนินการ" <?php echo ($status_filter == 'รอดำเนินการ') ? 'selected' : ''; ?>>รอดำเนินการ</option>
                                    <option value="กำลังดำเนินการ" <?php echo ($status_filter == 'กำลังดำเนินการ') ? 'selected' : ''; ?>>กำลังดำเนินการ</option>
                                    <option value="เสร็จสิ้น" <?php echo ($status_filter == 'เสร็จสิ้น') ? 'selected' : ''; ?>>เสร็จสิ้น</option>
                                </select>

                                <button class="btn btn-outline-primary" type="submit">ค้นหา</button>

                                <?php if (!empty($search) || !empty($status_filter)) : ?>
                                    <a href="<?php echo $base_url; ?>/ewacRe.php" class="btn btn-outline-secondary">ล้าง</a>
                                <?php endif; ?>
                            </form>
                                    
    
                                <div>
                                            <a onclick ="exportToExcel()" role="button"  class="btn btn-outline-danger btn-sm">Export เป็น Excel</a>
                                            </div>
                                           <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
                                            <script>
                                            // สำหรับ export Excel
                                            function exportToExcel() {
                                                const table = document.getElementById("dataTable");
                                                const wb = XLSX.utils.table_to_book(table, { sheet: "ข้อมูล" });
                                                XLSX.writeFile(wb, "export-data.xlsx");
                                            }
                                            </script>
                              </div>

            </div>
                    <div class="row">
                        <div class="col-12">
                        <table class="table table-bordered border-info" id="dataTable">
                         <thead>
                            <tr>
                             <th class="small" style="width: 200px;">ลำดับ</th>
                             <th class="small" style="width: 200px;">ชื่อ Requirement</th>
                              <th class="small" style="width: 200px;">ชื่อผู้ให้ข้อมูล</th>
                              <th class="small" style="width: 200px;">วันที่บันทึก</th>
                              <th class="small" style="width: 200px;">วันที่สิ้นสุด</th>
                              <th class="small" style="width: 200px;">ชื่อผู้บันทึก</th>
                              <th class="small" style="width: 200px;">รายละเอียด Requirement</th>
                              <th class="small" style="width: 200px;">รูปภาพประกอบ </th>
                              <th class="small" style="width: 200px;">สถานะการดำเนินงาน</th>
                              <th class="small" style="width: 200px;">action</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php if($rows > 0): ?>
                                <?php while($requirement_alls = mysqli_fetch_assoc($query)): ?>
                                    <tr>
                                        <td><?php echo $requirement_alls['idewac']; ?></td>
                                        <td><?php echo $requirement_alls['reqnamewac']; ?></td>
                                        <td><?php echo $requirement_alls['cusnamewac']; ?></td>
                                        <td><?php echo $requirement_alls['datesaveewac']; ?></td>
                                        <td><?php echo $requirement_alls['datefinishewac']; ?></td>
                                        <td><?php echo $requirement_alls['namesavewac']; ?></td>
                                        <td><?php echo $requirement_alls['detailewac']; ?></td>
                                    
                                        <td>
                                            <?php if(!empty($requirement_alls['picewac'])): ?>
                                                    <img src="<?php echo $base_url; ?>/upload_image_ewac/<?php echo $requirement_alls['picewac']; ?>" 
                                                    width="300" 
                                                    height="200" 
                                                    alt="รูปภาพ Requirement">
                                                    <?php else: ?>
                                                     <?php endif; ?>
                                        </td>
                                        <td><?php echo $requirement_alls['status_ewac']; ?></td>

                                       
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a role="button" href="<?php echo $base_url; ?>/ewacRe.php?idewac=<?php echo $requirement_alls['idewac']; ?>" class="btn btn-outline-dark btn-sm">Edit</a>
                                                <a onclick="return confirm('ต้องการลบ Requirement นี้จริงๆ ใช่มั้ย?');" role="button" href="<?php echo $base_url; ?>/ewac_delate.php?idewac=<?php echo $requirement_alls['idewac']; ?>" class="btn btn-outline-danger btn-sm">Delete</a>
                                            </div>
                                        </td>

                                    </tr>
                                <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10"><h4 class="text-center text-danger">No Requirement</h4></td>
                                </tr>
                            <?php endif; ?>
                                


                        </tbody>
                                
                        </table>
                    </div>
            </div>
    </div>
                            


     <script src="<?php echo $base_url; ?>/asset/css/bootstrap.min.css"></script>
</body>
</html>