<?php
    //include connection file 
    require_once('../includes/config.php');

    //check logged in or not 
    if(!$user->is_logged_in()){ 
        header('Location: login.php'); 
    }

    // add / edit page
    if(isset($_GET['deluser'])){ 

    
    if($_GET['deluser'] !='1'){

        $stmt = $db->prepare('DELETE FROM users WHERE user_id = :user_id') ;
        $stmt->execute(array(':user_id' => $_GET['deluser']));

        header('Location: blog-users.php?action=deleted');
        exit;

    }
    } 

?>

<?php include("head.php");  ?>

  <title>Users - GeekHub Blog</title>

  <script language="JavaScript" type="text/javascript">
  function deluser(id, title)
  {
    if (confirm("Are you sure you want to delete '" + title + "'"))
    {
      window.location.href = 'blog-users.php?deluser=' + id;
    }
  }
  </script>
<?php include("header.php");  ?>
<?php include("sidebar.php");  ?>

<div class="container">
<div class="row">
  <?php 
    //show message from add / edit page
    if(isset($_GET['action'])){ 
      echo '<h3>User '.$_GET['action'].'.</h3>'; 
    } 
    ?>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Your Detail</header>
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th><i class="icon_profile"></i> Username</th>
                    <th><i class="icon_calendar"></i> Email</th>
                    <th><i class="icon_cogs"></i> Update</th>
                  </tr>

        <?php
          try {
            $stmt = $db->query('SELECT user_id, username, email FROM users ORDER BY user_id');

            while($row = $stmt->fetch()){
              if($row['user_id'] == $user->self_user()){
                echo ' <tr>';
                echo ' <td>'.$row['username'].' </td>';
                echo ' <td>'.$row['email'].' </td>';
          ?>
        <td><a class="btn btn-primary" href="edit-blog-user.php?id=<?php echo $row['user_id'];?>">Edit</a> </td>
            </tr>
        <?php
          }
        }
        }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
    ?>
          </table>
      </section>
    </div>


    <?php 
    //show message from add / edit page
    if(isset($_GET['action'])){ 
      echo '<h3>User '.$_GET['action'].'.</h3>'; 
    } 
    ?>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Bloggers</header>
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th><i class="icon_profile"></i> Username</th>
                    <th><i class="icon_calendar"></i> Email</th>
                    <th><i class="icon_cogs"></i> Update</th>
                    <th><i class="icon_cogs"></i> Remove</th>
                  </tr>

        <?php
          try {
            $stmt = $db->query('SELECT user_id, username, email FROM users ORDER BY user_id');

            while($row = $stmt->fetch()){
              if($user->self_user() == 1){
                echo ' <tr>';
                echo ' <td>'.$row['username'].' </td>';
                echo ' <td>'.$row['email'].' </td>';
        ?>
              <td><a class="btn btn-primary" href="edit-blog-user.php?id=<?php echo $row['user_id'];?>">Edit</a> </td>
              <td><a class="btn btn-danger delbtn" href="javascript:deluser('<?php echo $row['user_id'];?>','<?php echo $row['username'];?>')">Delete</a> </td>
              </tr>
      <?php
              }
            }
          }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
      ?>
          </table>
      </section>
    </div>

</div>
    <a class="btn btn-default" href='add-blog-user.php'>Add User</a>
</div>
</div>
  
<?php include("footer.php");  ?>



