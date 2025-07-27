
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();
session_start();
include('db_connect.php');

// Sanitize Input Function
function cleanPost($data) {
    $clean_data = [];
    foreach ($data as $key => $value) {
        $clean_data[$key] = htmlspecialchars(strip_tags(trim($value)));
    }
    return $clean_data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cleanPost = cleanPost($_POST);
    $uid = isset($cleanPost['uid']) ? $cleanPost['uid'] : '';
    $u_pwd = isset($cleanPost['u_pwd']) ? $cleanPost['u_pwd'] : '';

    $sql = "SELECT u.u_id, u.u_type, COALESCE(s.s_password, l.l_password, a.a_password) AS u_pwd
            FROM tb_user u
            LEFT JOIN tb_students s ON u.u_id = s.student_id
            LEFT JOIN tb_lecturers l ON u.u_id = l.lecturer_id
            LEFT JOIN tb_admins a ON u.u_id = a.admin_id
            WHERE u.u_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($u_pwd, $user['u_pwd'])) {
        $_SESSION['u_id'] = $user['u_id'];
        $_SESSION['u_type'] = $user['u_type'];

        switch ($user['u_type']) {
            case 1:
                header('Location: student/student_dashboard.php');
                exit;
            case 2:
                header('Location: lecturer/lecturer_dashboard.php');
                exit;
            case 3:
                header('Location: admin/admin_dashboard.php');
                exit;
            default:
                echo "Invalid user type.";
                exit;
        }
    } else {
        echo "Log In Failed";
        echo '<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
              <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                console.log("Debug: Login process failed.");
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: "Username or Password is incorrect.",
                    footer: \'<a href="forgot_password.php">Forgot Password?</a>\' 
                }).then(() => {
                    window.location.href = "login.php";  // Return to the login form
                });
                </script>';
  exit; 
    }
}



mysqli_close($con);
ob_end_flush();
?>
