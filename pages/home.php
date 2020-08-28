<?php
	// Start session
	session_start();

  if (!empty($_POST["repassword"])) { // register form submitted
    include("../php/register.php");
  } else if (!empty($_POST["email"])) { // login form submitted
  	include("../php/login.php");
  }

  // Error handling for unsuccessful register
  if($noMatch || $eExists) {
  	$errorMessage = " ";
    if ($noMatch) {
			$errorMessage .= "Passwords do not match! Please try again.";
    }
    if ($eExists) {
      $errorMessage .= "Email already attached to another account! Please input another.";
    }

    echo '
      <div id="errorNotification" class="errorNotification">
				<div class="errorNotification-message">
					<h1>An error has occurred.</h1>
					<p>'.$errorMessage.'</p>
				</div>
				<div class="errorNotification-button">
					<i class="fas fa-times" onclick="closeErrorNotification()"></i>
				</div>
			</div>
    ';
  } else if ($noEmail || $noPass) {
  	$errorMessage = " ";
  	if ($noEmail) {
  		$errorMessage .= "Invalid email entered! Please try again.";
  	}
  	if ($noPass) {
  		$errorMessage .= "Incorrect password! Please try again.";
  	}

  	echo '
      <div id="errorNotification" class="errorNotification">
				<div class="errorNotification-message">
					<h1>An error has occurred.</h1>
					<p>'.$errorMessage.'</p>
				</div>
				<div class="errorNotification-button">
					<i class="fas fa-times" onclick="closeErrorNotification()"></i>
				</div>
			</div>
    ';
  }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>E-ssue</title>
		<?php
			$page = 'home';
			include('../php/head.php');
		?>
	</head>
	<body id="home">
    <?php include('../php/navbar.php'); ?>
    <div class="info">
    	<h1>Welcome to E-ssue!</h1>
	    <p>A web application designed to manage the issuance of E-books to classes of students.</p>
	    <button onclick="openModal('register-modal','register-modal-overlay')">Get Started</button>
    </div>
    <div class="tabletSVG-container">
    	<!-- FILL -->
    	<svg viewBox="0 0 70 80" class="tabletSVG" id="tabletSVG-Fill">
    		<path d="M1,8 Q1.5,2 7.5,2 L62,2 Q66.5,2 67,7 L67,74 Q67,78 61,78 L5,78 Q1,78 1,74 L1,8" fill="#333333" stroke="none"></path> <!-- 3d outer rim of tablet -->
    		<path d="M1,8 Q1,4 5,4 L61,4 Q65,4 65,8 L65,68 1,68 1,8" fill="#FFFFFF" stroke="none"></path> <!-- outer rim of tablet -->

    		<path d="M61,4 Q49.5,60 35,68 Q40,57 15,53 Q40,49 60.5,4 L61,4" fill="#F0F0F0" stroke="none"></path> <!-- page turn -->

    		<path d="M65.6,20 L66.4,19.5 L66.4,24.25 L65.6,24.75 L65.6,20" fill="#444444" stroke="none"></path> <!-- power button -->
    		<circle cx="32" cy="73" r="2" fill="#444444" stroke="none" /> <!-- home button -->
			</svg>
			<!-- OUTLINE -->
    	<svg viewBox="0 0 70 80" class="tabletSVG" id="tabletSVG-Outline">
    		<path d="M1,8 Q1,4 5,4 L61,4 Q65,4 65,8 L65,74 Q65,78 61,78 L5,78 Q1,78 1,74 L1,8" id="tabletLine-rim"></path> <!-- outer rim of tablet -->
    		<path d="M1,8 Q1.5,2 7.5,2 L62,2 Q66.5,2 67,7 L67,74 Q67,78 61,78" id="tabletLine-3dRim"></path> <!-- 3d outer rim of tablet -->

    		<path d="M1,68 L65,68" id="tabletLine-quarterDiv"></path> <!-- tablet "quarter" division -->
    		<path d="M65,68 L67,66.5" id="tabletLine-3dQuarterDiv"></path> <!-- 3d tablet "quarter" division -->

    		<path d="M61,4 Q49.5,60 35,68 Q40,57 15,53 Q40,49 60.5,4 L61,4" id="tabletLine-pageTurn"></path> <!-- page turn -->

    		<path d="M5,8 Q7,9 9,8 T13,8 17,8 21,8 25,8 29,8 33,8 37,8 41,8 45,8 49,8 53,8 57,8" id="tabletLine-1"></path> <!-- scribbles 1 -->
    		<path d="M9,12 Q11,13 13,12 T17,12 21,12 25,12" id="tabletLine-2-1"></path> <!-- scribbles 2 part 1 -->
    		<path d="M29,12 Q31,13 33,12 T37,12 41,12 45,12 49,12 53,12" id="tabletLine-2-2"></path> <!-- scribbles 2 part 2 -->
    		<path d="M5,16 Q7,17 9,16 T13,16 17,16 21,16 25,16 29,16 33,16" id="tabletLine-3-1"></path> <!-- scribbles 3 part 1 -->
    		<path d="M41,16 Q43,17 45,16 T49,16" id="tabletLine-3-2"></path> <!-- scribbles 3 part 2 -->
    		<path d="M5,20 Q7,21 9,20 T13,20" id="tabletLine-4-1"></path> <!-- scribbles 4 part 1 -->
    		<path d="M21,20 Q23,21 25,20 T29,20 33,20 37,20 41,20 45,20 49,20" id="tabletLine-4-2"></path> <!-- scribbles 4 part 2 -->
    		<path d="M13,24 Q15,25 17,24 T21,24 25,24 29,24 33,24 37,24 41,24 45,24" id="tabletLine-5"></path> <!-- scribbles 5 -->
    		<path d="M5,28 Q7,29 9,28 T13,28 17,28" id="tabletLine-6-1"></path> <!-- scribbles 6 part 1 -->
    		<path d="M25,28 Q27,29 29,28 T33,28 37,28 41,28 45,28" id="tabletLine-6-2"></path> <!-- scribbles 6 part 2 -->
    		<path d="M9,32 Q11,33 13,32 T17,32 21,32 25,32 29,32 33,32 37,32 41,32" id="tabletLine-7"></path> <!-- scribbles 7 -->
    		<path d="M5,36 Q7,37 9,36 T13,36 17,36 21,36 25,36 29,36 33,36 37,36" id="tabletLine-8"></path> <!-- scribbles 8 -->
    		<path d="M9,40 Q11,41 13,40 T17,40 21,40 25,40 29,40 33,40" id="tabletLine-9"></path> <!-- scribbles 9 -->
    		<path d="M5,44 Q7,45 9,44 T13,44 17,44 21,44 25,44 29,44" id="tabletLine-10"></path> <!-- scribbles 10 -->
    		<path d="M5,48 Q7,49 9,48 T13,48 17,48 21,48 25,48" id="tabletLine-11"></path> <!-- scribbles 11 -->
    		<path d="M5,52 Q7,53 9,52 T13,52" id="tabletLine-12"></path> <!-- scribbles 12 -->
    		<path d="M5,56 Q7,57 9,56 T13,56 17,56 21,56 25,56" id="tabletLine-13"></path> <!-- scribbles 13 -->
    		<path d="M5,60 Q7,61 9,60 T13,60 17,60 21,60 25,60 29,60" id="tabletLine-14"></path> <!-- scribbles 14 -->
    		<path d="M9,64 Q11,65 13,64 T17,64 21,64 25,64 29,64 33,64" id="tabletLine-15"></path> <!-- scribbles 15 -->

    		<path d="M61,8 Q62.5,9 64,8" id="tabletLine-r1"></path>
    		<path d="M61,13 Q62.5,12 64,13" id="tabletLine-r2"></path>
    		<path d="M61,16 Q62.5,17 64,16" id="tabletLine-r3"></path>
    		<path d="M60,20 Q61.5,21 63,20" id="tabletLine-r4"></path>
    		<path d="M58,24 Q61.5,25 63,24" id="tabletLine-r5"></path>
    		<path d="M56,28 Q58,29 60,28 T62,28" id="tabletLine-r6"></path>
    		<path d="M56,32 Q58,31 60,32 T62,32" id="tabletLine-r7"></path>
    		<path d="M56,36 Q58,37 60,36 T62,36" id="tabletLine-r8"></path>
    		<path d="M54,40 Q56,39 58,40 T62,40" id="tabletLine-r9"></path>
    		<path d="M54,44 Q56,45 58,44 T62,44" id="tabletLine-r10"></path>
    		<path d="M54,48 Q56,47 58,48 T62,48" id="tabletLine-r11"></path>
    		<path d="M50,52 Q52,53 54,52 T58,52 62,52" id="tabletLine-r12"></path>
    		<path d="M50,56 Q52,57 54,56 T58,56 62,56" id="tabletLine-r13"></path>
    		<path d="M46,60 Q48,61 50,60 T54,60 58,60 62,60" id="tabletLine-r14"></path>
    		<path d="M42,64 Q44,65 46,64 T50,64 54,64 58,64, 62,64" id="tabletLine-r15"></path>

    		<path d="M65.6,20 L66.4,19.5 L66.4,24.25 L65.6,24.75 L65.6,20" stroke-width="0.2" id="tabletLine-powerButton"></path> <!-- power button -->
    		<circle cx="32" cy="73" r="2" id="tabletLine-homeButton" /> <!-- home button -->
			</svg>
  	</div>
	</body>
</html>
