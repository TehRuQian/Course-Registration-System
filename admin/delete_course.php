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
    <title>Delete Course</title>
</head>
<body>

    <form method="post" action="process.php" id="deleteForm">
        <fieldset>
            <div class="container">
                <br>
                <div class="jumbotron">
                <h2 style="text-align: center;">Delete Course</h2>
        <input type="hidden" name="action" value="delete_course"> 

        <div>
          <label class="form-label mt-4">Course Code</label>
          <div class="input-group mt-2">
            <input type="text" name="course_code" class="form-control" id="course_code" aria-label="course_code" placeholder="Course Code" required>
          </div>
        </div>

        <input type="submit" class="btn btn-danger mt-4" style="margin-left: 45%;" value="Delete Course">
    </div>
    </div>
    </div>
    </fieldset>

    <script>
        document.getElementById('deleteForm').onsubmit = function(event) {
            event.preventDefault(); 
            confirmDelete(); 
        };

        function confirmDelete() {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit(); 
                }
            });
        }
    </script>
</body>
</html>

<br><br>
<?php include '../footer.php';?>
