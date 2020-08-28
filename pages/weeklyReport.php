<?php
  // Start session
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>E-ssue</title>
    <?php
      $page = 'weeklyReport';
      include('../php/head.php');
    ?>
  </head>
  <body id="weeklyReport">
    <?php include('../php/getClassName.php'); ?>

    <?php include('../php/navbar.php'); ?>

    <br>
    <a href="class.php?classID=<?php echo $_GET["classID"] ?>"><button class="weeklyReportBtn">Return to Class</button></a>
    <button class="weeklyReportBtn" onclick="window.print()">Save/Print Report</button>

    <br>
    <h1>Weekly Report // Generated on <span id="timeGenerated"></span>.</h1>
    <table>
      <tr>
        <th>E-books</th>
        <th>Students</th>
        <th>Redemption Codes</th>
      </tr>

      <?php
        include('../php/generateWeeklyReport.php');
        echo $weeklyReport;
      ?>
    </table>
    <script>
        generateDate();
    </script>
  </body>
</html>
