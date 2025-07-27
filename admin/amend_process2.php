<?php
include '../db_connect.php';
include '../headeradmin.php';

if (isset($_POST['amend'])) {

    $enrollment_id = isset($_POST['enrollment_id']) ? $_POST['enrollment_id'] : null;
    $new_course = isset($_POST['new_course']) ? $_POST['new_course'] : null;

    
    if (is_null($enrollment_id) || is_null($new_course)) {
        echo "Enrollment ID or New Course is null.";
        exit;
    }

    
    $update_sql = "
        UPDATE tb_enrollments e
        SET e.course_id = ? 
        WHERE e.enrollment_id = ?";

    if ($stmt = mysqli_prepare($conn, $update_sql)) {
        
        mysqli_stmt_bind_param($stmt, "si", $new_course, $enrollment_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Amend successful!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'amend_registration.php';
                    });
                  </script>";
            exit; 
        } else {
            echo "Error updating record: " . mysqli_stmt_error($stmt); 
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn); 
    }
}
?>

<br><br>
<?php include '../footer.php';?>
