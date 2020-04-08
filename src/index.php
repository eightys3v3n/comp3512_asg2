<!--
    This is the home page. For non-logged in users it has a search box,
    login button, and logout button.
    For logged in users it has a bunch of stuff. See TODO.md
  -->
<?php
session_start();

// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');

include 'db-helpers.inc.php';

$page_title ='Home - Movies';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('meta.php'); ?>
    <?php include('header.php'); ?>
    
    <link rel="stylesheet" href="css/index.css">
    <script type="text/javascript" src="js/index.js"></script>
  </head>
  <body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>
    
    <?php
       if (isset($_SESSION['u_id'])) {
           $user = getUserInfo($_SESSION['u_id']);
     ?>
     <section id="content">
       <div id="user_info">
       <?php
           echo "<span>First Name: </span><span>".$user['firstname']."</span>";
           echo "<span>Last Name: </span><span>".$user['lastname']."</span>";
           echo "<span>City: </span><span>".$user['city']."</span>";
           echo "<span>Country: </span><span>".$user['country']."</span>";
           echo "<span>E-Mail: </span><span>".$user['email']."</span>";
       ?>
       </div>
       <div id="search">
         <form id="search" method="get" action="browse-movies.php">
           <input type="text" placeholder="Title" name="title">
           <input type="submit" value="Search">
         </form>  
       </div>
       <div id="favorites">
       
        <?php
        if (isset($_SESSION["u_id"]) && count($_SESSION['fav_movies']) > 0)
        {
            $hi = count($_SESSION['fav_movies']);
            
            if (isset($_SESSION['fav_movies']))
            {
                $user_id = $_SESSION["u_id"];
                $fav_movies = $_SESSION['fav_movies'];

                foreach($fav_movies as $mov)
                {
                    echo "<div class='fav_movie'>";
                    echo "<h3><a href='single-movie.php?id=" . $mov['id'] . "' >" . $mov['title'] . "</a></h3>". "<br>";
                    echo "<a href='single-movie.php?id=" . $mov['id'] . "'><img src='https://image.tmdb.org/t/p/w92/". $mov['poster'] . "' /></a>";
                    echo "<form action='' method='post'>"; 
                    echo "<input type='submit' name='hi' id='" . $mov['id'] . "' value='Remove From Favorites' />";
                    echo "</form>";
                    echo "</div>";
                }
            }
        }
        ?>
        
       </div>
       <div id="recommendations">
         I recommend you go watch some movies
       </div>
     </section>
     <?php      
       } else {
           ?>You are not logged in :(<?php
       }
     ?>
    
    <?php include('footer.php'); ?>
  </body>
</html>
