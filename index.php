<?php 
include 'conn.php';
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
}
if (isset($_GET['del_task'])) {
  $id = $_GET['del_task'];

  mysqli_query($conn, "DELETE FROM tasks WHERE id=".$id);
  header('location: index.php');
}
if (isset($_GET['comp_task'])) {
  $id = $_GET['comp_task'];
  mysqli_query($conn, "UPDATE tasks SET status = 'Complete' WHERE id=".$id);
  header('location: index.php');
}
if (isset($_GET['incomp_task'])) {
  $id = $_GET['incomp_task'];
  mysqli_query($conn, "UPDATE tasks SET status = 'Incomplete' WHERE id=".$id);
  echo "UPDATE tasks SET status = 'Incomplete' WHERE id=".$id;
  //header('location: index.php');
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <div class="container ">
        <?php
        $qry=mysqli_query($conn,"select * from users where id='".$_SESSION['user']."'");
        $fetch=mysqli_fetch_assoc($qry);
        if (isset($_POST['submit'])) {
          if (empty($_POST['task'])) {
            $errors = "You must fill in the task";
          }else{
            $task = $_POST['task'];
            $userid=$_SESSION['user'];
            $status="Incomplete";
            $sql = "INSERT INTO tasks (task, user_id, status) VALUES ('$task','$userid','$status')";
            mysqli_query($conn, $sql);
            header('location: index.php');
          }
        } 
        ?>
        <h1 class="text-center mt-5">Welcome  <?php echo $fetch['name']; ?></h1>
        <a href="logout.php" style="text-decoration:none;"><button class="btn btn-info mx-auto d-block mt-4">logout</button></a>
        <div class="heading">
                <h2 style="font-style: 'Hervetica';">ToDo List </h2>
        </div>
        <form method="post" action="index.php" class="input_form">
                <input type="text" name="task" class="task_input">
                <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
                <?php if (isset($errors)) { ?>
                  <p><?php echo $errors; ?></p>
                <?php } ?>
        </form>
        <table>
            <thead>
                    <tr>
                            <th>N</th>
                            <th>Tasks</th>
                            <th style="width: 60px;">Action</th>
                    </tr>
            </thead>

            <tbody>
                    <?php 
                    // select all tasks if page is visited or refreshed
                    $tasks = mysqli_query($conn, "SELECT * FROM tasks where user_id='".$_SESSION['user']."'");

                    $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
                            <tr>
                                    <td> <?php echo $i; ?> </td>
                                    <td class="task"> <?php echo $row['task']; ?> 
                                    <!-- <? if($row['status']==="Incomplete"){?>
                                          <a href="index.php?comp_task=<?php echo $row['id']; ?>">Mark as Completed<?=$row['status']?></a>
                                      <?} else if($row['status']==="Complete"){?>
                                          <a href="index.php?Incomp_task=<?php echo $row['id'] ;?>">Mark as Incomplete</a>
                                      <?}?> -->
                                    </td>
                                    <td class="delete"> 
                                      
                                      
                                        <a href="index.php?del_task=<?php echo $row['id']; ?>">x</a> 
                                    </td>
                            </tr>
                    <?php $i++; } ?>  
            </tbody>
        </table>
       
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>