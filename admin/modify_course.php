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

if (isset($_GET['course_code'])) {
    $course_code = $_GET['course_code'];

    $stmt = $conn->prepare("SELECT * FROM tb_courses WHERE course_code = ?");
    $stmt->bind_param("s", $course_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();

    $course_name = $course['course_name'];
    $course_description = $course['course_description'];
    $lecturer_id = $course['lecturer_id'];
    $max_students = $course['max_students'];
    $course_id = $course['course_id'];

} else {
    echo "<p>Invalid course code.</p>";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Modify Course</title>
</head>
<body>

    <form method="post" action="process.php">
        <fieldset>
            <div class="container">
                <br>
                <div class="jumbotron">
                <h2 style="text-align: center;">Modify Course</h2>
        <input type="hidden" name="action" value="modify_course"> 

        
        <div>
          <label class="form-label mt-4">Course Code</label>
          <div class="input-group mt-2">
            <input type="text" name="course_code" class="form-control" id="course_code" aria-label="course_code" placeholder="Course Code" value="<?php echo $course_code; ?>" readonly>
          </div>
        </div>

        <div>
          <label class="form-label mt-4">Course ID</label>
          <div class="input-group mt-2">
            <input type="number" name="course_id" class="form-control" id="course_id" aria-label="course_id" placeholder="Course ID" value="<?php echo $course_id; ?>" readonly style="background-color: #f0f0f0;">
          </div>
        </div>

        <div id="course_info" class="mt-4"></div>

        <div>
          <label class="form-label mt-4">Course Name</label>
          <div class="input-group mt-2">
            <input type="text" name="course_name" class="form-control" id="course_name" aria-label="course_name" placeholder="Course Name" value="<?php echo $course_name; ?>" required>
          </div>
        </div>


        <div>
          <label class="form-label mt-4">Course Description</label>
          <div class="input-group mt-2">
            <textarea id="course_description" name="course_description" class="form-control" aria-label="course_description" placeholder="Course Description" required><?php echo $course_description; ?></textarea>
          </div>
        </div>

        <div>
          <label class="form-label mt-4">Lecturer ID</label>
          <div class="input-group mt-2">
            <input type="text" name="lecturer_id" class="form-control" id="lecturer_id" aria-label="lecturer_id" placeholder="Lecturer ID" value="<?php echo $lecturer_id; ?>" required>
          </div>
        </div>

        <div>
          <label class="form-label mt-4">Maximum Students</label>
          <div class="input-group mt-2">
            <input type="number" name="max_students" class="form-control" id="max_students" aria-label="max_students" placeholder="Maximum Students" value="<?php echo $max_students; ?>" required>
          </div>
        </div>

        <input type="submit" class="btn btn-primary mt-4" style="margin-left: 45%;" value="Modify Course">
    </div>
    </div>
    </div>
    </fieldset>
<br>

</body>
</html>

<br><br>
<?php include '../footer.php';?>
