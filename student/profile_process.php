<?php
include '../crs_session.php';
include '../db_connect.php'; 
include '../headerstudent.php';

if ($_SESSION['u_type'] != 1) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // take data from profile.php
    $uid = $_SESSION['u_id'];
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $race = $_POST['race'];
    $religion = $_POST['religion'];

    // update data to database
    $sql = "UPDATE tb_students SET s_name = ?, s_email = ?, s_phone_number = ?, s_postcode = ?, s_city = ?, s_address = ?, s_gender = ?, s_race = ?, s_religion = ? WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssis", $name, $email, $phone, $postcode, $city, $address, $gender, $race, $religion, $uid);

    
    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Success',
                    text: 'Profile updated successfully.',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'profile.php';
                    }
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error updating profile.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'profile.php';
                    }
                });
              </script>";
    }
    $stmt->close();
}
?>

<br><br><br><br>        
<?php include '../footer.php';?>