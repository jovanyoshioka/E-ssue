<?php
  // used to determine which page user is on to make item on navbar active
  $pages = array("","","","",""); // # of items in array blank so class="active" is unique to $pages[x]
  if ($page == "home") {
    $pages[0] = 'active';
  } else if ($page == "about") {
    $pages[1] = 'active';
  } else if ($page == "contact") {
    $pages[2] = 'active';
  } else if ($page == "documentation") {
    $pages[3] = 'active';
  } else if ($page == "e-bot") {
    $pages[4] = 'active';
  }

  if(isset($_SESSION["email"])) {

    include("../php/getClasses.php");

    echo '
      <nav id="navbar">
        <ul id="navbar-group-0">
          <li class="'.$pages[0].'"><a href="home.php">Home</a></li>
          <div class="dropdown">
            <a class="dropbtn">Classes
              <i class="fa fa-caret-down"></i>
            </a>
            <div class="dropdown-content">
              '.$classes.'
              <a onclick="openModal(\'createClass-modal\',\'createClass-modal-overlay\')">Create a class</a>
            </div>
          </div>
          <li class="'.$pages[4].'"><a href="e-bot.php">E-Bot</a></li>
          <li class="'.$pages[3].'"><a href="documentation.php">Documentation</a></li>
          <li class="'.$pages[1].'"><a href="about.php">About</a></li>
          <li class="'.$pages[2].'"><a href="contact.php">Contact</a></li>
        </ul>
        <ul id="navbar-group-1">
          <li><a href="../php/logout.php">Logout</a></li>
        </ul>
      </nav>

      <div class="modal-overlay simple-modal-overlay" id="createClass-modal-overlay" onclick="closeModal(\'createClass-modal\', \'createClass-modal-overlay\')"></div>
      <div class="modal simple-modal" id="createClass-modal">
        <header>Create a Class<i class="fas fa-times" onclick="closeModal(\'createClass-modal\', \'createClass-modal-overlay\')"></i></header>
        <section>
          <form role="form" action="../php/createClass.php" method="POST">
            Class Name<br>
            <input type="text" name="className" required><br>
            Teacher ID<br>
            <input type="text" name="teacherID" value="'.$_SESSION["teacherCode"].'" disabled><br>
            <input type="submit" value="Create">
          </form>
        </section>
      </div>
    ';
  } else {
    echo '
      <nav id="navbar">
        <ul>
          <li class="'.$pages[0].'"><a href="home.php">Home</a></li>
          <li class="'.$pages[4].'"><a href="e-bot.php">E-Bot</a></li>
          <li class="'.$pages[3].'"><a href="documentation.php">Documentation</a></li>
          <li class="'.$pages[1].'"><a href="about.php">About</a></li>
          <li class="'.$pages[2].'"><a href="contact.php">Contact</a></li>
        </ul>
        <ul>
          <li><a onclick="openModal(\'register-modal\',\'register-modal-overlay\')">Register</a></li>
          <li><a onclick="openModal(\'login-modal\',\'login-modal-overlay\')">Login</a></li>
        </ul>
      </nav>

      <div class="modal-overlay credentials-modal-overlay" id="register-modal-overlay" onclick="closeModal(\'register-modal\', \'register-modal-overlay\')"></div>
      <div class="modal credentials-modal" id="register-modal">
        <header>Register<i class="fas fa-times" onclick="closeModal(\'register-modal\', \'register-modal-overlay\')"></i></header>
        <section>
          <form role="form" action="home.php" method="POST">
            Email <p id="registerEmail-errorMessage"></p>
            <input type="email" name="email" id="register-email" placeholder="example@example.com" oninput="regCheckEmail()" required>
            First Name<br>
            <input type="text" name="fName" id="register-fName" oninput="regCheckFName()" required>
            Last Name<br>
            <input type="text" name="lName" id="register-lName" oninput="regCheckLName()" required>
            Password <p id="registerPasswords-errorMessage"></p>
            <input type="password" name="password" id="register-password" oninput="regCheckPasswords()" required>
            Re-type Password<br>
            <input type="password" name="repassword" id="register-repassword" oninput="regCheckPasswords()" required>

            <input type="submit" value="Submit">
          </form>
        </section>
        <footer><a href="policies.php">Have a problem registering? Click here!</a></footer>
      </div>

      <div class="modal-overlay credentials-modal-overlay" id="login-modal-overlay" onclick="closeModal(\'login-modal\', \'login-modal-overlay\')"></div>
      <div class="modal credentials-modal" id="login-modal">
        <header>Login<i class="fas fa-times" onclick="closeModal(\'login-modal\', \'login-modal-overlay\')"></i></header>
        <section>
          <form role="form" action="home.php" method="POST">
            Email<br>
            <input type="email" name="email" placeholder="example@example.com" required><br>
            Password<br>
            <input type="password" name="password" required><br>
            <input type="submit" value="Login">
          </form>
        </section>
        <footer><a href="policies.php">Have a problem logging in? Click here!</a></footer>
      </div>
    ';
  }
?>
