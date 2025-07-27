<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../crs_session.php';
include '../db_connect.php';
include '../headerlecturer.php';

if (!isset($_GET['id'])) {
    header('Location: ../login.php');
    exit();
}

$student_id = $_GET['id'];


$sql = "SELECT e.enrollment_id, c.course_code, c.course_name, e.registration_status 
        FROM tb_enrollments e 
        JOIN tb_courses c ON e.course_id = c.course_id 
        WHERE e.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$course_result = $stmt->get_result();
?>

<div class="container">
<br>
<div class="jumbotron">
    <h2 style="text-align: center;">Course List for Student ID: <?php echo htmlspecialchars($student_id); ?></h2>
    <div class="card mb-3" style="border-radius: 0.5rem; overflow: hidden;">
        <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem;">
            <i class="fas fa-book"></i> Enrollment List
        </div>
    <div class="card-body" style="padding: 20px;">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Registration Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        
        if ($course_result->num_rows > 0) {
            while ($course = $course_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($course['course_code']) . "</td>"; 
                echo "<td>" . htmlspecialchars($course['course_name']) . "</td>"; 
                $registration_status = $course['registration_status']; 

                $status_sql = "SELECT s_desc FROM tb_status WHERE s_id = '$registration_status'";
                $status_result = mysqli_query($conn, $status_sql);
                $status_row = mysqli_fetch_assoc($status_result);
                $registration_status_desc = $status_row['s_desc']; 
                echo "<td>" . htmlspecialchars($registration_status_desc) . "</td>"; 

               
                if ($course['registration_status'] == '1') {
                    echo "<td class='text-left'><button class='btn btn-success' onclick=\"changeStatus('" . $course['enrollment_id'] . "')\">Approve</button></td>";
                } else {
                    echo "<td></td>"; 
                }
                
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>No courses found</td></tr>"; 
        }
        ?>
        </tbody>
    </table>
    <button type="button" class="btn btn-secondary" onclick="window.location.href='student_list.php'">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</div>

<script>
function changeStatus(enrollmentId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log(xhr.responseText);
            if (xhr.status === 200) {
                console.log("Response Text:", xhr.responseText); 
                try {
                    var response = JSON.parse(xhr.responseText); 
                    console.log("Parsed Response:", response);
                    if (response.status === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: response.message
                        });
                    }
                } catch (e) {
                    console.error("JSON parsing error:", e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Parsing Error!',
                        text: 'Error parsing response: ' + xhr.responseText
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Request Failed',
                    text: 'Request Failed: ' + xhr.status
                });
            }
        }
    };
    
    xhr.send("enrollment_id=" + enrollmentId + "&status=2");
}
</script>


<?php include '../footer.php';?>