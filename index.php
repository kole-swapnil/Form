<?php
require_once "pdo.php";
//require_once "util.php";
session_start();

if ( isset($_POST['candidate_name']) && isset($_POST['candidate_email']) && isset($_POST['gender']) && isset($_POST['location'])
     && isset($_POST['duration']) && isset($_POST['interest']) && isset($_POST['contact'])&& isset($_POST['agreement'])) {

if ( strlen($_POST['candidate_name']) < 1 ||  strlen($_POST['candidate_email']) < 1 || strlen($_POST['location']) < 1 || strlen($_POST['contact']) < 1 || strlen($_POST['interest']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: index.php?fsdf");
        return;
    }


    
 	  if ( ! is_numeric($_POST['contact']) ) {
       $_SESSION['error'] = 'Check contact no.';
        header("Location: index.php?fdsfs");
        return;
    }	

  $file = $_FILES['file'];
  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];


  $fileExt = explode('.',$fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('jpg','jpeg','png','PNG');
  $x = $_POST['candidate_name'];
  
  

  if(in_array($fileActualExt, $allowed)){
    if($fileError === 0){

      $newname = $x.".".$fileActualExt;
      $filedest = 'uploads/'.$newname;
      move_uploaded_file($fileTmpName, $filedest);
      //header("Location:index.php?upload");
      //return;
 }
}   
    
  
  

  
		
	 $stmt = $pdo->prepare('INSERT INTO candidate(candidate_name,email,gender,contact_no,city,duration,interests,resume)values(:na,:em,:gen,:con,:loc,:dur,:inter,:res)');

$stmt->execute(array(
  ':na' => $_POST['candidate_name'],
  ':em' => $_POST['candidate_email'],
  ':gen' => $_POST['gender'],
  ':con' => $_POST['contact'],
  ':loc' => $_POST['location'],
  ':dur' => $_POST['duration'],
  ':inter' => $_POST['interest'],
  ':res' => $filedest)
);
  
  $can_id = $pdo->lastInsertId();
  $rank =1;
  for($i=1; $i<=20; $i++) {
    if ( ! isset($_POST['skill'.$i]) ) continue;
  $skills = $_POST['skill'.$i];
    $stmt = $pdo->prepare('INSERT INTO skill (candidate_id, skill_tag) VALUES (:can , :skill_tag)');
$stmt->execute(array(
  ':can' => $can_id,
  ':skill_tag' => $skills));

$rank++;
    

  }
  $_SESSION['success'] = "Record Added";
    header("Location: untit.php");
        return;

if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
}
?>


<html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  </head>
  <body>
  	<section class="hero is-primary">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        Candidate Form
      </h1>
      <h2 class="subtitle">
        Submit before 27th-May
      </h2>
    </div>
  </div>
</section>
    <div class="container">
      
<form method="post" action="index.php" enctype="multipart/form-data">
<div class="field">
  <label class="label">Candidate Name</label>
  <div class="control has-icons-left has-icons-right">
    <input class="input is-success" type="text" placeholder="Text input" value="bulma" name="candidate_name">
    <span class="icon is-small is-left">
      <i class="fas fa-user"></i>
    </span>
    <span class="icon is-small is-right">
      <i class="fas fa-check"></i>
    </span>
  </div>
</div>
<div class="field">
  <label class="label">Email</label>
  <div class="control has-icons-left has-icons-right">
    <input class="input" type="email" placeholder="Email input" value="hello@" name="candidate_email">
    <span class="icon is-small is-left">
      <i class="fas fa-envelope"></i>
    </span>
    <span class="icon is-small is-right">
      
    </span>
  </div>
</div>
<div class="field">
  <label class="label">Gender</label>
<div class="control">
  <label class="radio">
    <input type="radio" name="gender" value="Male">
    Male
  </label>
  <label class="radio">
    <input type="radio" name="gender" value="Female">
    Female
  </label>
</div>
</div>
<div class="field">
  <label class="label">Contact No.</label>
  <div class="control">
    <input class="input" type="text" placeholder="Text input" name="contact">
  </div>
</div>
<div class="field">
  <label class="label">Location</label>
  <div class="control">
    <input class="input" type="text" placeholder="Text input" name="location">
  </div>
</div>

<div class="field">
  <label class="label">Duration</label>
  <div class="control">
    <div class="select">
      <select name="duration">
        <option>Select dropdown</option>
        <option>1 month</option>
        <option>2 month</option>
        <option>3 month</option>
        <option>6 month</option>
      </select>
    </div>
  </div>
</div>
<div class="field">
  <label class="label">Skills</label>
  <div class="control">
  <input type="button" id="addPos" value="+" >
  <div id="position_fields">
  </div>
  </div>
</div>

<div class="field">
  <label class="label">Interest</label>
  <div class="control">
    <textarea class="textarea" placeholder="Textarea" name="interest"></textarea>
  </div>
</div>
<div class="field">
	<label class="label">Resume</label>
<input type="file" name="file">
</div>
<div class="field">
  <div class="control">
    <label class="checkbox">
      <input type="checkbox" name="agreement">
      I agree to the <a href="#">terms and conditions</a>
    </label>
  </div>
</div>


<div class="field is-grouped">
  <div class="control">
    <input type="submit" class="button is-primary" name="submit" value="Submit">
  </div>
</div>
    </div>
  </section>
</form>
  <footer class="footer">
  <div class="content has-text-centered">
    <p>
      <strong>Innerwork Solutions Private Limited</strong>
    </p>
  </div>
</footer>
<script>
countPos = 0;

// http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript
$(document).ready(function(){
    window.console && console.log('Document ready called');
    $('#addPos').click(function(event){
        // http://api.jquery.com/event.preventdefault/
        event.preventDefault();
        if ( countPos >= 20 ) {
            alert("Maximum of twenty position entries exceeded");
            return;
        }
        countPos++;
        window.console && console.log("Adding position "+countPos);
        $('#position_fields').append(
            '<div id="position'+countPos+'"> \
            <p>Skill'+countPos+' : <input type="text" name="skill'+countPos+'" value="" /> \
            <input type="button" value="-" \
                onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
            </div>');
     
    });
});

</script>
  </body>
</html>