<?php
include 'crs_session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration System</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../img/logo_crs.png" rel="icon" type="/image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Inter', sans-serif;
            padding-top: 70px;
            background: white;
        }
        .header-custom h1, 
        .header-custom h2, 
        .header-custom h3, 
        .header-custom h4, 
        .header-custom h5, 
        .header-custom h6 {
            font-size: 2.5rem;
            font-style: normal;
            font-weight: bold;
            color: black;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            text-align: center;
            margin-top: 50px;
        }


    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
  <img src="../img/logo_crs.png" alt="Logo" style="height: 40px; margin-right: 10px;">
    <a class="navbar-brand" href="../admin/admin_dashboard.php">Course Registration System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor03">
      <ul class="navbar-nav ms-auto">
      <li class="nav-item">
          <a class="nav-link" href="../admin/add_course.php">Add New Course</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../admin/dashboard_modify.php">Modify Course</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../admin/delete_course.php">Delete Course</a>  
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../admin/amend_registration.php">Amend/Cancel Registration</a>  
        </li>
        <li class="nav-item">
          <button type="button" class="btn btn-primary" style="margin-right: 20px;" onclick="window.location.href='../logout.php'">Logout</button>
        </li>
      </ul>
    </div>
  </div>
</nav>

</body>
</html>