<?php 
    require_once('../includes/config.php');

    if(!$user->is_logged_in()){ 
        header('Location: login.php'); 
    }

    if(isset($_GET['delpost'])){ 

        $stmt = $db->prepare('DELETE FROM blog WHERE blog_id = :blog_id') ;
        $stmt->execute(array(':blog_id' => $_GET['delpost']));

        header('Location: index.php?action=deleted');
        exit;
    } 
    $self_user = $user->self_user();
?>

<?php include("head.php");  ?>

  <title>Admin Page </title>
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title){
      if (confirm("Are you sure you want to delete '" + title + "'")){
          window.location.href = 'index.php?delpost=' + id;
      }
  }
  </script>

<?php include("header.php");  ?>
<?php include("sidebar.php");  ?>


<div class="container">
    <div class="row">
    <?php 
        if(isset($_GET['action'])){ 
            echo '<h3>Post '.$_GET['action'].'.</h3>'; 
        } 
    ?>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Article Title</header>
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th><i class="icon_profile"></i> Blog Title</th>
                    <th><i class="icon_calendar"></i> Date</th>
                    <th><i class="icon_cogs"></i> Update</th>
                    <th><i class="icon_cogs"></i> Delete</th>
                  </tr>
        <?php
            try {
                $stmt = $db->query('SELECT blog_id, blog_title, blog_datetime, user_id FROM blog ORDER BY blog_id DESC');
            
                while($row = $stmt->fetch()){
                    if(($self_user == $row['user_id']) or ($self_user == 1)){
                    echo '<tr>';
                    echo '<td>'.$row['blog_title'].'</td>';
                    echo '<td>'.date('jS M Y', strtotime($row['blog_datetime'])).'</td>';
        ?>

                    <td> <a class="btn btn-primary" href="edit-blog.php?id=<?php echo $row['blog_id'];?>">Update</a> </td>
                    <td> <a class="btn btn-danger delbtn" href="javascript:delpost('
                        <?php echo $row['blog_id'];?>','
                        <?php echo $row['blog_title'];?>')" >Delete</a>
                    </td>

                    <?php 
                    echo '</tr>';
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
    <a class="btn btn-default" href='add-blog.php'>Add New Article</a>
    
    </div>
</div>

<?php include("footer.php");  ?> 