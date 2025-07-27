<?php
// error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../crs_session.php';
include '../headeradmin.php';
include '../db_connect.php';

$uid = $_SESSION['u_id'];
$count = 1;

if ($_SESSION['u_type'] != 3) {
    header('Location: ../login.php');
    exit();
}

$search_param = '';
if (isset($_POST['search_student_id'])) {
    $search_student_id = $_POST['search_student_id'];
    $search_param = "%" . $search_student_id . "%";
}


$sql = "
    SELECT 
        e.enrollment_id,
        s.student_id, 
        s.s_name, 
        c.course_code, 
        c.course_name 
    FROM tb_enrollments e
    JOIN tb_students s ON e.student_id = s.student_id
    JOIN tb_courses c ON e.course_id = c.course_id
";

if ($search_param) {
    $sql .= " WHERE s.student_id LIKE ?";
}

$stmt = mysqli_prepare($conn, $sql);
if ($search_param) {
    mysqli_stmt_bind_param($stmt, "s", $search_param);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Amend/Cancel Registration</title>
</head>
<body>
<div class="container">
    <br>
<div class="jumbotron">
    <h2 style="text-align: center;">Amend/Cancel Registration</h2>
    <div class="container">
        <br>
        <div class="jumbotron" style="padding-left: 30px; padding-right: 30px;">
            <!-- Search Form -->
            <form method="POST" class="d-flex justify-content-end" style="margin-bottom: 10px;">
                <input class="form-control me-sm-2" type="search" name="search_student_id" placeholder="Search by Student ID" 
                style="width: 300px; border-radius: 0.5rem; border: 1px solid #a991d4;">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>Search
                </button>
            </form>
            <div class="card mb-3" style="border-radius: 0.5rem; overflow: hidden;">
                <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem;">
                    <i class="fas fa-book"></i> Enrollment List
                </div>
                <div class="card-body" style="padding: 20px;">
                    <table class="table table-hover align-middle">
                        <thead class="table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "
                                        <tr>
                                            <td>{$count}</td>
                                            <td>{$row['student_id']}</td>
                                            <td>{$row['s_name']}</td>
                                            <td>{$row['course_code']}</td>
                                            <td>{$row['course_name']}</td>
                                            <td>
                                                <form action='amend_process.php' method='post'>
                                                    <input type='hidden' name='enrollment_id' value='{$row['enrollment_id']}'>
                                                    <button type='submit' name='amend' class='btn btn-warning'>Amend</button>
                                                    <button type='submit' name='delete' class='btn btn-danger' onclick='return showDeleteConfirmation()'>Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    ";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No enrollments found</td></tr>";
                            }
                            mysqli_stmt_close($stmt); 
                            ?>
                        </tbody>
                    </table>
                </div>

                <script>
                    function showDeleteConfirmation() {
                        return confirm('Are you sure you want to delete this registration?'); 
                    }
                </script>
            </div>
        </div>
    </div>
    </div>
</div>
</body>
</html>

<br><br>
<?php include '../footer.php';?>
