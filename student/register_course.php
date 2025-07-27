<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../crs_session.php';
include '../headerstudent.php';
include '../db_connect.php';

$uid = isset($_SESSION['u_id']) ? $_SESSION['u_id'] : null; 

if ($_SESSION['u_type'] != 1) {
    header('Location: ../login.php');
    exit();
}

if (!$uid) {
    echo "Student ID not found, cannot register course.";
    exit;
}


$sql = "SELECT * FROM tb_courses ORDER BY course_name ASC"; 

// Check if the search input is provided and search for the course code
if (isset($_POST['search_course_code']) && !empty($_POST['search_course_code'])) {
    $search_course_code = $_POST['search_course_code'];

    
    $sql = "
        SELECT * 
        FROM tb_courses
        WHERE course_code LIKE ?
        ORDER BY course_name ASC
    ";
    
    $search_param = "%" . $search_course_code . "%";
}

if ($stmt = $conn->prepare($sql)) {
    
    if (isset($search_param)) {
        $stmt->bind_param("s", $search_param);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $rowCount = $result->num_rows;
    } else {
        die("Error executing query: " . $stmt->error);  
    }
    
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);  
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_course'])) {
    // Getting the course registration data from the form
    $course_id = $_POST['course_id'];
    $student_id = $_POST['student_id'];
    $semester = $_POST['semester'];
    $registration_date = $_POST['registration_date'];
    $registration_status = $_POST['registration_status'];

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO tb_enrollments (course_id, student_id, semester, registration_date, registration_status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $course_id, $student_id, $semester, $registration_date, $registration_status);

    if ($stmt->execute()) {
        // Registration successful
        echo "<script>
                Swal.fire({
                    title: 'Registration Successful!',
                    text: 'You have successfully registered for the course.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'student_dashboard.php'; 
                });
              </script>";
    } else {
        echo "Registration Failed: " . $stmt->error;
    }
    $stmt->close();
}
?>

<div class="header-custom">
    <h2>Course Information</h2>
    <div class="container">
        <br>
        <div class="jumbotron" style="padding-left: 30px; padding-right: 30px;">
            <!-- Search Form -->
            <form method="POST" class="d-flex justify-content-end" style="margin-bottom: 10px;">
                <input class="form-control me-sm-2" type="search" name="search_course_code" placeholder="Search by Course Code" 
                style="width: 300px; border-radius: 0.5rem; border: 1px solid #a991d4;">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>Search
                </button>
            </form>
            <div class="card mb-3" style="border-radius: 0.5rem; overflow: hidden;">
                <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem; d-flex justify-content-between align-items-center;">
                    <i class="fas fa-book"></i> Course Offered
                </div>
                <div class="card-body" style="padding: 20px;">
                    <table class="table table-hover align-middle">
                        <thead class="table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Course Description</th>
                                <th>Capacity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($rowCount > 0) {
                                $count = 1;
                                while ($row = $result->fetch_assoc()) {
                                    
                                    $course_id = $row['course_id'];
                                    $course_code = $row['course_code'];
                                    $course_name = $row['course_name'];
                                    $course_description = $row['course_description'];
                                    $max_students = $row['max_students'];

                                    $student_id = ($_SESSION['u_id']); 
                                    $semester = '2024/2025-2'; 
                                    $registration_date = date('Y-m-d'); 
                                    $registration_status = 1; 

                                    
                                    echo "
                                        <tr>
                                            <td>$count</td>
                                            <td>$course_code</td>
                                            <td>$course_name</td>
                                            <td>$course_description</td>
                                            <td>$max_students</td>
                                            <td>
                                                <form method='post' action='register_course.php'>
                                                    <input type='hidden' name='course_id' value='$course_id'>
                                                    <input type='hidden' name='student_id' value='$student_id'>
                                                    <input type='hidden' name='semester' value='$semester'>
                                                    <input type='hidden' name='registration_date' value='$registration_date'>
                                                    <input type='hidden' name='registration_status' value='$registration_status'>
                                                    <button type='submit' class='btn btn-success' name='register_course'>
                                                    <i class='fas fa-check'></i> Register
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    ";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No course found</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" style="margin-left: 35px;" onclick="window.location.href='student_dashboard.php'">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>
</div>

<br><br><br><br><br>
<?php include '../footer.php';?> 
