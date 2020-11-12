<?php
    //include config
    require_once('../includes/config.php');

    //if not logged in redirect to login page
    if(!$user->is_logged_in()){ header('Location: login.php'); }

    //show message from add / edit page
    if(isset($_GET['delcat'])){ 

        $stmt = $db->prepare('DELETE FROM category WHERE cat_id = :cat_id') ;
        $stmt->execute(array(':cat_id' => $_GET['delcat']));

        header('Location: categories.php?action=deleted');
        exit;
    } 

?>

<?php include("head.php");  ?>

<title>Categories | GeekHub</title>
<script language="JavaScript" type="text/javascript">
    function delcat(id, title) {
        if (confirm("Are you sure you want to delete '" + title + "'")) {
            window.location.href = 'categories.php?delcat=' + id;
        }
    }
</script>
<?php include("header.php");  ?>
<?php include("sidebar.php");  ?>

<div class="content">
    <?php 
        //show message from add / edit page
        if(isset($_GET['action'])){ 
            echo '<h3>Category '.$_GET['action'].'.</h3>'; 
        } 
    ?>
        <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">Categories</header>
                    <table class="table table-striped table-advance table-hover">
                        <tbody>
                        <tr>
                            <th><i class="icon_profile"></i> Title</th>
                            <th><i class="icon_cogs"></i> Update</th>
                            <th><i class="icon_cogs"></i> Delete</th>
                        </tr>
        <?php
            try {
                $stmt = $db->query('SELECT cat_id, cat_name, cat_slug FROM category ORDER BY cat_name DESC');
                while($row = $stmt->fetch()){
                    echo '<tr>';
                    echo '<td>'.$row['cat_name'].'</td>';
        ?>
                <td><a class="btn btn-primary" href="edit-blog-category.php?id=<?php echo $row['cat_id'];?>">Edit</a></td>
                <td><a class="btn btn-danger delbtn" href="javascript:delcat('<?php echo $row['cat_id'];?>','<?php echo $row['cat_slug'];?>')">Delete</a>
                </td>

        <?php 
                echo '</tr>';
                }
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        ?>

        </table>
        </section>
    </div>
    <a class="btn btn-default" href='add-blog-category.php'>Add New Category</a>

</div>
</div>
<?php include("footer.php");  ?>