<div class="collapse navbar-collapse navbar-ex1-collapse">

<ul class="nav navbar-nav side-nav">    
  <li><h3>Quick Shorcut</h3></li>

  <li><a href="http://localhost/GeekHub/admin/index.php"><i class="fa fa-globe"></i> View Articles</a></li>
  <li><a href="http://localhost/GeekHub/admin/add-blog.php"><i class="fa fa-list-ol"></i> Add New Blog Post</a></li>
  <li><a href="http://localhost/GeekHub/admin/blog-categories.php"><i class="fa fa-list-ol"></i> View Categories</a></li>
  <li><a href="http://localhost/GeekHub/admin/add-blog-category.php"><i class="fa fa-list-ol"></i> Add New Category</a></li>
  <li><a href="http://localhost/GeekHub/admin/blog-users.php"><i class="fa fa-list-ol"></i> View Users</a></li>
  <li><a href="http://localhost/GeekHub/admin/add-blog-page.php"><i class="fa fa-list-ol"></i> Add New Page</a></li>
  <li><a href="http://localhost/GeekHub/admin/blog-pages.php"><i class="fa fa-list-ol"></i> View Pages</a></li>
  <li><a href="http://localhost/GeekHub/admin/add-blog-user.php"><i class="fa fa-list-ol"></i> Add New Users</a></li>
  <li><a href="http://localhost/GeekHub/index.php"><i class="fa fa-list-ol"></i> Visit Blog</a></li>

  <?php 
    $sql = $db->query('select count(*) from blog')->fetchColumn(); 
  echo '<li><h3>Total Posted '.'<font color="red">'.$sql.'</font>'.'</h3></li>';
  ?>

  </ul>
</div>
</nav>