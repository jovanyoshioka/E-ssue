/******************
 * UNIVERSAL MODAL *
 ******************/
function openModal(modalID, modalOverlayID) { //opens modal with specified modal ID in function(arguments);
  /* without display: inline-block, modal will not run animation because it is initially display: none */
  document.getElementById(modalID).style.display = "inline-block";
  document.getElementById(modalOverlayID).style.display = "inline-block";
  document.getElementById(modalID).classList.remove("modal-close");
  document.getElementById(modalID).classList.add("modal-open");
  document.getElementById(modalOverlayID).classList.remove("modal-overlay-close");
  document.getElementById(modalOverlayID).classList.add("modal-overlay-open");
  document.getElementsByTagName("body")[0].style.overflowY = "hidden";
}

function closeModal(modalID, modalOverlayID) { //closes modal with specified modal ID in function(arguments);
  document.getElementById(modalID).classList.remove("modal-open");
  document.getElementById(modalID).classList.add("modal-close");
  document.getElementById(modalOverlayID).classList.remove("modal-overlay-open");
  document.getElementById(modalOverlayID).classList.add("modal-overlay-close");
  setTimeout(function() {
    document.getElementById(modalID).style.display = "none";
    document.getElementById(modalOverlayID).style.display = "none";
  }, 500);
  document.getElementsByTagName("body")[0].style.overflowY = "visible";
}
/**********************
 * ERROR NOTIFICATION *
 **********************/
function closeErrorNotification() {
  document.getElementById("errorNotification").style.opacity = 0.0;
  document.getElementById("errorNotification").style.display = "none";
}
/************
 * REGISTER *
 ************/
function regCheckEmail() {
  var element = document.getElementById("register-email");
  if (element.value.includes("@"))
  {
    element.style.border = "2px solid #17FF00";
    document.getElementById("registerEmail-errorMessage").innerHTML = "";
  }
  else if (element.value.length != 0)
  {
    element.style.border = "2px solid #FF5252";
    document.getElementById("registerEmail-errorMessage").innerHTML = "Invalid email entered!";
  }
  else
  {
    element.style.border = "none";
    document.getElementById("registerEmail-errorMessage").innerHTML = "";
  }
}
function regCheckFName() {
  var element = document.getElementById("register-fName");
  if (element.value.length > 0)
    element.style.border = "2px solid #17FF00";
  else
    element.style.border = "none";
}
function regCheckLName() {
  var element = document.getElementById("register-lName");
  if (element.value.length > 0)
    element.style.border = "2px solid #17FF00";
  else
    element.style.border = "none";
}
function regCheckPasswords() {
  var password = document.getElementById("register-password");
  var repassword = document.getElementById("register-repassword");

  if (password.value == repassword.value && password.value.length > 0)
  {
    password.style.border = "2px solid #17FF00";
    repassword.style.border = "2px solid #17FF00";
    document.getElementById("registerPasswords-errorMessage").innerHTML = "";
  }
  else if (password.value.length > 0 || repassword.value.length > 0)
  {
    password.style.border = "2px solid #FF5252";
    repassword.style.border = "2px solid #FF5252";;
    document.getElementById("registerPasswords-errorMessage").innerHTML = "Passwords do not match!";
  }
  else
  {
    password.style.border = "none";
    repassword.style.border = "none";
    document.getElementById("registerPasswords-errorMessage").innerHTML = "";
  }
}
/*********
 * CLASS *
 *********/
function setInterface(interfaceElement, type, classID) {
  if (interfaceElement == 'modalsInterface') {
    document.getElementById(interfaceElement).style.display = 'block';
    document.getElementById('dragAndDropInterface').style.display = 'none';
    document.getElementById('viewModalsInterface').style.backgroundColor = '#999999';
    document.getElementById('viewDragAndDropInterface').style.backgroundColor = 'buttonface';
  }
  else if (interfaceElement == 'dragAndDropInterface') {
    document.getElementById(interfaceElement).style.display = 'block';
    document.getElementById('modalsInterface').style.display = 'none';
    document.getElementById('viewDragAndDropInterface').style.backgroundColor = '#999999';
    document.getElementById('viewModalsInterface').style.backgroundColor = 'buttonface';
  }

  if (type) // true = reload url to have without the eBookID
    window.location.href = "class.php?classID=" + classID;
}
function setInterfaceHover(interfaceButton, color) {
  console.log(document.getElementById(interfaceButton).style.backgroundColor);
  if (document.getElementById(interfaceButton).style.backgroundColor != 'rgb(153, 153, 153)')
    document.getElementById(interfaceButton).style.backgroundColor = color;
}
function getEBookInfo(classID) {
  var eBookID = document.getElementById('eBooksDropdown').value;
  window.location.href = "class.php?classID=" + classID + "&eBookID=" + eBookID;
}
var elementIDDragged;
function allowDrop(e) {
  e.preventDefault();
}
function drag(id) {
  elementIDDragged = id;
}
function assign(e, classID) {
  e.preventDefault();
  var eBookID = document.getElementById('eBooksDropdown').value;

  if (eBookID !== "null" && document.getElementById(elementIDDragged).parentNode != document.getElementById("assigned-container")) {
    document.getElementById("assigned-container").appendChild(document.getElementById(elementIDDragged));
    // droparea - append to other element and re-append to original element to continue being the last child
    document.getElementById("notAssigned-container").appendChild(document.getElementById("assigned-droppable"));
    document.getElementById("assigned-container").appendChild(document.getElementById("assigned-droppable"));

    window.location.href = "../php/issueToStudent.php?classID=" + classID + "&eBookID=" + eBookID + "&studentID=" + elementIDDragged;
  }
}
function unassign(e, classID) {
  e.preventDefault();
  var eBookID = document.getElementById('eBooksDropdown').value;

  if (eBookID !== "null" && document.getElementById(elementIDDragged).parentNode != document.getElementById("notAssigned-container")) {
    document.getElementById("notAssigned-container").appendChild(document.getElementById(elementIDDragged));
    // droparea - append to other element and re-append to original element to continue being the last child
    document.getElementById("assigned-container").appendChild(document.getElementById("notAssigned-droppable"));
    document.getElementById("notAssigned-container").appendChild(document.getElementById("notAssigned-droppable"));

    window.location.href = "../php/withdrawStudent.php?classID=" + classID + "&eBookID=" + eBookID + "&studentID=" + elementIDDragged;
  }
}
function searchForStudent() {
  var search = document.getElementById("search").value;
  var allStudents = document.getElementsByClassName("draggableStudent");
  var allChildren;
  var children;
  var child;
  var studentName;
  for (var i = 0; i < allStudents.length; i++) {
    // get student name from child input (student name input)
    allChildren = allStudents[i].children;
    for (var j = 0; j < allChildren.length; j++) {
      children = allChildren[j].children;
      for (var k = 0; k < children.length; k++) {
        child = children[k];
        if (child.classList.contains("dragAndDrop-studentName")) {
          studentName = child.value;
        }
      }
    }
    // compare
    if (search.substr(0,search.length).toUpperCase() === studentName.substr(0,search.length).toUpperCase())
      allStudents[i].style.display = 'block';
    else
      allStudents[i].style.display = 'none';
  }
}
function tableSearchForStudent() {
  var search = document.getElementById("tableSearch").value;
  var allStudents = document.getElementsByClassName("tableStudentsRows");
  var children;
  var child;
  var studentName;
  for (var i = 0; i < allStudents.length; i++) {
    // get student name from child innerHTML (studentName)
    children = allStudents[i].children;
    for (var j = 0; j < children.length; j++) {
      child = children[j];
      if (child.classList.contains("tableStudentRow-Name")) {
        studentName = child.innerHTML;
      }
    }
    // compare
    if (search.substr(0,search.length).toUpperCase() === studentName.substr(0,search.length).toUpperCase()) {
      allStudents[i].style.display = 'table-row';
    } else {
      allStudents[i].style.display = 'none';
    }
  }
}
/*****************
 * WEEKLY REPORT *
 *****************/
function generateDate() {
  var month, day, year;
  var d = new Date();

  month = d.getMonth();
  switch (month)
  {
    case 0:
      month = "January";
      break;
    case 1:
      month = "February";
      break;
    case 2:
      month = "March";
      break;
    case 3:
      month = "April";
      break;
    case 4:
      month = "May";
      break;
    case 5:
      month = "June";
      break;
    case 6:
      month = "July";
      break;
    case 7:
      month = "August";
      break;
    case 8:
      month = "September";
      break;
    case 9:
      month = "October";
      break;
    case 10:
      month = "November";
      break;
    case 11:
      month = "December";
      break;
  }

  day = d.getDate();
  year = d.getFullYear();

  document.getElementById("timeGenerated").innerHTML = month + " " + day + ", " + year;
}
/*********
 * E-BOT *
 *********/
function getFirstWordAI(input) {
  var word = "";
  for (var index = 0; index < input.length; index++) {
    if (input.charAt(index) === ' ' || (input.charAt(index) !== 'A' && input.charAt(index) !== 'B' && input.charAt(index) !== 'C' && input.charAt(index) !== 'D' && input.charAt(index) !== 'E' && input.charAt(index) !== 'F' && input.charAt(index) !== 'G' && input.charAt(index) !== 'H' && input.charAt(index) !== 'I' && input.charAt(index) !== 'J' && input.charAt(index) !== 'K' && input.charAt(index) !== 'L' && input.charAt(index) !== 'M' && input.charAt(index) !== 'N' && input.charAt(index) !== 'O' && input.charAt(index) !== 'P' && input.charAt(index) !== 'Q' && input.charAt(index) !== 'R' && input.charAt(index) !== 'S' && input.charAt(index) !== 'T' && input.charAt(index) !== 'U' && input.charAt(index) !== 'V' && input.charAt(index) !== 'W' && input.charAt(index) !== 'X' && input.charAt(index) !== 'Y' && input.charAt(index) !== 'Z'))
      return word;
    else
      word += input.charAt(index);
  }
  return word;
}
function getSecondWordAI(input) {
  var word = "";
  var firstWordFound = false;
  for (var index = 0; index < input.length; index++) {
    if (!firstWordFound && (input.charAt(index) === ' ' || (input.charAt(index) !== 'A' && input.charAt(index) !== 'B' && input.charAt(index) !== 'C' && input.charAt(index) !== 'D' && input.charAt(index) !== 'E' && input.charAt(index) !== 'F' && input.charAt(index) !== 'G' && input.charAt(index) !== 'H' && input.charAt(index) !== 'I' && input.charAt(index) !== 'J' && input.charAt(index) !== 'K' && input.charAt(index) !== 'L' && input.charAt(index) !== 'M' && input.charAt(index) !== 'N' && input.charAt(index) !== 'O' && input.charAt(index) !== 'P' && input.charAt(index) !== 'Q' && input.charAt(index) !== 'R' && input.charAt(index) !== 'S' && input.charAt(index) !== 'T' && input.charAt(index) !== 'U' && input.charAt(index) !== 'V' && input.charAt(index) !== 'W' && input.charAt(index) !== 'X' && input.charAt(index) !== 'Y' && input.charAt(index) !== 'Z')))
      firstWordFound = true;
    else if (firstWordFound && (input.charAt(index) === ' ' || (input.charAt(index) !== 'A' && input.charAt(index) !== 'B' && input.charAt(index) !== 'C' && input.charAt(index) !== 'D' && input.charAt(index) !== 'E' && input.charAt(index) !== 'F' && input.charAt(index) !== 'G' && input.charAt(index) !== 'H' && input.charAt(index) !== 'I' && input.charAt(index) !== 'J' && input.charAt(index) !== 'K' && input.charAt(index) !== 'L' && input.charAt(index) !== 'M' && input.charAt(index) !== 'N' && input.charAt(index) !== 'O' && input.charAt(index) !== 'P' && input.charAt(index) !== 'Q' && input.charAt(index) !== 'R' && input.charAt(index) !== 'S' && input.charAt(index) !== 'T' && input.charAt(index) !== 'U' && input.charAt(index) !== 'V' && input.charAt(index) !== 'W' && input.charAt(index) !== 'X' && input.charAt(index) !== 'Y' && input.charAt(index) !== 'Z')))
      return word;
    else if (firstWordFound && (input.charAt(index) !== ' ' || (input.charAt(index) !== 'A' && input.charAt(index) !== 'B' && input.charAt(index) !== 'C' && input.charAt(index) !== 'D' && input.charAt(index) !== 'E' && input.charAt(index) !== 'F' && input.charAt(index) !== 'G' && input.charAt(index) !== 'H' && input.charAt(index) !== 'I' && input.charAt(index) !== 'J' && input.charAt(index) !== 'K' && input.charAt(index) !== 'L' && input.charAt(index) !== 'M' && input.charAt(index) !== 'N' && input.charAt(index) !== 'O' && input.charAt(index) !== 'P' && input.charAt(index) !== 'Q' && input.charAt(index) !== 'R' && input.charAt(index) !== 'S' && input.charAt(index) !== 'T' && input.charAt(index) !== 'U' && input.charAt(index) !== 'V' && input.charAt(index) !== 'W' && input.charAt(index) !== 'X' && input.charAt(index) !== 'Y' && input.charAt(index) !== 'Z')))
      word += input.charAt(index);
  }
  return word;
}
function scrollToBottom(chat) {
  chat.scrollTop = chat.scrollHeight;
}
var thankYouCounter = 0;
var inputType = "general";
function generalAI(chat, firstWord, secondWord, userInput) {
  var eBotResponse = "";
  if (firstWord === "HI" || firstWord === "HEY" || firstWord === "HELLO" || firstWord === "HOWDY" || firstWord === "GREETINGS") {
    eBotResponse = "Hey there! How may I assist you today?";
    inputType = "question";
  } else if (firstWord === "GOODBYE" || firstWord === "CYA" || firstWord === "BYE" || firstWord === "FAREWELL" || (firstWord === "SEE" && (secondWord === "YA" || secondWord === "YOU")) || firstWord === "LATER" || firstWord === "PEACE") {
    eBotResponse = "If you have any other questions, feel free to contact my developers. Their information can be found on the <a href='contact.php'>Contact Us</a> page. Goodbye!";
    inputType = "general";
  } else if ((firstWord === "THANK" && secondWord === "YOU") || firstWord === "THANKS") {
    var responses = ["You're welcome!", "No problem.", "Anytime.", "It's my pleasure."];
    if (thankYouCounter == 3)
      thankYouCounter = 0;
    eBotResponse = responses[thankYouCounter] + " Do you have any other questions?";
    thankYouCounter++;
    inputType = "thankYou";
  } else if (firstWord === "WHO" || firstWord === "WHAT" || firstWord === "WHEN" || firstWord === "WHERE" || firstWord === "WHY" || firstWord === "HOW") {
    questionAI(chat, firstWord, userInput);
  } else {
    eBotResponse = "Sorry, I'm not sure what you said. Some basic inputs I will understand are \"Hi,\" \"Bye,\" \"Thank you,\" or a question that begins with \"Who,\" \"What,\" \"When,\" \"Where,\" \"Why,\" or \"How.\"";
    inputType = "general";
  }

  if (eBotResponse !== "")
    chat.innerHTML += "<p class='bot'><span>E-Bot</span><br>" + eBotResponse + "</p>";

  scrollToBottom(chat);
}
function thankYouAI(chat, firstWord) {
  var eBotResponse = "";
  if (firstWord === "YES" || firstWord === "YEAH" || firstWord === "MHM") {
    eBotResponse = "Alright, ask away!";
    inputType = "question";
  } else if (firstWord === "NO" || firstWord === "NAH" || firstWord === "NOPE") {
    eBotResponse = "Okay. I hope I successfully answered all of your questions.";
    inputType = "general";
  } else {
    eBotResponse = "Sorry, I'm not sure what you said. Some basic responses I will understand are \"Yes\" and \"No\".";
    inputType = "thankYou";
  }

  if (eBotResponse !== "")
    chat.innerHTML += "<p class='bot'><span>E-Bot</span><br>" + eBotResponse + "</p>";

  scrollToBottom(chat);
}
function questionAI(chat, firstWord, userInput) {
  var eBotResponse = "";
  userInput = userInput.toUpperCase();
  if (firstWord === "WHO") {
    if ((userInput.indexOf("MADE") > -1 || userInput.indexOf("CREATED") > -1 || userInput.indexOf("DEVELOPED") > -1 || userInput.indexOf("BUILT") > -1 || userInput.indexOf("DESIGNED") > -1 || userInput.indexOf("CONSTRUCTED") > -1) && (!(userInput.indexOf("FOR") > -1))) {
      eBotResponse = "Jovi Yoshioka, a student from Hardin Valley Academy, created E-ssue.";
      inputType = "general";
    } else if (userInput.indexOf("USE") > -1 || userInput.indexOf("USES") > -1 || userInput.indexOf("FOR") > -1 || userInput.indexOf("UTILIZE") > -1 || userInput.indexOf("UTILIZES") > -1) {
      eBotResponse = "E-ssue was developed for anyone who needs to keep track of e-books issued out to classes of students. Such individuals may be teachers.";
      inputType = "general";
    } else {
      eBotResponse = "Sorry, I'm not sure what you said.";
      inputType = "general";
    }
  } else if (firstWord === "WHAT") {
    if ((userInput.indexOf("FOR") > -1 || userInput.indexOf("DO") > -1 || userInput.indexOf("IS") > -1 || userInput.indexOf("FUNCTIONALITIES") > -1 || userInput.indexOf("FUNCTIONS") > -1 || userInput.indexOf("FEATURES") > -1 || userInput.indexOf("PROVIDE") > -1) && ( (!(userInput.indexOf("E-BOOK") > -1)) || (!(userInput.indexOf("EBOOK") > -1)) || (!(userInput.indexOf("E-BOOKS") > -1)) || (!(userInput.indexOf("EBOOKS") > -1)))) {
      eBotResponse = "E-ssue is a web application designed to manage the issuance of e-books to classes of students.";
      inputType = "general";
    } else if (userInput.indexOf("E-BOOK") > -1 || userInput.indexOf("E-BOOKS") > -1 || userInput.indexOf("EBOOK") > -1 || userInput.indexOf("EBOOKS") > -1) {
      eBotResponse = "E-books are electronic versions of a printed book that can be read on an electronic device. They are becoming more prominent in today's educational system as computers, phones, and other electronic devices are being used more actively in and out of the classroom.";
    } else {
      eBotResponse = "Sorry, I'm not sure what you said.";
      inputType = "general";
    }
  } else if (firstWord === "WHEN") {
    if (userInput.indexOf("ONLINE") > -1 || userInput.indexOf("UP") > -1 || userInput.indexOf("DOWN") > -1 || userInput.indexOf("OFFLINE") > -1) {
      eBotResponse = "Unfortunately, E-ssue does not have dedicated servers to run on at the moment. We attempt to keep E-ssue online as much as possible.";
      inputType = "general";
    } else if (userInput.indexOf("CREATE") > -1 || userInput.indexOf("DEVELOP") > -1 || userInput.indexOf("CONSTRUCT") > -1 || userInput.indexOf("DESIGNED") > -1 || userInput.indexOf("BUILT") > -1 || userInput.indexOf("MADE") > -1) {
      eBotResponse = "Development of E-ssue began in mid-February of 2019. E-ssue's basic functionalities were completed by March 2019 in order to compete in the FBLA Tennessee State Conference Coding & Programming Event.";
      inputType = "general";
    } else {
      eBotResponse = "Sorry, I'm not sure what you said.";
      inputType = "general";
    }
  } else if (firstWord === "WHERE") {
    if (userInput.indexOf("BASED") > -1 || userInput.indexOf("HEADQUARTERS") > -1 || userInput.indexOf("DEVELOPED") > -1 || userInput.indexOf("SERVERS") > -1 || userInput.indexOf("HOSTED") > -1) {
      eBotResponse = "Currently, most of E-ssue operations take place at Hardin Valley Academy in Knoxville, Tennessee.";
      inputType = "general";
    } else if (userInput.indexOf("CLASSES") > -1 || userInput.indexOf("CLASS") > -1) {
      eBotResponse = "Classes can be created and viewed from the Classes tab in the navigation bar after the user signs in.";
      inputType = "general";
    } else if (userInput.indexOf("STUDENTS") > -1 || userInput.indexOf("STUDENT") > -1) {
      eBotResponse = "Students can be created and viewed in the Students table in your specific class.";
      inputType = "general";
    } else {
      eBotResponse = "Sorry, I'm not sure what you said.";
      inputType = "general";
    }
  } else if (firstWord === "WHY") {
    if (userInput.indexOf("CREATE") > -1 || userInput.indexOf("DEVELOPED") > -1 || userInput.indexOf("CONSTRUCTED") > -1 || userInput.indexOf("MADE") > -1) {
      eBotResponse = "E-ssue was created for the Future Business Leaders of America Coding & Programming Competitive Event. <a href='https://www.fbla-pbl.org/competitive-event/coding-programming/' target='_blank'>Click here</a> for more information.";
      inputType = "general";
    } else if (userInput.indexOf("DOWN") > -1 || userInput.indexOf("OFFLINE") > -1 || userInput.indexOf("NOT RUNNING") > -1 || userInput.indexOf("SLEEPING") > -1) {
      eBotResponse = "E-ssue does not currently have dedicated servers to run on. We attempt to keep E-ssue online as much as possible, but due to obstructions such as power outages, computer mishaps, and more, E-ssue may go offline and down at certain times. We are working to resolve this issue";
      inputType = "general";
    } else if (userInput.indexOf("UNSECURE") > -1 || userInput.indexOf("HTTP") > -1 || userInput.indexOf("HTTPS") > -1 || userInput.indexOf("8080") > -1 || userInput.indexOf("PORT") > -1 || userInput.indexOf("SECURE") > -1) {
      eBotResponse = "E-ssue is currently being hosted on AWS Cloud 9. For the time being, E-ssue can be connected via HTTP with a port of 8080. We are working to make this more secure.";
      inputType = "general";
    } else {
      eBotResponse = "Sorry, I'm not sure what you said.";
      inputType = "general";
    }
  } else if (firstWord === "HOW") {
    if (userInput.indexOf("LONG") > -1 || userInput.indexOf("TIME") > -1 || userInput.indexOf("HOUR") > -1 || userInput.indexOf("DAY") > -1 || userInput.indexOf("WEEK") > -1) {
      eBotResponse = "It took approximately one week to create E-ssue. A lot of effort was put into that time.";
      inputType = "general";
    } else if ((userInput.indexOf("CREATE") > -1 || userInput.indexOf("MAKE") > -1 || userInput.indexOf("CONSTRUCT") > -1) && (userInput.indexOf("CLASS") > -1 || userInput.indexOf("CLASSES") > -1)) {
      eBotResponse = "After logging in, click the Classes tab in the navigation bar on the top of your screen. After the modal pops up, click the button that says \"Create a class\", input a class name, and click the \"Create\" button.";
      inputType = "general";
    } else if ((userInput.indexOf("CREATE") > -1 || userInput.indexOf("MAKE") > -1 || userInput.indexOf("ADD") > -1) && (userInput.indexOf("STUDENT") > -1 || userInput.indexOf("STUDENTS") > -1)) {
      eBotResponse = "After logging in and navigating to your desired class, click the \"Add a student\" button, input the required information, and click the \"Add\" button.";
      inputType = "general";
    } else if ((userInput.indexOf("CREATE") > -1 || userInput.indexOf("MAKE") > -1 || userInput.indexOf("ADD") > -1) && (userInput.indexOf("E-BOOK") > -1 || userInput.indexOf("E-BOOKS") > -1 || userInput.indexOf("EBOOK") > -1 || userInput.indexOf("EBOOKS") > -1)) {
      eBotResponse = "After logging in and navigating to your desired class, click the \"Add an E-book\" button, input the required information, assign the E-book to students of the class, and click the \"Add\" button.";
      inputType = "general";
    } else if (userInput.indexOf("WORK") > -1 || userInput.indexOf("FUNCTION") > -1 || userInput.indexOf("USE") > -1 || userInput.indexOf("START") > -1 || userInput.indexOf("RUN") > -1) {
      eBotResponse = "E-ssue allows for the user to create classes, add class-specific E-books, add students to the desired class, and assign E-books to students. E-ssue gives users the ability to manage the issuance of E-books to classes of students.";
      inputType = "general";
    } else {
      eBotResponse = "Sorry, I'm not sure what you said.";
      inputType = "general";
    }
  } else {
    eBotResponse = "Sorry, I'm not sure what you said. Try asking a question that starts with \"Who,\" \"What,\" \"When,\" \"Where,\" \"Why,\" or \"How.\"";
    inputType = "general";
  }

  if (eBotResponse !== "")
    chat.innerHTML += "<p class='bot'><span>E-Bot</span><br>" + eBotResponse + "</p>";

  scrollToBottom(chat);
}
function respondAI() {
  var chat = document.getElementById("chat");
  var userInput = document.getElementById("userInput").value;
  if (userInput !== "") {
    document.getElementById("userInput").value = "";
    chat.innerHTML += "<p class='user'><span>You</span><br>" + userInput + "</p>";
    userInput = userInput.toUpperCase();
    var firstWord = getFirstWordAI(userInput);
    var secondWord = getSecondWordAI(userInput);
    if (inputType === "general")
      generalAI(chat, firstWord, secondWord, userInput);
    else if (inputType === "thankYou")
      thankYouAI(chat, firstWord);
    else if (inputType === "question")
      questionAI(chat, firstWord, userInput);
    else {
      chat.innerHTML += "<p class='bot'><span>An error occured! Executing Protocol 3824: E-Bot reset in 3 seconds...</span></p>";
      setTimeout(function() {
        document.getElementById("chat").innerHTML = "<p class='bot'><span>E-Bot: The FAQ & QNA Artificial Intelligence Program.</span></p>";
        document.getElementById("userInput").value = "";
        thankYouCounter = 0;
        inputType = "general";
      }, 3000);
    }
  }
}
function clearChat() {
  document.getElementById("chat").innerHTML = "<p class='bot'><span>E-Bot: The FAQ & QNA Artificial Intelligence Program.</span></p>";
  document.getElementById("userInput").value = "";
  thankYouCounter = 0;
  inputType = "general";
}
