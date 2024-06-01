<?php
require 'connection_db.php';
if(isset($_GET['action'])&&$_GET['action']='edit'&&isset($_GET['id'])){
    $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $getsql="select * from users where id=:id";
    $getsql=$connection_db->prepare($getsql);
    $user=$getsql->execute(array(':id'=>$id));
    if($user){
        $user=$getsql->fetchAll(PDO::FETCH_ASSOC);
        $user=array_shift($user);
        $found='update';
    }
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User_App</title>
    <!-- Include bootstrap -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Include fontawesome icons -->
    <link rel="styleesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>
  
</head>
<body>
    <div class="container">
        <div class="wrapper p-5 m-5">
            <div class="d-flex justify-content-between p-2 ">
                <h2><?= isset($user)?"Update user":"Add Users"?></h2>
                <div><a href="index.php"><i class="fa-solid fa-arrow-left"></i></a></div>
            </div>
            <div class="personal-informantion-control">
            <form action="index.php" method="post">
            <div class="mb-3">
                        <label for="exampleInputname" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputname" name="name" required value="<?= isset($user)?$user['name']:''?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required value="<?= isset($user)?$user['email']:''?>">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" required value="<?= isset($user)?$user['password']:''?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputmobile" class="form-label">Mobile</label>
                        <input type="tel" class="form-control" id="exampleInputmobile" name="mobile" value="<?= isset($user)?$user['mobile']:''?>">
                    </div>
                    <?php
                    if(isset($user)){?>
                    <input type="number" name="id" value="<?=$user['id']?>" hidden>

                  <?php  }
                    ?>
                    
                    <button type="submit" class="btn btn-primary" name="submit" value="<?= isset($user)?"update":"save"?>"><?= isset($user)?"Update":"Save"?></button>
             </form>
            </div>

        </div>
    </div>    
</body>
</html>