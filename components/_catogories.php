<?php
    $server = "localhost";
    $username = "root";
    $pass = "";
    $db = "askiladd";

    $conn = mysqli_connect($server , $username , $pass , $db);
    if(!$conn){
        echo "<div class='alert alert-danger alert-dismissible fade show ' style = 'width:50vw;
        margin:10px auto;' role='alert'>
                <strong>Under Maintainence</strong> sorry for the inconvinience.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
    }
    else{
        $sql = 'SELECT * FROM `category`';
        $result = mysqli_query($conn , $sql);
        if(!$result){
            echo "<div class='alert alert-danger alert-dismissible fade show ' style = 'width:50vw;
            margin:10px auto;' role='alert'>
                <strong>OOPS!!</strong> Some error occured <br>Sorry for the inconvinience.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
        //LOOP FOR DISPLAYING CATEGORIES
        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="col-md-4 mt-5">
            <div class=" card-hover" style="width: 18rem;">
            <div class="card-body" style = "min-height:15rem;position:relative">
              <h5 class="card-title">' . $row['cat_name'] . '</h5>
              <div class = "underline" style = " height : 3px;width : 80%;margin : 0;"></div>
              <p class="card-text mt-3"> '. substr($row['cat_desc'] , 0 , 100) . '...</p>
              <a href="_discusspage.php?id='.$row['cat_id'].'" class="btn btn-primary card-btn">Go to discussion</a>
            </div>
          </div>
          </div>';
        }
    }
?>