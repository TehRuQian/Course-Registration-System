<?php
include 'db_connect.php';


$uid = $_POST['uid']; 
$new_password = $_POST['new_pwd']; 
$confirm_password = $_POST['confirm_pwd']; 


$query = "SELECT u_type FROM tb_user WHERE u_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $utype = $user['u_type']; 
} else {
    echo "User not found.";
    exit;
}


$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

=
if ($utype == 1) {
    $update_sql = "UPDATE tb_students SET s_password = ? WHERE student_id = ?";
} elseif ($utype == 2) {
    $update_sql = "UPDATE tb_lecturers SET l_password = ? WHERE lecturer_id = ?";
} elseif ($utype == 3) {
    $update_sql = "UPDATE tb_admins SET a_password = ? WHERE admin_id = ?";
} else {
    echo "Invalid user type.";
    exit;
}


$stmt = $conn->prepare($update_sql);
$stmt->bind_param("ss", $hashed_password, $uid);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $message = "Password updated successfully.";
    $icon = "success";
} else {
    $message = "No rows updated.";
    $icon = "error";
}


echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Success',
            text: '$message',
            icon: '$icon',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'login.php'; 
            }
        });
    });
</script>";

$conn->close();
?>