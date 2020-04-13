<!--
    This is for the navigation bar that is loaded on every page. It goes in <body> at the beginning.
  -->
    <header>
      <a href="index.php" class="brand-logo">Home</a>
        <nav class="navbar">
          <button class="navbar-toggle">
            <span></span>
            <span></span>
            <span></span>
          </button>
          <ul class="nav-list">
            <li><a href="about.php">About</a></li>
            <li><a href='browse-movies.php'>Browse Movies</a></li>  
            <?php
            if (!isset($_SESSION['u_id'])){
                echo  "<li><a href='login.php'>Login</a></li>";
                echo  "<li><a href='sign-up.php'>Sign-Up</a></li>";

            } else {
                //echo  "<li><a href='browse-movies.php'>Browse Movies</a></li>";
                echo  "<li><a href='favorites.php'>Favorites</a></li>";
                echo  "<li><a href='logout.php'>Logout</a></li>";
            }

            ?>
          </ul>
      </nav>
      </header>
