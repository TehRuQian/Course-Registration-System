<?php
// error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../crs_session.php';
include '../headeradmin.php';
include '../db_connect.php';

$uid = $_SESSION['u_id'];

if ($_SESSION['u_type'] != 3) {
    header('Location: ../login.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
    
        .dashboard {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 2rem; 
            overflow: hidden;   
        }
    </style>
</head>
<body>
    <div class="container dashboard">
        <h1 class="text-center">Admin Dashboard</h1>
        
        <div class="">
            <div class="">
                <div class="card">
                <div class="card-header" style="background-color: #a991d4; color: white; d-flex justify-content-between align-items-center ">
                        <h4><i class="fas fa-book"></i> Course Management</h4>
                    </div>
                    <div class="card-body">
                        <p>Here you can manage courses, including adding, modifying, and deleting courses.</p>
                        <a href="add_course.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Course</a>
                        <a href="dashboard_modify.php" class="btn btn-warning"><i class="fas fa-edit"></i> Modify Course</a>
                        <a href="delete_course.php" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Course</a>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="card">
                    <div class="card-header" style="background-color: #a991d4; color: white; d-flex justify-content-between align-items-center ">
                        <h4><i class="fas fa-user-graduate"></i> Registration Management</h4>
                    </div>
                    <div class="card-body">
                        <a href="amend_registration.php" class="btn btn-info"><i class="fas fa-user-edit"></i> Amend/Cancel Registration</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>

<br><br>
<?php include '../footer.php';?>


