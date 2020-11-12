<?php require_once('includes/config.php'); ?>
<?php include("head.php");  
$searching = '';
?>
<title>GeekHub Blog</title>

<?php include("header.php");  ?>
<li class="divider-vertical"></li>
        <li>
            <form action="" method="post" class="navbar-search">
                <input type="text" name="search[keyword]" value="<?php echo $searching; ?>" placeholder="Search" id="keyword" class="form-control">
            </form>
        </li>
</ul>
<script id="dsq-count-scr" src="//localhost-yervjmnvbu.disqus.com/count.js" async></script>
<?php include("sidebar.php");  ?>

<style>
.pagination_btn{
  margin-right:9px;
  padding:1px 5px;
  color:#FEFEFE;
   border: #009900 1px solid; 
   background:#66ad44;
    border-radius:4px;
    cursor:pointer;

}
.pagination_btn:hover{background:#010000;}
.pagination_btn.current{background:#FC0527;}
</style>
<?php   
        define("PER_PAGE_LIMIT",10); //Set blog posts limit
        
        if(!empty($_POST['search']['keyword'])) {
            $searching = $_POST['search']['keyword'];
        }
    /* PHP Blog Search*/
        $search_query = 'SELECT * FROM  blog WHERE blog_title LIKE :keyword OR blog_desp LIKE :keyword OR blog_tags LIKE :keyword OR blog_content LIKE :keyword ORDER BY blog_id DESC ';
    
        /* PHP Blog Pagination*/
        $per_page_item = '';
        $page = 1;
        $start=0;
        if(!empty($_POST["page"])) {
            $page = $_POST["page"];
            $start=($page-1) * PER_PAGE_LIMIT;
        }

        $limit=" limit " . $start . "," . PER_PAGE_LIMIT;
        $pagination_stmt = $db->prepare($search_query);
        $pagination_stmt->bindValue(':keyword', '%' . $searching . '%', PDO::PARAM_STR);
        $pagination_stmt->execute();

        $row_count = $pagination_stmt->rowCount();
        if(!empty($row_count)){
            $per_page_item .= '<div style="text-align:center;margin:0px 0px;">';
            $page_count=ceil($row_count/PER_PAGE_LIMIT);
            if($page_count>1) {
                for($i=1;$i<=$page_count;$i++){
                    if($i==$page){
                        $per_page_item .= '<input type="submit" name="page" value="' . $i . '" class="pagination_btn current">';
                    } 
                    else {
                        $per_page_item .= '<input type="submit" name="page" value="' . $i . '" class="pagination_btn">';
                    }
                }
            }
            $per_page_item .= "</div>";
        }
        $query = $search_query.$limit;
        $pdo_stmt = $db->prepare($query);
        $pdo_stmt->bindValue(':keyword', '%' . $searching . '%', PDO::PARAM_STR);
        $pdo_stmt->execute();
        $result = $pdo_stmt->fetchAll();
    ?>
<div class="container">
    <div class="row">

    

    <?php
    if(!empty($result)) { 
        echo '<div class="col-sm-9">';
        foreach($result as $row) {
    ?>
    <?php
            echo '<div class="row">
                    <div class="col-xs-12">';
            echo '<h2><a href="'.$row['blog_slug'].'">'.$row['blog_title'].'</a></h2>';
            echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['blog_datetime'])).' in ';
            $stmt2 = $db->prepare('SELECT cat_name, cat_slug   FROM category, cat_blog WHERE category.cat_id = cat_blog.cat_id AND cat_blog.blog_id = :blog_id');
            $stmt2->execute(array(':blog_id' => $row['blog_id']));
            $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $links = array();
            foreach ($catRow as $cat){
                $links[] = "<a href='category/".$cat['cat_slug']."'>".$cat['cat_name']."</a>";
            }
            echo implode(", ", $links);
            echo '</p>';
            echo '<p>Tagged as: ';
                $links = array();
                $parts = explode(',', $row['blog_tags']);
                foreach ($parts as $tags)
                {
                    $links[] = "<a href='tag/".$tags."'>".$tags."</a>";
                }
                echo implode(", ", $links);
            echo '</p>';
            echo '<br>';
            echo '<p>'.$row['blog_desp'].'</p>'; 
            echo '<button class="btn-group-sm"><a href="'.$row['blog_slug'].'"><i class="fa fa-plus"></i> Read Full Story</a></button>';
            echo '<hr>';
        ?>
        <?php
        }
    }
    else{ 
    echo "No results found for ". $searching;
    } 
    ?>
        
       </div>
    </div>
 </div>
 <?php echo $per_page_item; ?>
<?php //footer content 
include("footer.php");  ?>