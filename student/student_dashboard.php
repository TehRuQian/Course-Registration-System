<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../crs_session.php';
include '../headerstudent.php';
include '../db_connect.php';

$uid = $_SESSION['u_id'];

if ($_SESSION['u_type'] != 1) {
    header('Location: ../login.php');
    exit();
}

// Check if student ID is available
if ($uid) {

    $sql = "
        SELECT 
            e.enrollment_id, 
            c.course_name, 
            c.course_code, 
            e.semester, 
            e.registration_date, 
            e.registration_status
        FROM tb_enrollments e
        JOIN tb_courses c ON e.course_id = c.course_id
        WHERE e.student_id = '$uid'
        ORDER BY e.registration_date DESC
    ";

 
    if ($result = mysqli_query($conn, $sql)) {
        $rowCount = mysqli_num_rows($result);
    } else {
        die("Error executing query: " . mysqli_error($conn)); 
    }
}
?>


    <div class="container">
        <div class="jumbotron" style="padding: 50px;">
        <div class="header-custom">
            <h1>Student Dashboard</h1>
            <div class="row">
                <div class="col">
                    <div class="card border-secondary mb-3 d-flex" style="border-radius: 0.5rem; display: inline-block; margin-right: 10px;">
                        <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem; border-radius: 0.5rem;">
                            <i class="fas fa-calendar-alt"></i> Current Semester
                            <br><hr>
                            <i>2024/2025 Semester 1</i>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-secondary mb-3 d-flex" style="border-radius: 0.5rem; display: inline-block; margin-right: 10px;">
                        <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem; border-radius: 0.5rem;">
                            <i class="fas fa-book"></i> Current CGPA
                            <br><hr>
                            <i>3.00</i>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-secondary mb-3 d-flex" style="border-radius: 0.5rem; display: inline-block; margin-right: 10px;">
                        <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem; border-radius: 0.5rem;">
                            <i class="fas fa-calendar-alt"></i> Activity
                            <br><hr>
                            <i>64</i>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-secondary mb-3 d-flex" style="border-radius: 0.5rem; display: inline-block; margin-right: 10px;">
                        <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem; border-radius: 0.5rem;">
                            <i class="fas fa-dollar-sign"></i> Outstanding
                            <br><hr>
                            <i>0.00</i>
                        </div>
                    </div>
                </div>


            </div>

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
                                <th>Registration Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($rowCount > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    
                                    $enrollment_id = $row['enrollment_id'];
                                    $course_code = $row['course_code'];
                                    $course_name = $row['course_name'];
                                    $semester = $row['semester'];
                                    $registration_date = $row['registration_date'];
                                    $registration_status = $row['registration_status'];
                                    
                                    $status_sql = "SELECT s_desc FROM tb_status WHERE s_id = '$registration_status'";
                                    $status_result = mysqli_query($conn, $status_sql);
                                    $status_row = mysqli_fetch_assoc($status_result);
                                    $registration_status_desc = $status_row['s_desc'];   
                                   
                                    echo "
                                        <tr>
                                            <td>$count</td>
                                            <td>$course_code</td>
                                            <td>$course_name</td>
                                            <td>$semester</td>
                                            <td>$registration_date</td>
                                            <td>$registration_status_desc</td>
                                        </tr>
                                    ";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No courses registered yet</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br><br><br>        
<?php include '../footer.php';?>


