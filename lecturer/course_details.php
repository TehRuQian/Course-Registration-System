<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../crs_session.php';
include '../headerlecturer.php';
include '../db_connect.php';

if ($_SESSION['u_type'] != 2) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT c.course_name, c.course_code, e.semester, l.l_name 
    FROM tb_courses c 
    LEFT JOIN tb_enrollments e ON c.course_id = e.course_id 
    LEFT JOIN tb_lecturers l ON c.lecturer_id = l.lecturer_id 
    WHERE c.course_id = ?");
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

   
    $stmt = $conn->prepare("SELECT c.course_name, c.course_code, e.semester, l.l_name 
                             FROM tb_courses c 
                             LEFT JOIN tb_enrollments e ON c.course_id = e.course_id 
                             LEFT JOIN tb_lecturers l ON c.lecturer_id = l.lecturer_id 
                             WHERE c.course_id = ?");
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();

   
        $student_stmt = $conn->prepare("SELECT s.student_id, s.s_name 
        FROM tb_enrollments e 
        JOIN tb_students s ON e.student_id = s.student_id 
        WHERE e.course_id = ? AND e.semester = ?");
        $student_stmt->bind_param("ss", $course_id, $course['semester']);
        $student_stmt->execute();
        $student_result = $student_stmt->get_result();
    }
    $stmt->close();
} else {
    echo "<p>Invalid course ID.</p>";
}

$count = 1;
?>

<div class="">
    <div class="container">
        <br>
        <div class="jumbotron" style="padding: 80px;">
        <div class="card mb-3" style="border-radius: 0.5rem; overflow: hidden;">
                <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem;">
                    <i class="fas fa-book"></i> Course Details
                </div>
                <div class="card-body" style="padding: 20px;">
                    <table class="table table-hover align-middle">
                    <tr><th>Course Code</th><td><?php echo $course['course_code']; ?></td></tr>
                    <tr><th>Course Name</th><td><?php echo $course['course_name']; ?></td></tr>
                    <tr><th>Lecturer</th><td><?php echo $course['l_name']; ?></td></tr>
                    </table>
                </div>
            </div>
            <div class="card mb-3" style="border-radius: 0.5rem; overflow: hidden;">
                <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem;">
                    <i class="fas fa-user"></i> Student List
                </div>
                <div class="card-body" style="padding: 20px;">
                    <table class="table table-hover align-middle">
                        <thead class="table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        if ($student_result->num_rows > 0) {
                            while ($student = $student_result->fetch_assoc()) {
                                
                                $student_id = $student['student_id'] ?? '';
                                $student_name = $student['s_name'] ?? ''; 
                                echo "<tr>";
                                echo "<td>" . $count . "</td>";
                                echo "<td>" . htmlspecialchars($student['student_id']) . "</td>"; 
                                echo "<td>" . htmlspecialchars($student['s_name'] ?? '') . "</td>"; 
                                echo "<td class='text-left'><button class='btn btn-info' onclick=\"window.location.href='student_details.php?id=" . $student['student_id'] . "'\">Details</button></td>"; 
                                echo "</tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No student found</td></tr>";
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


