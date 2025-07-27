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
    <title>Add New Course</title>
</head>
<body>

   

    <form method="post" action="process.php">
        <fieldset>
            <div class="container">
                <br>
                <div class="jumbotron">
                <h2 style="text-align: center;">Add New Course</h2>
        <input type="hidden" name="action" value="add_course"> 

        <div>
          <label class="form-label mt-4">Course Name</label>
          <div class="input-group mt-2">
            <input type="text" name="course_name" class="form-control" id="course_name" aria-label="course_name" placeholder="Course Name" required>
          </div>
        </div>

        <div>
          <label class="form-label mt-4">Course Code</label>
          <div class="input-group mt-2">
            <input type="text" name="course_code" class="form-control" id="course_code" aria-label="course_code" placeholder="Course Code" required oninput="fetchCourseByCode()">
          </div>
        </div>

        <div id="course_info" class="mt-4"></div>

        <div>
          <label class="form-label mt-4">Course Description</label>
          <div class="input-group mt-2">
            <textarea id="course_description" name="course_description" class="form-control" aria-label="course_description" placeholder="Course Description"></textarea>
          </div>
        </div>

        <div>
          <label class="form-label mt-4">Lecturer ID</label>
          <div class="input-group mt-2">
            <input type="text" id="lecturer_id" name="lecturer_id" class="form-control" aria-label="lecturer_id" placeholder="Lecturer ID" required>
          </div>
        </div>

        <div>
          <label class="form-label mt-4">Maximum Students</label>
          <div class="input-group mt-2">
            <input type="number" id="max_students" name="max_students" class="form-control" aria-label="max_students" placeholder="Maximum Students" required>
          </div>
        </div>

        <input type="submit" class="btn btn-primary mt-4" style="margin-left: 45%;" value="Add Course">
    </form>
    </div>
    </div>
    </div>
    </fieldset>
<br>
</body>
</html>

<br><br>
<?php include '../footer.php';?>
