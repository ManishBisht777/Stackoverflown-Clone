<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to your account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
            .middlealert{
                position: absolute;
                width: 80vw;
                top: 20px;
                margin: 0px 10vw;
            }
        </style>
</head>
<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $db = "askiladd";
    $errorChk = 0;
    $conn = mysqli_connect($server , $user , $pass , $db);
    if(!$conn){
        echo "<div class='alert alert-danger alert-dismissible fade show middlealert' style ='position:absolute; role='alert'>
                <strong>Under Maintainence</strong> sorry for the inconvinience.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $uniq = "SELECT * FROM `users` WHERE username = '$username' ";
        $result = mysqli_query($conn , $uniq);
        if(mysqli_num_rows($result) != 1){
            echo "<div class='alert alert-danger alert-dismissible fade show middlealert' style ='position:absolute;' role='alert'>
                <strong>OOPS!</strong> Either wrong username or password <p>
                    pls check again
                </p>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
        else{
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password , $row['password'])){
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $row['usid'];
                header("location: ../index.php");
            }
            else{
                echo "<div class='alert alert-danger alert-dismissible fade show middlealert' style ='position:absolute;' role='alert'>
                <strong>OOPS!</strong> Either wrong username or password <p>
                    pls check again
                </p>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        }
    }
?>

<body style="background-color:rgb(63, 63, 63);">
    <div style="display: flex;justify-content:center;align-items:center; height:100vh">
        <div class="card" style="width: 30rem; min-height:50vh; border-left:15px solid rgb(0, 128, 179);">
            <div class="card-body">
                <h5 class="card-title">Login</h5>
                <form method="post" action="_login.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control"id="username" name = "username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control"
                        id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <br>
                <h6>Don't have an account</h6>
                <a href="./_signup.php">
                    <button type="submit" class="btn btn-success">Sign up now</button>
                </a>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</html>