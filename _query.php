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
    <title>Askiladd-Query</title>
</head>

<body>
    <?php include './components/_navbar.php';?>
    <div class="underline " style="width:100vw;margin:0;border-radius:0;"></div>
    <div class="container mt-5">
        <div class="row">
        <?php
        $server = 'localhost';
        $username = 'root';
        $pass = '';
        $db = 'askiladd';

        $conn = mysqli_connect($server  , $username , $pass ,$db);
        if(!$conn){
            echo "<div class='alert alert-danger alert-dismissible fade show ' style = 'width:50vw;
                margin:10px auto;' role='alert'>
                    <strong>OOPS!!</strong> Some error occured <br>Please try again later.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        }
        else{
            $id = $_GET['queryid'];
            $sql = $sql = 'SELECT * FROM `queries` WHERE query_id = '.$id;
            $result = mysqli_query($conn , $sql);
            if(!$result){
                echo "<div class='alert alert-danger alert-dismissible fade show ' style = 'width:50vw;
                margin:10px auto;' role='alert'>
                    <strong>OOPS!!</strong> Some error occured <br>Please try again later.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            }
            else{
                while($row = mysqli_fetch_assoc($result)){
                        $title = $row['query_title'];
                        $desc = $row['query_desc'];
                        $time = $row['tstamp'];

                        // POST DATE AND TIME DETAILS
                        $hr = substr($time , 11,2);
                        $min = substr($time , 14,2);
                        $sec = substr($time , 17,2);
                        $date = substr($time , 8,2);
                        $month = substr($time , 5,2);
                        $year = substr($time , 0,4);
                        $posted = date("l jS \of F Y h:i A", mktime($hr, $min, $sec, $month, $date, $year));

                        //USER AREA
                        $userid = $row['user_id'];
                        $sql = 'SELECT * FROM `users` WHERE usid = '.$userid;
                        $result = mysqli_query($conn , $sql);
                        while($user = mysqli_fetch_assoc($result)){
                            $username = $user['username'];
                        }

                        //USER POST DETAILS
                        echo '<div class="toast-header" style= "width:100vw">
                        <i class="fas fa-user mx-3" style="font-size:2.5rem;"></i>
                        <strong class="me-auto" style = "font-size:1.6rem;">'.$username.'</strong>
                        <h4>'.$posted.'</h4>
                    </div>
                    <h2 class = "toast-body">'. $title .'</h2>
                    <div class="toast-body">
                       <h4>'.$desc.'</h4>
                    </div>';
                }
                //COMMMENTS SECTION
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                echo '<div class = "my-3"><button type="button" class="btn btn-primary" id = "togglebtn">Add a comment</button></div>';
                echo '<form class="remove" id = "display" style = "width:70vw;" method = "post" action ='.$_SERVER['REQUEST_URI'].'><div class="mb-3">
                <input type="text" class="form-control" id="comment" name = "comment" placeholder="Enter here.....">
                </div>
                <button type="submit" class="btn btn-success mb-4">Post</button></form>';
                }
                else{
                    echo '<div class="alert alert-info mx-4 mt-3" role="alert">
                                <h4 class="alert-heading">Login to post a comment.</h4>
                                </div>';

                }
                // COMMENT FORM SUBMIT
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $comment = $_POST['comment'];
                    $user_id = $_SESSION['user_id'];
                    $comment = str_replace(">" , "&gt;" , $comment);
                    $comment = str_replace("<" , "&lt;" , $comment);
                    $sql = "INSERT INTO `comments` ( `comment`, `userid`, `queryid`, `tstamp`) VALUES ('$comment', '$user_id', '$id', current_timestamp())";
                    $result =mysqli_query($conn , $sql);
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
                        <strong>YAY!!1</strong> <br><hr>Comment added successfully.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    }
                }
            }
        }
        ?>
            <div class="underline mt-3" style="width:100vw;border-radius:2px;"></div>;
            <h2 class='mt-3'>Replies-</h2>
            <?php
                // $category = $_GET['catid'];
                $sql = 'SELECT * FROM `comments` WHERE queryid='.$id;
                $result = mysqli_query($conn , $sql);
                if(!$result){
                    echo "<div class='alert alert-danger alert-dismissible fade show ' style = 'width:50vw;
                    margin:10px auto;' role='alert'>
                    <strong>OOPS!!</strong> Some error occured <br>Please try again later.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
                //COMMENT SECTION
                else{
                    echo '<div class = "px-5">';
                    while($row = mysqli_fetch_assoc($result)){
                        $comment = $row['comment'];
                        $id = $row['commentid'];
                        $time = $row['tstamp'];

                        //USER DETAILS AREA
                        $userid = $row['userid'];
                        $sql2 = 'SELECT * FROM `users` WHERE usid = '.$userid;
                        $result2 = mysqli_query($conn , $sql2);
                        while($user = mysqli_fetch_assoc($result2)){
                            $username = $user['username'];
                        }


                        // POST DATE AND TIME DETAILS
                        $hr = substr($time , 11,2);
                        $min = substr($time , 14,2);
                        $sec = substr($time , 17,2);
                        $date = substr($time , 8,2);
                        $month = substr($time , 5,2);
                        $year = substr($time , 0,4);
                        // END OF DATE AND TIME DETAILS
                        $posted = date("l jS \of F Y", mktime($hr, $min, $sec, $month, $date, $year));

                        echo '<div class = "mt-3"><div class="toast-header">
                        <i class="fas fa-user mx-3" style="font-size:1.5rem;"></i>
                        <p class="me-auto"><strong>'.$username.'</strong></p>
                        <!-- INSERT USER USING USER ID LATER -->
                        <small><b>'.$posted.'</b></small>
                        </div>
                        <div class="toast-body" style= "width:70vw" >
                           '.$comment.'
                        </div></div>';
                    }
                    echo '</div>';
                }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="./scripts/formToggle.js"></script>
</body>

</html>