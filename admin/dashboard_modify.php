<?php
// Enable error reporting
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
    <title>Modify Course</title>
</head>
<body>
<div class="container">
        <div class="jumbotron" style="padding: 130px;">
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
                                <th>Lecturer ID</th>
                                <th>Max Students</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                           
                            $course_sql = "SELECT * FROM tb_courses";
                            $course_result = mysqli_query($conn, $course_sql);
                            $course_rowCount = mysqli_num_rows($course_result);

                            if ($course_rowCount > 0) {
                                $count = 1;
                                while ($course_row = mysqli_fetch_assoc($course_result)) {
                                   
                                    $course_code = $course_row['course_code'];
                                    $course_name = $course_row['course_name'];
                                    $course_description = $course_row['course_description'];
                                    $lecturer_id = $course_row['lecturer_id'];
                                    $max_students = $course_row['max_students'];
                                    
                                    echo "
                                        <tr>
                                            <td>$count</td>
                                            <td>$course_code</td>
                                            <td>$course_name</td>
                                            <td>$lecturer_id</td>
                                            <td>$max_students</td>
                                            <td><a href='modify_course.php?course_code=$course_code' class='btn btn-warning'><i class='fas fa-edit'></i> Modify</a></td>
                                        </tr>
                                    ";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No courses found</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<br>

</body>
</html>

<br><br>
<?php include '../footer.php';?>
