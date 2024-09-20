<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
      margin: 0;
    }

    .container {
      position: relative;
      max-width: 500px;
      width: 100%;
    }

    .alert-container {
      position: absolute;
      top: -80px; /* Adjust as needed to position above the form */
      left: 0;
      width: 100%;
      text-align: center;
    }

    .form-container {
      background-color: #fff;
      padding: 30px;
      border: 2px solid black;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }

    .alert {
      margin-bottom: 0;
    }
  </style>
</head>

<body>

  <?php
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "form"; 
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = $_POST['fname'];
        $lname = $_POST['lname']; 
        $email = $_POST['email']; 
        $password = $_POST['password'];
        
        // Check if email already exists 
        $checkSql = "SELECT * FROM registration WHERE email='$email'";
        $result = $conn->query($checkSql);

        if ($result->num_rows > 0) {   
            $message = '<div class="alert alert-danger" role="alert">Email already exists. Please enter a different email.</div>';
        } else {
            // Insert new record
            $sql = "INSERT INTO registration (fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$password')";
            
            if ($conn->query($sql) === TRUE) {
                $message = '<div class="alert alert-success" role="alert">Registration successful</div>';
            } else {
                $message = '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . $conn->error . '</div>';
            }
        }
    }

    $conn->close();
    ?>

  <div class="container">
    <div class="alert-container">
      <?php echo $message; ?>
    </div>
    <div class="form-container">
      <h2 class="text-center mb-4">Register</h2>
      <form action="" method="POST">
        <div class="form-group">
          <label for="firstName">First Name</label>
          <input type="text" class="form-control" name="fname" placeholder="First Name" required>
        </div>
        <div class="form-group">
          <label for="lastName">Last Name</label>
          <input type="text" class="form-control" name="lname" placeholder="Last Name" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <input type="submit" class="btn btn-primary btn-block" value="Sign Up">
      </form>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>