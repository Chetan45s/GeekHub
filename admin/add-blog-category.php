<?php 
    require_once('../includes/config.php');

    if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<?php include("head.php");  ?>
<title>Add New Category | GeekHub</title>
<?php include("header.php");  ?>
<?php include("sidebar.php");  ?>


<div class="container">
<div class="row">
    <h2>Add Category</h2>

    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        $_POST = array_map( 'stripslashes', $_POST );
        //collect form data
        extract($_POST);
        //very basic validation
        if($cat_name ==''){
            $error[] = 'Please enter the Category.';
        }

        if(!isset($error)){

            try {

                $cat_slug = slug($cat_name);

                //insert into database
                $stmt = $db->prepare('INSERT INTO category (cat_name,cat_slug) VALUES (:cat_name, :cat_slug)') ;
                $stmt->execute(array(
                    ':cat_name' => $cat_name,
                    ':cat_slug' => $cat_slug
                ));

                //redirect to index page
                header('Location: blog-categories.php?action=added');
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
<div class="card-body m-auto">
    <form action="" method="post">
    <div class="form-group">

        <h3>
            <label>Category Title</label><br>
            <input
                type='text'
                name='cat_name'
                value='<?php if(isset($error)){ echo $_POST['cat_name'];}?>'>
<br>
<br>
            <p><input class="btn btn-success subbtn" type="submit" name="submit" value="Submit"></p>

        </h3>
    </div>
    </form>
</div>
</div>
</div>
</div>
</div>

<?php include("footer.php");  ?>