<?php
	// Start session
	session_start();
?>

<!DOCTYPE html>
<html id="E-BOT-HTML" lang="en">
	<head>
		<title>E-ssue</title>
		<?php
			$page = 'e-bot';
			include('../php/head.php');
		?>
	</head>
	<body id="E-BOT">
    <?php include('../php/navbar.php'); ?>
  	<div class="chat-container">
  		<div id="chat"></div>
  		<textarea id="userInput" placeholder="Type something to E-Bot..."></textarea>
  		<button id="clearBtn" onclick="clearChat()">Clear</button>
  		<button id="submitBtn" onclick="respondAI()">Chat</button>
  	</div>
  	<img src="../media/E-BOT.png" />
  	<script>
  		document.getElementById("chat").innerHTML += "<p class='bot'><span>E-Bot: The FAQ & QNA Artificial Intelligence Program.</span></p>";
  	</script>
	</body>
</html>
