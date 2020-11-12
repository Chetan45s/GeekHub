
<div class="collapse navbar-collapse navbar-ex1-collapse">


<ul class="nav navbar-nav side-nav">    
<li class="dropdown messages-dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Recent Articles <b class="caret"></b></a>
    <ul class="dropdown-menu">
    <?php
        $sidebar = $db->query('SELECT blog_title, blog_slug FROM blog ORDER BY blog_id DESC LIMIT 6');
        while($row = $sidebar->fetch()){
        echo ' <li >';
        echo ' <a href="http://localhost/GeekHub/'.$row['blog_slug'].'" >';
                    echo '<span class="message">'.$row['blog_title'].'</span>';
               echo '</a>';
               echo '</li>';
               echo '<li class="divider"></li>';
        }
    ?>
    </ul>
</li>

<li class="dropdown messages-dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tasks"></i> Categories <b class="caret"></b></a>
    <ul class="dropdown-menu">
    <?php
        $stmt = $db->query('SELECT cat_name, cat_slug FROM category ORDER BY cat_id DESC');
        while($row = $stmt->fetch()){
        echo ' <li >';
        echo ' <a href="http://localhost/GeekHub/category/'.$row['cat_slug'].'" >';
                    echo '<span class="message">'.$row['cat_name'].'</span>';
               echo '</a>';
               echo '</li>';
               echo '<li class="divider"></li>';
        }
    ?>
    </ul>
</li>

<li class="dropdown messages-dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list-ul"></i> Tags <b class="caret"></b></a>
    <ul class="dropdown-menu">
    <?php
        $tagsArray = [];
        $stmt = $db->query('select distinct LOWER(blog_tags) as blog_tags from blog where blog_tags != "" group by blog_tags');
        while($row = $stmt->fetch()){
            $parts = explode(',', $row['blog_tags']);
            foreach ($parts as $tag) {
                $tagsArray[] = $tag;
            }
        }

        $finalTags = array_unique($tagsArray);
        foreach ($finalTags as $tag) {
        echo ' <li >';
        echo ' <a href="http://localhost/GeekHub/tag/'.$tag.'" >';
                    echo '<span class="message">'.ucwords($tag).'</span>';
               echo '</a>';
               echo '</li>';
        }
    ?>
    </ul>
</li>


<li><a href="http://localhost/GeekHub/discuss.php"><i class="fa fa-globe"></i> Discuss</a></li>
<li><a href="http://localhost/GeekHub/join.php"><i class="fa fa-list-ol"></i> Join us</a></li>
           
</ul>

</div>
</nav>