<?php
        session_start();
        include 'db_connection.php';
       
        if(ISSET($_POST['login'])){
                $user_email = $_POST['user_email'];
                $user_password = $_POST['user_password'];
               
                $query = mysqli_query($conn, "SELECT * FROM `user` WHERE `user_email`='$user_email' && `user_password`='$user_password'") or die(mysqli_error());
                $fetch=mysqli_fetch_array($query);
                $count=mysqli_num_rows($query);
               
                if($count > 0){
                        $_SESSION['user_id']=$fetch['user_id'];
                        header('location: dashboard.php');
                }else{
                        echo "<div class='alert alert-danger'>Invalid username or password</div>";
                }
        }
?>