<?php
  // Start session
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>E-ssue</title>
    <?php
      $page = 'documentation';
      include('../php/head.php');
    ?>
  </head>
  <body id="documentation">
    <?php include('../php/navbar.php'); ?>
    <iframe src="../media/user_guide.pdf"></iframe>
  </body>
</html>
