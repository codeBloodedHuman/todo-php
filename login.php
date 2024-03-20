<?php 
    $login=false;
    $loginerr=false;
    $wrongpass=false;
    $passerror="";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        include 'conn.php';
        $email=$_POST['email'];
        $password=$_POST['password'];
        
        $query=mysqli_query($conn,"SELECT * FROM `users` WHERE email='".$email."'");
        //echo "SELECT * FROM `users` WHERE email='".$email."'&& password='".$password."'";
        $count=mysqli_num_rows($query);
        if($count==1){
            $fetch=mysqli_fetch_assoc($query);
            //$hash=$fetch['password'];
            if(password_verify($_POST['password'], $fetch['password'])){
                $login=true;
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['user']=$fetch['id'];
                header("location:index.php");
            }else{
                $wrongpass=true;
            }
        }else{ 
            $loginerr=true;
            
        }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <?php
    if($login){
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Successfully logged in!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if($loginerr){
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>User with this email id dose not exist!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if($wrongpass){
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Wronge Password!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>
    <div class="container col-md-5 card card1  p-5">
        <h2 class="text-center mb-4">login form</h2>
        <form method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
           <div class="mb-3">
            Not a member ? register yourself <a href="register.php">here</a>
           </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>