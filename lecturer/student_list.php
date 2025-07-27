<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../crs_session.php';
include '../headerlecturer.php';
include '../db_connect.php';

$uid = $_SESSION['u_id'];

if ($_SESSION['u_type'] != 2) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
  
} else {
   
    $sql = "SELECT student_id, s_name FROM tb_students WHERE s_lecturer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $student_result = $stmt->get_result();
}
$count = 1;
?>
<head>
    <style>
        .row-spacing {
            margin-bottom: 4rem;
        }

        a:hover {}

        a:active,
        a.active {
            color: black !important;
        }

        a {
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .container-fluid {
            padding-left: 0;   
            padding-right: 0;
        }

        .is-invalid {
            border: 2px solid red;
        }
        
        .sidebar {
          position: fixed;    
            top: 80px;           
            left: 0;        
            width: 16.666667%; 
            min-height: 100vh;  
            background-color: #eee9f6;
            padding-top: 20px;
            z-index: 800;   
        }
        
         
        .sidebar .row {
            width: 100%;
            padding: 10px;
        }

        .sidebar a {
            display: block;
            width: 100%;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .sidebar hr {
            width: 100%;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 850px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .row {
            margin: 0;    
        }

        .col-2, .col-10 {
            padding: 0;    
        }

        .main-content {
            margin-left: 16.666667%; 
        }

        footer {
        width: calc(100% - 16.666667%) !important; 
        margin-left: 16.666667% !important; 
        padding: 0 20px !important;
      }

        
        footer .container,
        footer .container-fluid {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

          
    </style>
</head>

<div class="container-fluid">
  <div class="row">
    <div class="col-2 sidebar">
        <div class="row">
          <a href="lecturer_dashboard.php" class="text-center active"><br>Course List</a>
          <hr>
        </div>
        <div class="row">
          <a href="student_list.php" class="text-center">Student List</a>
          <hr>
        </div>
    </div>


  </div>
  <div class="col-10 main-content">
    <div class="container">
        <br>
        <div class="jumbotron" style="margin-top: 20px;">
        <div class="card mb-3" style="border-radius: 0.5rem; overflow: hidden;">
                <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem;">
                    <i class="fas fa-user"></i> Student List
                </div>
                <div class="card-body" style="padding: 20px;">
                    <table class="table table-hover align-middle">
                        <thead class="table-hover">
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        if ($student_result->num_rows > 0) {
                            while ($student = $student_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($student['student_id']) . "</td>"; 
                                echo "<td>" . htmlspecialchars($student['s_name']) . "</td>"; 
                                echo "<td class='text-left'><button class='btn btn-info' onclick=\"window.location.href='s_course_list.php?id=" . $student['student_id'] . "'\">Course List</button></td>"; 
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No student found</td></tr>"; 
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" style="margin-left: 5px;" onclick="window.location.href='lecturer_dashboard.php'">
                <i class="fas fa-arrow-left"></i> Back
            </button>
        </div>

    </div>
</div>

<br><br><br><br>        
<?php include '../footer.php';?>


