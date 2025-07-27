<?php
include '../db_connect.php';
include '../headeradmin.php';


if (isset($_POST['delete'])) {
    $enrollment_id = $_POST['enrollment_id'];
    
    $delete_sql = "DELETE FROM tb_enrollments WHERE enrollment_id = ?";
    
    if ($delete_stmt = mysqli_prepare($conn, $delete_sql)) {
        mysqli_stmt_bind_param($delete_stmt, "i", $enrollment_id);
        if (mysqli_stmt_execute($delete_stmt)) {
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Registration deleted successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href='amend_registration.php';
                        }
                    });
                  </script>"; 
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error deleting registration.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
        mysqli_stmt_close($delete_stmt);
    }
} else {
    if (isset($_POST['amend'])) {
        $enrollment_id = $_POST['enrollment_id'];
        
        
        $query = "
            SELECT e.enrollment_id, e.student_id, e.course_id, s.s_name, c.course_name, c.course_code 
            FROM tb_enrollments e 
            JOIN tb_students s ON e.student_id = s.student_id 
            JOIN tb_courses c ON e.course_id = c.course_id
            WHERE e.enrollment_id = ?";
        
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $enrollment_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($row = mysqli_fetch_assoc($result)) {
                
                echo "<form action='amend_process2.php' method='post'>";
                echo "<fieldset style='padding-left: 100px; padding-right: 100px;'>";
                echo "<div class='container'>";
                echo "<br>";
                echo "<div class='jumbotron'>";
                echo "<h2 style='text-align: center;'>Amend Registration</h2>";
                echo "<div class=''>";
                echo "<label for='student_id'>Student ID</label>";
                echo "<input type='text' name='student_id' class='form-control' id='student_id' value='" . $row['student_id'] . "' readonly style='background-color: #f0f0f0;'><br>";
                echo "<label for='student_name'>Student Name:</label>";
                echo "<input type='text' name='student_name' class='form-control' id='student_name' value='" . $row['s_name'] . "' readonly style='background-color: #f0f0f0;'><br>";
                echo "<label for='course_code'>Course Code:</label>";
                echo "<input type='text' name='course_code' class='form-control' id='course_code' value='" . $row['course_code'] . "' readonly style='background-color: #f0f0f0;'><br>";
                echo "<label for='course_name'>Course Name:</label>";
                echo "<input type='text' name='course_name' class='form-control' id='course_name' value='" . $row['course_name'] . "' readonly style='background-color: #f0f0f0;'><br>";
                
                
                echo "<input type='hidden' name='enrollment_id' value='" . $row['enrollment_id'] . "'>";
                
                echo "<input type='hidden' name='new_course' id='new_course' value=''>";
                echo "<label for='new_course'>Select New Course:</label>";
                echo "<select name='new_course' class='form-control' id='new_course' onchange='this.previousElementSibling.value=this.value;'>";
                
                $course_query = "SELECT course_id, course_name FROM tb_courses";
                if ($course_stmt = mysqli_prepare($conn, $course_query)) {
                    mysqli_stmt_execute($course_stmt);
                    $course_result = mysqli_stmt_get_result($course_stmt);
                    while ($course_row = mysqli_fetch_assoc($course_result)) {
                        echo "<option value='" . $course_row['course_id'] . "'>" . $course_row['course_name'] . "</option>";
                    }
                    mysqli_free_result($course_result);
                    mysqli_stmt_close($course_stmt);
                }
                echo "</select><br>";
                
                echo "<button type='submit' name='amend' class='btn btn-primary' style='margin-left: 45%;'>Amend</button>";
                echo "</div>";
                echo "</div>";
                echo "</fieldset>";
                echo "</form>";
            } else {
                echo "No data found for the given enrollment ID.";
            }
            
            mysqli_free_result($result);
            mysqli_stmt_close($stmt);
        } else {
            echo "Error retrieving data: " . mysqli_error($conn);
        }
    }
}

?>

<br><br>
<?php include '../footer.php';?>
