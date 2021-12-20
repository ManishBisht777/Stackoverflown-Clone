<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup now </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    .middlealert {

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
        $cpassword = $_POST['cpassword'];
        $uniq = "SELECT * FROM `users` WHERE username = '$username'";
        $result = mysqli_query($conn , $uniq);
        if(mysqli_num_rows($result) > 0){
            $errorChk = 1;
        }
        else if($password != $cpassword){
            $errorChk = 2;
        }
        else if(strlen($password) == 0 || strlen($cpassword) == 0){
            $errorChk = 3;
        }
        else{
            $sequre = password_hash($password , PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `password`, `timestamp`) VALUES ('$username', '$sequre', current_timestamp())";
            $result = mysqli_query($conn , $sql);
            if(!$result){
                echo mysqli_error($conn);
                echo "<div class='alert alert-danger alert-dismissible fade show middlealert' style ='position:absolute;' role='alert'>
                <strong>Under Maintainence</strong> sorry for the inconvinience.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
            else{
                echo "<div class='alert alert-success alert-dismissible fade show middlealert' style ='position:absolute;' role='alert'>
                <strong>Signup Sucessful</strong> Login to continue.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        }
    }
?>

<body style="background-color:rgb(63, 63, 63);">
    <div style="display: flex;justify-content:center;align-items:center; height:100vh">
        <div class="card" style="width: 35rem; min-height:70vh; border-left:15px solid rgb(0, 128, 179);">
            <div class="card-body">
                <h5 class="card-title">SignUp</h5>
                <div class="form-text">Never share your credentials with anyone else.</div>
                <form method="post" action="_signup.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" <?php
                            if($errorChk == 1){
                                echo "style='border:2px solid red;'";
                            }
                        ?>id="username" name="username">
                        <?php
                            if($errorChk == 1){
                                echo '<div class="form-text" style= "color:red">User already exists</div>';
                            }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" <?php
                            if($errorChk == 2 || $errorChk == 3){
                                echo "style='border:2px solid red;'";
                            }
                        ?> id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" <?php
                            if($errorChk == 2 || $errorChk == 3){
                                echo "style='border:2px solid red;'";
                            }
                        ?> id="cpassword" name="cpassword">
                        <?php
                            if($errorChk == 2){
                                echo '<div class="form-text" style= "color:red">Password not matched</div>';
                                echo '<div class="form-text" style= "color:red">Please check again</div>';
                            }
                            else if($errorChk == 3){
                                echo '<div class="form-text" style= "color:red">Password can`t be empty</div>';
                            }
                        ?>
                    </div>
                    <button type="submit" class="btn btn-primary">SignUp</button>
                </form>
                <br>
                <h6>Already have an account</h6>
                <a href="./_login.php">
                    <button type="submit" class="btn btn-success">Login</button>
                </a>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
    integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
</script>

</html>