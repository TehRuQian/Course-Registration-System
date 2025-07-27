
<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../crs_session.php';
include '../headerlecturer.php';
include '../db_connect.php';

if ($_SESSION['u_type'] != 2) {
    header('Location: ../login.php');
    exit();
}

// Check if student ID is available
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tb_students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);  
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href = '../login.php';</script>";
    exit;
}
?>

<form method = "post" action = "">
  <fieldset>
    <div class="header-custom">
      <div class="jumbotron" style="margin-top: 30px; padding-left: 200px; padding-right: 200px;">
      <div class="card mb-3" style="border-radius: 0.5rem; overflow: hidden;">
                <div class="card-header" style="background-color: #a991d4; color: white; padding: 10px; font-size: 1.5rem;">
                    <i class="fas fa-user"></i> Student Details
                </div>
            <div class="card-body">
                <div>
                    <label class="form-label mt-4">Name</label>
                    <div class="input-group mt-2">
                        <input type="text" style="background-color: #f0f0f0; color: #000;" name="nama" class="form-control" id="nama" aria-label="nama" placeholder="Ali bin Abu" 
                        value="<?php echo htmlspecialchars($student['s_name'] ?? ''); ?>" readonly>
                    </div>

                    <label class="form-label mt-4">IC Number</label>
                    <div class="input-group mt-2">
                        <input type="text" style="background-color: #f0f0f0; color: #000;" name="ic" class="form-control" id="ic" aria-label="ic" placeholder="000000-00-0000" 
                        value="<?php echo htmlspecialchars($student['s_ic'] ?? ''); ?>" readonly>
                    </div>  

                    <label class="form-label mt-4">Email</label>
                    <div class="input-group mt-2">
                        <input type="text" name="email" class="form-control" id="email" aria-label="email" placeholder="example@gmail.com" 
                        value="<?php echo htmlspecialchars($student['s_email'] ?? ''); ?>" readonly>
                    </div>

                    <label class="form-label mt-4">Phone Number</label>
                    <div class="input-group mt-2">
                        <input type="text" name="phone" class="form-control" id="phone" aria-label="phone" placeholder="0123456789" 
                        value="<?php echo htmlspecialchars($student['s_phone_number'] ?? ''); ?>" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-4"> 
                        <label class="form-label mt-4">Gender</label>
                        <select name="gender" class="form-control" readonly>
                            <?php
                                $sql = "SELECT * FROM tb_gender"; 
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        if (isset($row['ug_id']) && isset($row['ug_desc'])) {
                                            $isSelected = ($row['ug_id'] == $student['s_gender']) ? 'selected' : '';
                                            echo '<option value="' . $row['ug_id'] . '" ' . $isSelected . '>' . $row['ug_desc'] . '</option>';
                                        } else {
                                            echo '<option disabled>No option.</option>'; 
                                        }
                                    }
                                } else {
                                    echo '<option disabled>No option.</option>';
                                }
                                $stmt->close(); 
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label mt-4">Race</label>
                        <select name="race" class="form-control" readonly>
                            <?php
                                $sql = "SELECT * FROM tb_race"; 
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        if (isset($row['ur_id']) && isset($row['ur_desc'])) {
                                            $isSelected = ($row['ur_id'] == $student['s_race']) ? 'selected' : '';
                                            echo '<option value="' . $row['ur_id'] . '" ' . $isSelected . '>' . $row['ur_desc'] . '</option>';
                                        } else {
                                            echo '<option disabled>No option.</option>'; 
                                        }
                                    }
                                } else {
                                    echo '<option disabled>No option.</option>';
                                }
                                $stmt->close(); 
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label mt-4">Religion</label>
                        <select name="religion" class="form-control" readonly>
                            <?php
                                $sql = "SELECT * FROM tb_religion"; 
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        if (isset($row['ua_id']) && isset($row['ua_desc'])) {
                                            $isSelected = ($row['ua_id'] == $student['s_religion']) ? 'selected' : '';
                                            echo '<option value="' . $row['ua_id'] . '" ' . $isSelected . '>' . $row['ua_desc'] . '</option>';
                                        } else {
                                            echo '<option disabled>No option.</option>'; 
                                        }
                                    }
                                } else {
                                    echo '<option disabled>No option.</option>';
                                }
                                $stmt->close(); 
                            ?>
                        </select>
                    </div>

                    <label class="form-label mt-4">Address</label>
                    <div class="input-group mt-2">
                        <input type="text" name="address" class="form-control" id="address" aria-label="address" placeholder="123, Jalan ABC, Taman ABC, 12345" 
                        value="<?php echo htmlspecialchars($student['s_address'] ?? ''); ?>" readonly>
                    </div>
                <div class="row">
                    <div class="col-md-4"> 
                        <label class="form-label mt-4">Postcode</label>
                        <div class="input-group mt-2">
                            <input type="text" name="postcode" class="form-control" id="postcode" aria-label="postcode" placeholder="12345" 
                            value="<?php echo htmlspecialchars($student['s_postcode'] ?? ''); ?>" readonly 
                            maxlength="5" pattern="\d{5}" title="Please enter 5 digits postcode">
                        </div>
                    </div>

                    <div class="col-md-4"> 
                        <label class="form-label mt-4">City</label>
                        <div class="input-group mt-2">
                            <input type="text" name="city" class="form-control" id="city" aria-label="city" placeholder="Kuala Lumpur" 
                            value="<?php echo htmlspecialchars($student['s_city'] ?? ''); ?>" readonly >
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label mt-4">State</label>
                        <select name="state" class="form-control" readonly>
                            <?php
                                $sql = "SELECT * FROM tb_state"; 
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        if (isset($row['st_id']) && isset($row['st_desc'])) {
                                            $isSelected = ($row['st_id'] == $student['s_state']) ? 'selected' : '';
                                            echo '<option value="' . $row['st_id'] . '" ' . $isSelected . '>' . $row['st_desc'] . '</option>';
                                        } else {
                                            echo '<option disabled>No option.</option>'; 
                                        }
                                    }
                                } else {
                                    echo '<option disabled>No option.</option>';
                                }
                                $stmt->close(); 
                            ?>
                        </select>
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px;">
                <button type="button" class="btn btn-secondary" style="margin-right: 20px;" onclick="window.location.href='lecturer_dashboard.php'">
                <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
          </div>
        </div>
    </div>
  </fieldset>
</form>

<br><br><br><br>
<?php include '../footer.php';?>


