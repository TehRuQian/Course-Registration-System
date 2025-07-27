<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../crs_session.php';
include '../headerstudent.php';
include '../db_connect.php';


require '../vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        WHERE e.student_id = '$uid' AND e.registration_status = 1
        ORDER BY e.registration_date DESC
    ";

    
    if ($result = mysqli_query($conn, $sql)) {
        $rowCount = mysqli_num_rows($result);
    } else {
        die("Error executing query: " . mysqli_error($conn));  
    }
}

// Initialize a message variable for alerts
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    
    $enrollment_id = $_POST['enrollment_id'];

    
    if (!empty($enrollment_id)) {
        
        $sql = "DELETE FROM tb_enrollments WHERE enrollment_id = '$enrollment_id'";

          // Execute query and check result
          if (mysqli_query($conn, $sql)) {
            
            $message = "Course deleted successfully";

            
            $email_sql = "SELECT s_email FROM tb_students WHERE student_id = '$uid'"; 
            $email_result = mysqli_query($conn, $email_sql);
            $email_row = mysqli_fetch_assoc($email_result);
            $to = $email_row['s_email']; 

            $subject = 'Course Deletion Confirmation';
            $body = "The course with enrollment ID $enrollment_id has been successfully deleted.";
            $headers = 'From: course.registration.system@gmail.com' . "\r\n" . 
                       'X-Mailer: PHP/' . phpversion();

            
            $smtp_host = 'localhost'; 
            $smtp_port = 1025; 

            
            require '../vendor/autoload.php'; 

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'localhost';
            $mail->Port = 1025;
            $mail->SMTPAuth = false; 
            $mail->setFrom('course.registration.system@gmail.com', 'Course Registration System');
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $body;

            if (!$mail->send()) {
                $message = "Mailer Error: " . $mail->ErrorInfo;
            }

           
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: '$message',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = window.location.href;
                    });
                  </script>";
            exit();
        } else {
            $message = "Error deleting record: " . mysqli_error($conn);
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: '$message',
                        showConfirmButton: true
                    });
                  </script>";
        }
    } else {
        $message = "Invalid enrollment ID.";
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: '$message',
                    showConfirmButton: true
                });
              </script>";
    }
}
?>

<div class="container">
   
    <?php if (isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
    <div class="jumbotron" style="padding: 50px;">
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
                            <th>Action</th>
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
                                        <td>
                                            <form action='' method='post'>
                                                <input type='hidden' name='enrollment_id' value='$enrollment_id'>
                                                <button type='submit' name='delete' class='btn btn-danger'>
                                                    <i class='fas fa-trash'></i> Delete
                                                </button>
                                            </form>
                                        </td>
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

<br><br><br><br>        
<?php include '../footer.php';?>


