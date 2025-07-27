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

// Check if student ID is available
if ($uid) {
    $stmt = $conn->prepare("SELECT DISTINCT c.course_code, c.course_name, e.semester, c.course_id 
                             FROM tb_courses c 
                             LEFT JOIN tb_enrollments e ON c.course_id = e.course_id 
                             WHERE c.lecturer_id = ? 
                             ORDER BY e.semester ASC");
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
           
        } else {
            echo "No courses found.";
        }
    } else {
        echo "Query execution failed: " . $stmt->error;
    }
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
                    <i class="fas fa-book"></i> Course List
                </div>
                <div class="card-body" style="padding: 20px;">
                    <table class="table table-hover align-middle">
                        <thead class="table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Semester</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                     
                        while ($course = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>$count</td>"; 
                            echo "<td>" . $course['course_code'] . "</td>"; 
                            echo "<td>" . $course['course_name'] . "</td>"; 
                            echo "<td>" . $course['semester'] . "</td>"; 
                            echo "<td><button class='btn btn-info' onclick=\"window.location.href='course_details.php?id=" . $course['course_id'] . "'\">View Details</button></td>"; 
                            echo "</tr>";
                            $count++;
                        }
                        
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br><br><br><br>    
<?php include '../footer.php';?>


