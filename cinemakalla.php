<?php
session_start();
//cant bypass
include('keselamatan.php');
//connect
require_once('connection.php')

?>
<!DOCTYPE html>
<html>
<head>
  <title>MMU Cinemas Sdn Bhd</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
  <link href="//db.onlinewebfonts.com/c/0686a7a9dc5f6bd5f555298d801d88ac?family=Brody" rel="stylesheet" type="text/css"/>
</head>

<body>

  <div id="wrapper">
  <div id="header">
   <?php include('header.php');?>
  </div>


<div id="menu">
  <?php
include('menu.php')
  ?>

</div>


  <div id="main">

  <h1 align= center>Latest Movies Favoured By Customers!</h1>
  <table id= "cinema" border = "1" cellpadding = 0px; style="background-color: white; color: black;">
    <tr style="background-color: black; color: white;">
      <td>Film Name</td>
      <td>Poster</td>
      <td>Short Description</td>

    </tr>
    <tr>
    <td width= 10%;>Keanue Reeves GOAT</td>
      <td width= 25%; height= 10%><img src="johnwick4.jpeg" height=90%  width=95%></td>
      <td align = "left">John Wick: Chapter 3 – Parabellum is a 2019 American neo-noir action-thriller film starring Keanu Reeves as the eponymous character. It is the third installment in the John Wick film series, following John Wick (2014) and John Wick: Chapter 2 (2017). The film is directed by Chad Stahelski and written by Derek Kolstad, Shay Hatten, Chris Collins, and Marc Abrams, based on a story by Kolstad.</td>

    </tr>
    <tr>
    <td>Avengers: New Game</td>
    <td width= 300px; height= 200px><img src="avengers.jpeg" height=90%  width=95%></td>
      <td  align = "left">Avengers: Endgame is a 2019 American superhero film based on the Marvel Comics superhero team the Avengers, produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures. It is the direct sequel to Avengers: Infinity War (2018) and the 22nd film in the Marvel Cinematic Universe (MCU). </td>

    </tr>
    <tr>
    <td>Boyka Disputed</td>
    <td width= 300px; height= 200px><img src="boyka4.jpeg" height=90%  width=95%></td>
      <td align = "left">In the fourth installment of the fighting franchise, Boyka is shooting for the big leagues when an accidental death in the ring makes him question everything he stands for. When he finds out the wife of the man he accidentally killed is in trouble, Boyka offers to fight in a series of impossible battles to free her from a life of servitude.</td>

    </tr>

  </table>

</div>

<!--Tutup wrapper-->
</div>

<footer id="footer">

<?php
include('footer.php')
?>

</footer>
</body>
<script>
  function checkdelete(){
    return confirm('Delete thir record?');
  }

  function checklogout(){
    return confirm('Log Out?');
  }
</script>

</html>
