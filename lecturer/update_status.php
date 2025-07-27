<?php
include '../db_connect.php'; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enrollment_id = $_POST['enrollment_id'];
    $status = $_POST['status'];

    
    $sql = "UPDATE tb_enrollments SET registration_status = ? WHERE enrollment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $enrollment_id); 
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = array();
        $response['status'] = 'success';
        $response['message'] = 'Status updated successfully';
        echo json_encode($response);
    } else {
        $response = array();
        $response['status'] = 'error';
        $response['message'] = 'Failed to update status';
        echo json_encode($response);
    }

    $stmt->close();
}
$conn->close();
?>
