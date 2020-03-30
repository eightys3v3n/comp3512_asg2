<!--
    Our "About" page, linked from the menu bar.
    Only added basic text so far -- styling needed.
  -->
<?php $page_title ='About'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('meta.php'); ?>
    
    <link rel="stylesheet" href="css/about.css">
    <script type="text/javascript" src="js/about.js"></script>
  </head>
  <body>
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>
     
    <h1 class="pageTitle">About Our Site</h1>
    <!--
        We can add more things if we feel like it, personal pictures etc.
    -->
    <div id="aboutTop">
      <p>COMP 3512-001 Winter 2020</p>
      <p>Professor Randy Connolly</p>
      <p>Mount Royal University</p>
      <p><a href="https://github.com/eightys3v3n/comp3512_asg2" id="gitLink">Access Our Github Here!</a></p>
      <p id="desc">This is our movie database site...</p>
    </div>

    <ul class="aboutList">
      <li>
        <p id="aboutName">Max Tiblenko</p>
        <p>Contact: <a href="mailto:mtibl397@mtroyal.ca">mtibl397@mtroyal.ca</a></p>
        <a href="https://github.com/MAXL4RD">Link to Personal Github</a>
      </li>

      <li>
        <p id="aboutName">Terrence Plunkett</p>
        <p class="perLink">Contact: <a href="mailto:tplun878@mtroyal.ca">tplun878@mtroyal.ca</a></p>
        <a href="https://github.com/eightys3v3n/">Link to Personal Github</a>
      </li>

      <li>
        <p id="aboutName">Daniel Collins</p> 
        <p>Contact: <a href="mailto:danielmcollins1996@gmail.com">danielmcollins1996@gmail.com</a></p>
        <a href="https://github.com/DanielCollins96">Link to Personal Github</a>
      </li>

      <li>
        <p id="aboutName">Joseph Power Romero</p> 
        <p>Contact: <a href="mailto:rpowe271@mtroyal.ca">rpowe271@mtroyal.ca</a></p>
        <a href="https://github.com/rpowe271">Link to Personal Github</a>
      </li>
    </ul>

    <?php include('footer.php'); ?>
  </body>
</html>
