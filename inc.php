<?php
require_once "pdo.php";
//require_once "util.php";
session_start();

if(isset($_POST['submit'])){
  $file = $_FILES['file'];
  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];


  $fileExt = explode('.',$fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('jpg','jpeg','png','PNG');

  
  

  if(in_array($fileActualExt, $allowed)){
    if($fileError === 0){

      $newname = uniqid('',true).".".$fileActualExt;
      $filedest = 'uploads/'.$newname;
      move_uploaded_file($fileTmpName, $filedest);
      header("Location:index.php?upload");
      return;
    }
    else{
      "Error uploading your file";
      header("Location:index.php?noupload");
      return;
    }
    
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
      
<form method="post" action="inc.php" enctype="multipart/form-data">

<input type="file" name="file">
    <button type="submit" name="submit">UPLOAD</button>
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