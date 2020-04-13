<!--
    Our "About" page, linked from the menu bar.
    Only added basic text so far -- styling needed.
  -->
<?php
session_start();
// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');

$page_title ='About';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('meta.php'); ?>
    <?php include('header.php'); ?>
    
    <link rel="stylesheet" href="css/about.css">
    <script type="text/javascript" src="js/about.js"></script>
  </head>
  <body>
    <?php include('nav.php'); ?>
    <h1 class="pageTitle">About Our Site</h1>
     
    <!--
      We can add more things if we feel like it, personal pictures etc.
    -->
    <div id="aboutTop">
      <p>COMP 3512-001 Winter 2020</p>
      <p>Professor Randy Connolly</p>
      <p>Mount Royal University</p>
      <p><a href="https://github.com/eightys3v3n/comp3512_asg2" id="gitLink">Github repo</a></p>
      <p id="desc">This is our movie database site</p>
    </div>

    <ul class="aboutList">
      <li>
        <p id="aboutName">Max Tiblenko</p>
        <p>Contact: <a href="mailto:mtibl397@mtroyal.ca" id="emLink">mtibl397@mtroyal.ca</a></p>
        <a href="https://github.com/MAXL4RD" id="gitLink">Link to Personal Github</a>
      </li>

      <li>
        <p id="aboutName">Terrence Plunkett</p>
        <p class="perLink">Contact: <a href="mailto:tplun878@mtroyal.ca" id="emLink">tplun878@mtroyal.ca</a></p>
        <a href="https://github.com/eightys3v3n/" id="gitLink">Link to Personal Github</a>
      </li>

      <li>
        <p id="aboutName">Daniel Collins</p> 
        <p>Contact: <a href="mailto:danielmcollins1996@gmail.com" id="emLink">danielmcollins1996@gmail.com</a></p>
        <a href="https://github.com/DanielCollins96" id="gitLink">Link to Personal Github</a>
      </li>

      <li>
        <p id="aboutName">Joseph Power Romero</p> 
        <p>Contact: <a href="mailto:rpowe271@mtroyal.ca" id="emLink">rpowe271@mtroyal.ca</a></p>
        <a href="https://github.com/rpowe271" id="gitLink">Link to Personal Github</a>
      </li>
    </ul>

    <?php include('footer.php'); ?>
  </body>
</html>
