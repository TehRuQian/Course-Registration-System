<?php
include '../db_connect.php';
include '../crs_session.php';
include '../headeradmin.php';
    
if ($_SESSION['u_type'] != 3) {
    header('Location: ../login.php');
    exit();
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Add new course
    if ($action == "add_course") {
        $course_name = $_POST['course_name'];
        $course_code = $_POST['course_code'];
        $course_description = $_POST['course_description'];
        $lecturer_id = $_POST['lecturer_id'];
        $max_students = $_POST['max_students'];

        // Check if lecturer_id exists
        $check_sql = "SELECT * FROM tb_lecturers WHERE lecturer_id=?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("s", $lecturer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Insert new course into database
            $sql = "INSERT INTO tb_courses (course_name, course_code, course_description, lecturer_id, max_students) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $course_name, $course_code, $course_description, $lecturer_id, $max_students);

            if ($stmt->execute()) {
            
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Successful',
                            text: 'New course added successfully!',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'admin_dashboard.php';
                            }
                        });
                      </script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            // Error and redirect to add_course.php on confirmation
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Unsuccessful',
                        text: 'Lecturer ID does not exist.',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'add_course.php';
                        }
                    });
                  </script>";
        }
    }

    // Modify course details
    if ($action == "modify_course") {
        $course_id = $_POST['course_id'];
        $course_name = $_POST['course_name'];
        $course_code = $_POST['course_code'];
        $course_description = $_POST['course_description'];
        $lecturer_id = $_POST['lecturer_id'];
        $max_students = $_POST['max_students'];

        // Update course details in database
        $sql = "UPDATE tb_courses 
                SET course_name=?, course_code=?, course_description=?, 
                    lecturer_id=?, max_students=?
                WHERE course_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $course_name, $course_code, $course_description, $lecturer_id, $max_students, $course_id);

        if ($stmt->execute()) {
            
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Successful',
                        text: 'Course details updated successfully!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'dashboard_modify.php';
                        }
                    });
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Delete course
    if ($action == "delete_course") {
        $course_code = $_POST['course_code'];

        
        $query = "SELECT * FROM tb_courses WHERE course_code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $course_code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Error
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Course code does not exist',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'delete_course.php'; // Redirect to admin dashboard
                        }
                    });
                  </script>";
        } else {
            // Delete course from database
            $sql = "DELETE FROM tb_courses WHERE course_code=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $course_code);

            if ($stmt->execute()) {
                // Success
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Successful',
                            text: 'Course deleted successfully!',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'admin_dashboard.php';
                            }
                        });
                      </script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
}

// Close database connection
$conn->close();

?>

<br><br>
<?php include '../footer.php';?>
