<?php //include connection file 
require_once('../includes/config.php');

//loggedin or not 
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<?php include("head.php");  ?>
    <title>GeekHub | Blog</title>
     <?php include("header.php");  ?>

     </div>

<div class="container">
<div class="row">

    <h2>Add User</h2>

    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        //collect form data
        extract($_POST);

        //very basic validation
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if($password ==''){
            $error[] = 'Please enter the password.';
        }

        if($passwordConfirm ==''){
            $error[] = 'Please confirm the password.';
        }

        if($password != $passwordConfirm){
            $error[] = 'Passwords do not match.';
        }

        if($email ==''){
            $error[] = 'Please enter the email address.';
        }

        if(!isset($error)){

            $hashedpassword = $user->create_hash($password);

            try {

                //insert into database
                $stmt = $db->prepare('INSERT INTO users (username,password,email) VALUES (:username, :password, :email)') ;
                $stmt->execute(array(
                    ':username' => $username,
                    ':password' => $hashedpassword,
                    ':email' => $email
                ));

                //redirect to user page 
                header('Location: blog-users.php?action=added');
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo '<p class="message">'.$error.'</p>';
        }
    }
    ?>
<div class = "card">
<div class="form-group">
<div class="card-body align-center">
    <form action="" method="post" onsubmit="return Validation()">

    <div class="form-group">
        <p><label>Username</label><br>
        <input type="text" id="Name" class="form-control" name="username" value="<?php if(isset($error)){ echo $_POST['username'];}?>"></p>
        <span id="usererror" class="text-danger font-weight-bold"> </span>
        
        </div>
        <div class="form-group">
        <p><label>Password</label><br>
        <input type="password" id="password" class="form-control" name="password" value="<?php if(isset($error)){ echo $_POST['password'];}?>"></p>
        <span id="passworderror" class="text-danger font-weight-bold"> </span>
        </div>
        <div class="form-group">
        <p><label>Confirm Password</label><br>
         <input type="password" id="cpassword" class="form-control" name="passwordConfirm" value="<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>"></p>
         <span id="cpassworderror" class="text-danger font-weight-bold"> </span>
         </div>
         <div class="form-group">
        <p><label>Email</label><br>
        <input type="text"id="email" class="form-control" name="email" value="<?php if(isset($error)){ echo $_POST['email'];}?>"></p>
        <span id="emailerror" class="text-danger font-weight-bold"> </span>
        </div>       
        <input type="submit" name="submit" class="btn btn-primary subbtn" value="Add User">
    </form>
</div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">


function Validation(){
var Name = document.getElementById('Name').value;
var password = document.getElementById('password').value;
var cpassword = document.getElementById('cpassword').value;
var email = document.getElementById('email').value;

var usercheck = /^[A-Za-z\s]{3,}$/;
var passwordcheck = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
var emailcheck = /^[A-Za-z_]{3,}([\d]?)+@[A-Za-z]{3,}[.]{1}[A-Za-z.]{2,6}$/;

if (usercheck.test(Name)) 
    {
        document.getElementById('usererror').innerHTML = " ";
    }
else
    {
        document.getElementById('usererror').innerHTML = "** Name is Invalid";
        return false;
    }	


if (passwordcheck.test(password)) 
    {
        document.getElementById('passworderror').innerHTML = " ";
    }
else
    {
        document.getElementById('passworderror').innerHTML = "Password must contain minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character";
        return false;
    }	

if (cpassword.match(password)) 
    {
        document.getElementById('cpassworderror').innerHTML = " ";
    }
else
    {
        document.getElementById('cpassworderror').innerHTML = "Password is not matching";
        return false;
    }

if (emailcheck.test(email)) 
    {
        document.getElementById('emailerror').innerHTML = " ";
    }
else
    {
        document.getElementById('emailerror').innerHTML = "Email is Invalid";
        return false;
    }			

}

</script>

<?php include("footer.php");  ?>