<?php 
    $successmsg=false;
    $passerror="";
    $mailerr="";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        include 'conn.php';
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $hashpass=password_hash($password, PASSWORD_DEFAULT);
        $checkemail=mysqli_query($conn,"select * from users where email='".$email."'");
        $count_checkemail=mysqli_num_rows($checkemail);
        if($cpassword==$password ){
            if($count_checkemail!=1){
                $insert=mysqli_query($conn,"INSERT INTO users( name, email, password) VALUES ('".$name."','".$email."','".$hashpass."')");
                if($insert){
                    
                    $successmsg=true;
                
                }
            }else{
                $mailerr="<p style='color:red'>*This email already exist! Try with other one </p>";
            }
            
        }else{ 
            $passerror = "<p style='color:red'>*password and confirm password dose not match</p>";
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
        if($successmsg){
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfully signed up!</strong> Welcome to fam, login <a href="login.php">here</a> .
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    ?>
  <div class="container col-md-6 card card2  px-5 py-3">
    <h2 class="text-center mb-4">Registration form</h2>
        <form method="post">
        <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" aria-describedby="">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                <?php echo $mailerr;?>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                <?php echo $passerror;?>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" id="exampleInputcPassword1">
                <?php echo $passerror;?>
            </div>
           <div class="mb-3">
            Already a member ? login <a href="login.php">here</a>
           </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>