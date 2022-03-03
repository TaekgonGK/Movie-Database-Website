<!DOCTYPE html>
<head>
    <link href="/bootstrap.min.css" rel="stylesheet">
    <title> Review Page </title>
    
</head>

<body>
    <?php
    $db = new mysqli('localhost', 'cs143', '', 'class_db');
    if ($db->connect_errno > 0) { 
        die('Unable to connect to database [' . $db->connect_error . ']'); 
   
    } 
    $id = $_GET['id'];
    $title = $_GET['title'];
    
    ?>

    <div class="container">
        <a class="btn btn-primary" href="/">Home Page</a>
    </div>

    <h2 class="text">Add New Review Here: </h2>
    <div class="container">
    <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <h3> Movie Title: <?php echo $title ?></h3> <input type="hidden" name="id" value=<?php echo $id ?>>
            <p> Your Name: </p> <input type="VARCHAR(20)" name="name">
            <p> Your Rating: </p>
            <select name="rating">
                <OPTION>1</OPTION>
                <OPTION>2</OPTION>
                <OPTION>3</OPTION>
                <OPTION>4</OPTION>
                <OPTION SELECTED>5</OPTION>
            </SELECT><br>
            <p> Your Comment: </p> <textarea name="comment" rows="5" cols="30" maxlength="500"></textarea> <br>
            <input class="btn btn-primary" type="submit">
            <?php
        

            if($_POST["comment"]){
                $mid = $_POST["id"];
                $name = $_POST["name"];
                $rating = $_POST["rating"];
                $comment = $_POST["comment"];
                $time = date("Y/m/d H:i:s");
                $query = "INSERT INTO Review(name, time, mid, rating, comment) VALUES (?, ?, ?, ?, ?)";
                $rs = $db->query($query);
  
              $stm = $db->prepare($query);
              $stm->bind_param("ssiis", $name,$time,$mid,$rating,$comment);
      
              
                if(!$stm->execute()){
                  $errmsg = $db->error;
                  print "$mid <br> $name <br> $rating <br>";
                  print "Query failed: $errmsg <br>";
                  exit(1);
  
                }
                else{
                  $stm->free_result();
                  $db->close();
                  header("Location: ./reviewreader.php");
  
                }
                
            }
             
            ?>
        </form>
    </div>

</html>