<?php
//include connection file 
require_once('../includes/config.php');

//check login or not 
if(!$user->is_logged_in()){ header('Location: login.php'); }


if(isset($_GET['delpost'])){ 

    $stmt = $db->prepare('DELETE FROM pages WHERE page_id = :page_id') ;
    $stmt->execute(array(':page_id' => $_GET['delpost']));

    header('Location: blog-pages.php?action=deleted');
    exit;
} 


?>

<?php include("head.php");  ?>

<title>Admin Page
</title>
<script language="JavaScript" type="text/javascript">
    function delpost(id, title) {
        if (confirm("Are you sure you want to delete '" + title + "'")) {
            window.location.href = 'blog-pages.php?delpost=' + page_id;
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
        echo '<h3>Post '.$_GET['action'].'.</h3>'; 
    } 
    ?>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Pages</header>
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th><i class="icon_profile"></i> Name</th>
                    <th><i class="icon_cogs"></i> Update</th>
                    <th><i class="icon_cogs"></i> Delete</th>
                  </tr>
                <?php
                  try {
                    $stmt = $db->query('SELECT page_id,page_title,page_desp,page_content,page_keywords FROM pages ORDER BY page_id DESC');
                        while($row = $stmt->fetch()){
                            
                            echo '<tr>';
                            echo '<td>'.$row['page_title'].'</td>';
                            
                ?>

                        <td>
                            <a class="btn btn-primary" href="edit-blog-page.php?page_id=<?php echo $row['page_id'];?>">Edit</a>
                        </td>
                        <td>
                            <a class="btn btn-danger delbtn"
                                href="javascript:delpost('<?php echo $row['page_id'];?>','<?php echo $row['page_title'];?>')">Delete</a>
                        </td>

                <?php 
                            echo '</tr>';

                        }

                        } catch(PDOException $e) {
                        echo $e->getMessage();
                        }
                ?>
                  </table>
        </section>
    </div>
    <a class="btn btn-default" href='add-blog-page.php'>Add New Page</a>
</div>
</div>
<?php include("footer.php");  ?>