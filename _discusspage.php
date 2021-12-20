<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- ICONS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./dist/css/globalStyles.css">
    <title>Askiladd-Queries</title>
</head>

<body>
    <?php include './components/_navbar.php';?>
    <?php
    $server = 'localhost';
    $username = 'root';
    $pass = '';
    $db = 'askiladd';
    $id = $_GET['id'];
    $conn = mysqli_connect($server , $username , $pass , $db);
    if(!$conn){
        echo "<div class='alert alert-danger alert-dismissible fade show ' style = 'width:50vw;
            margin:10px auto;' role='alert'>
            <strong>OOPS!!</strong> Some error occured <br>Please try again later.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $addtitle = $_POST['title'];
        $addtitle = str_replace(">" , "&gt;" , $addtitle);
        $addtitle = str_replace("<" , "&lt;" , $addtitle);
        $adddesc = $_POST['desc'];
        $adddesc = str_replace(">" , "&gt;" , $adddesc);
        $adddesc = str_replace("<" , "&lt;" , $adddesc);
        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO `queries` (`query_title`, `query_desc`, `query_cat`, `user_id`, `tstamp`) VALUES ('$addtitle', '$adddesc', '$id', '$user_id', current_timestamp())";
            $result = mysqli_query($conn , $sql);
            if(!$result){
                echo "<div class='alert alert-danger alert-dismissible fade show ' style = 'width:50vw;
                margin:10px auto;' role='alert'>
                    <strong>OOPS!!</strong> Some error occured <br>Please try again later.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            }
            else{
                echo "<div class='alert alert-success alert-dismissible fade show ' style = 'width:50vw;
                margin:10px auto;' role='alert'>
                    <strong>Added!!! </strong>Your query has been added sucessfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            }
        }
?>
    <div class="container">
        <?php
    $sql = 'SELECT * FROM `category` WHERE cat_id = '.$id;
    $result = mysqli_query($conn , $sql);
    if(!$result){
        echo "<div class='alert alert-danger alert-dismissible fade show ' style = 'width:50vw;
            margin:10px auto;' role='alert'>
                <strong>OOPS!!</strong> Some error occured <br>Please try again later.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
    }
    $row = mysqli_fetch_assoc($result);
?>
        <h1 class='text-center mt-3'><?php echo $row['cat_name']?></h1>
        <div class="underline mx-auto mb-5"></div>
        <div class="container ">
            <h2 class='mx-2'>Recent Questions</h2>
            <div class="underline mb-3" style="height:0.27rem;width:50%;"></div>
            <?php $sql = 'SELECT * FROM `queries` WHERE query_cat = '.$id;
                $result = mysqli_query($conn , $sql);
                if(!$result){
                    echo "<div class='alert alert-danger alert-dismissible fade show ' style = 'width:50vw;
                        margin:10px auto;' role='alert'>
                        <strong>OOPS!!</strong> Some error occured <br>Please try again later.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                }
                else{
                    // session_start();
                    $row = mysqli_num_rows($result);
                    if($row < 1){
                        //IF THERE ARE NO QUERIES
                            echo '<h1 class = "text-center">No recent queries</h1>';
                            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                                echo '<h3 class = "text-center">Be the first one...</h3>';
                            echo '<div class = "my-3 d-flex justify-content-center"><button type="button" class="btn btn-danger" id = "togglebtn">Click meeee</button></div>';
                            //REQEUST_URI->>SAME AS PHP_SELF BUT ALSO SENDS GET DATA (after ?)
                            echo '<form class="remove" id = "display" method = "post" action = '.$_SERVER['REQUEST_URI'].'><div class="mb-3">
                            <label for="title" class="form-label form-extras">Query title</label>
                            <input type="text" class="form-control" id="title" name = "title" placeholder="Please provide a brief title">
                            </div>
                            <div class="mb-3">
                              <label for="desc" class="form-label form-extras">Description</label>
                              <textarea class="form-control" id="desc" name = "desc" rows="3"></textarea>
                            </div><button type="submit" class="btn btn-primary">Upload</button></form>';
                            }
                            else{
                                echo '<div class="alert alert-info mx-4 mt-3" role="alert">
                                <h4 class="alert-heading">Login to post a query.</h4>
                                </div>';

                            }
                    }
                    else{
                        //IF THERE ARE QUERIES
                        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                            echo '<div class = "my-3"><button type="button" class="btn btn-danger" id = "togglebtn">Have your own query</button></div>';
                              echo '<form class="remove" id = "display" style = "width:50vw;" method = "post" action ='.$_SERVER['REQUEST_URI'].'><div class="mb-3">
                              <label for="title" class="form-label form-extras">Query title</label>
                              <input type="text" class="form-control" id="title" name = "title" placeholder="Please provide a brief title">
                            </div>
                            <div class="mb-3">
                              <label for="desc" class="form-label form-extras">Description</label>
                              <textarea class="form-control" id="desc" name = "desc" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button></form>';
                        }
                        else{
                            echo '<div class="alert alert-info mx-4 mt-3" role="alert">
                                <h4 class="alert-heading">Login to post a query.</h4>
                                </div>';
                        }
                    while($row = mysqli_fetch_assoc($result)){
                        $title = $row['query_title'];
                        $desc = $row['query_desc'];
                        $id = $row['query_id'];
                        $catid = $row['query_cat'];
                        $time = $row['tstamp'];

                        //USER DETAILS AREA
                        $userid = $row['user_id'];
                        $sql2 = 'SELECT * FROM `users` WHERE usid = '.$userid;
                        $result2 = mysqli_query($conn , $sql2);
                        $user = mysqli_fetch_assoc($result2);
                        $username = $user['username'];

                        //POST TIME AND DETAILS
                        $hr = substr($time , 11,2);
                        $min = substr($time , 14,2);
                        $sec = substr($time , 17,2);
                        $date = substr($time , 8,2);
                        $month = substr($time , 5,2);
                        $year = substr($time , 0,4);
                        // END OF DATE AND TIME DETAILS
                        $posted = date("l jS \of F Y", mktime($hr, $min, $sec, $month, $date, $year));

                        echo '<div class="toast-header" style= "width:50vw">
                        <i class="fas fa-user mx-3" style="font-size:1.5rem;"></i>
                        <strong class="me-auto">'.$username.'</strong>
                        <small>'.$posted.'</small>
                    </div>
                    <a class = "text-dark"style = "text-decoration:none;" href ="_query.php?queryid='.$id.'">
                    <h5 class = "toast-body">'. $title .'</h5>
                    <div class="toast-body">
                       '. substr($desc , 0 , 100) .'..
                    </div></a>';
                    }
                }
                }
                mysqli_close($conn);
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="./scripts/formToggle.js"></script>
</body>

</html>