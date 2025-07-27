<?php
include '../db_connect.php';

if ($_SESSION['u_type'] != 3) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $course_code = trim($_POST['course_code']);

    
    error_log("Received Student ID: " . $student_id); 
    error_log("Received Course Code: " . $course_code); 
    error_log("Trimmed Student ID: " . $student_id); 
    error_log("Trimmed Course Code: " . $course_code); 

    
    $query = "SELECT course_id FROM tb_courses WHERE course_code = ?"; 
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $course_code);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
        $course_id = $course['course_id']; 
        error_log("Course ID: " . $course_id); 

       
        $query = "SELECT * FROM tb_enrollments WHERE student_id = ? AND course_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $student_id, $course_id); 
        $stmt->execute();

        if ($stmt->error) {
            error_log("Query Error: " . $stmt->error); 
        }

        $result = $stmt->get_result();

        
        if ($result->num_rows > 0) {
            echo "match"; 
        } else {
            error_log("No match found for Student ID: " . $student_id . " and Course ID: " . $course_id); 
            
            error_log("Query: " . $query . " | Student ID: " . $student_id . " | Course ID: " . $course_id);
            
            error_log("Student ID Type: " . gettype($student_id) . " | Course ID Type: " . gettype($course_id)); 
            echo "no_match"; 
        }
    } else {
        error_log("No course found with code: " . $course_code); 
        echo json_encode(['course_id' => null]); 
    }
}
?>

<br><br>
<?php include '../footer.php';?>
