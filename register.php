<?php 

require_once "config.php";
require_once "session.php";

if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['submit'])){
    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    if($query = $db->prepare("SELECT * FROM users WHERE email = ?")){
        $error = '';
        $query->bind_param('s',$email);
        $query->execute();
        $query->store_result();
        if($query->num_rows>0){
            $error='<p class="error">The email address is already registered!</p>';
        }
        else{
            if(strlen($password)<6){
                $error='<p class="error">Password must have atleast 6 characters</p>'; 
            }
            if(empty($confirm_password)){
                $error='<p class="error">Please Enter Confirm Password</p>';
            } else{
                if(empty($error) && ($password != $confirm_password)){
                    $error='<p class="error">Password did not matched!</p>';
                }
            }
            if(empty($error)){
                $insertQuery = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?);");
                $insertQuery->bind_param("sss", $fullname,$email,$password_hash);
                $result = $insertQuery->execute();
                if($result){
                    $error='<p class="success">Your Registration was successful!</p>';
                }
                else{
                    $error='<p class="error">Something went wrong!</p>';
                }
            }
        }
    }
    $query->close();
    $insertQuery->close();
    mysqli_close($db);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h2>Register</h2>
            <p>Please Fill this Form to create an Account</p>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" required>
                    </div>
                    <p>Already Have an Account? <a href="login.php">Login here</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>