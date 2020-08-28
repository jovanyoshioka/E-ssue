<?php
  include("sqlConnect.php");

  // Check if passwords match and if there is a contact; redirect back to signup page if they do not match
  if ($_POST["password"] != $_POST["repassword"]) {
    $noMatch = true;
  } else {
    $email = $_POST["email"];

    // Check if account with same email is already existant
    $sql = $conn->prepare("SELECT ID FROM Users WHERE Email=?");
    $sql->bind_param("s",$email);
    $sql->execute();
    $result = $sql->get_result();

    // Make sure user does not exist; redirect back to signup page if it does
    if ($result->num_rows > 0) {
      $eExists = true;
    } else {
      // Continuously generate a new teacher code until an unused one is available
      do {
        // Generate teacher code not already existant
        $teacherCode = rand(100000000, 999999999);

        // Check if account with same teacherCode is already existant
        $sql = $conn->prepare("SELECT ID FROM Users WHERE TeacherCode=?");
        $sql->bind_param("i",$teacherCode);
        $sql->execute();
        $result = $sql->get_result();
      } while ($result->num_rows > 0);

      // Get first name and last name
      $fName = $_POST["fName"];
      $lName = $_POST["lName"];

      // Encrypt password for security
      $pass = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost" => 10]);

      // Add user to database
      $sql = $conn->prepare("INSERT INTO Users (Email,Password,FirstName,LastName,TeacherCode) VALUES (?,?,?,?,?);");
      $sql->bind_param("ssssi",$email,$pass,$fName,$lName,$teacherCode);
      $sql->execute();

      // Get ID associated with the user
      $sql = $conn->prepare("SELECT ID FROM Users WHERE Email=?");
      $sql->bind_param("s",$email);
      $sql->execute();
      $result = $sql->get_result();
      $result = $result->fetch_assoc();
      $userID = $result["ID"];

      // Set commonly referenced session variables so database is not referred to too often
      $_SESSION["id"] = $userID;
      $_SESSION["email"] = $email;;
      $_SESSION["firstName"] = $fName;
      $_SESSION["lastName"] = $lName;
      $_SESSION["teacherCode"] = $teacherCode;
    }
  }

  $conn->close();
?>
