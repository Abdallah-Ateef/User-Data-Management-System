
<?php
require "connection_db.php";
/* insert user */
if(isset($_POST['submit'])){
    $name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
    $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
    $pass=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
    $mobile=filter_input(INPUT_POST,'mobile',FILTER_SANITIZE_NUMBER_INT);
    if($_POST['submit']=='update'){
        $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
        $insersql="update users set name=:name,email=:email,password=:password,mobile=:mobile where id=$id";
    }else{$insersql='insert into users(name,email,password,mobile) values(:name,:email,:password,:mobile)';}
    
    $insertuser=$connection_db->prepare($insersql);
    $insertuser=$insertuser->execute(array(':name'=>$name,':email'=>$email,':password'=>$pass,':mobile'=>$mobile));
    if($insertuser){
        $found='insert';
    }
}

/* get all users */
$selectsql='select * from users';
$selectsql=$connection_db->prepare($selectsql);
$stmt=$selectsql->execute();
$Allusers=$selectsql->fetchAll(PDO::FETCH_ASSOC);
$Allusers=(is_array($Allusers)&&!empty($Allusers))?$Allusers:false;

/* delete user*/
if(isset($_GET['action'])&&$_GET['action']=='del' &&isset($_GET['id'])){
    $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
  $delsql='delete from users where id=:id';
  $delstmt=$connection_db->prepare($delsql);
  if($delstmt->execute(array(':id'=>$id))){
    $found='del';
  };
}
echo '<pre>';
var_dump($_POST);
echo '</pre>';

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
    <!--Include toastrjs -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

     
</head>
<body>
    <div class="container">
        <div class="wrapper p-5 m-5">
            <div class="d-flex justify-content-between p-2 ">
                <h2>All Users</h2>
                <div><a href="add-user.php"><i class="fa-solid fa-user-plus"></i></a></div>
            </div>
            <div class="informationabout-users m-4">
                 <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($Allusers){
                            $cnt=0;
                            foreach($Allusers as $user){?>
                            

                            <tr>
                            <th scope="row"><?=++$cnt?></th>
                            <td><?=$user['name']?></td>
                            <td><?=$user['email']?></td>
                            <td><?=$user['mobile']?></td>
                            <td><a href="add-user.php?action=edit&id=<?=$user['id']?>"><i class="fa-solid fa-pen-to-square me-4 text-success"></i></a> <a href="index.php?action=del&id=<?=$user['id']?>"><i class="fa-solid fa-trash text-danger"></i></i></a></td>
                            </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
     </table>
            </div>
        </div>
    </div>  
    
    
    
    <?php if(isset($found)){
        if($found=='insert'){?>
        <script src="script.js"> addsucc()</script>

   <?php }elseif($found=='del'){?>
     <script src="script.js"> addsucc()</script>

   <?php } }?>
</body>
</html>


