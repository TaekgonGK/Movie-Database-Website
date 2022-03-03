<!DOCTYPE html>
<html lang = "en">
    
    <head>
    <link href="/bootstrap.min.css" rel="stylesheet">
    <title> Actor Information Page </title>
    </head>

<body>
    <?php
    $db = new mysqli('localhost', 'cs143', '', 'class_db');
    if ($db->connect_errno > 0) { 
        die('Unable to connect to database [' . $db->connect_error . ']'); 
    }
    $id = $_GET["id"];
    ?>

    <div class="container">
        <form action="/search.php">
            <div class="row">
                <div class="col-1">
                    <a href="/">Home Page</a>
                </div>
                <div class="col">
                    <input type="text" id="search_input" placeholder="Search" name="name">
                </div>
                <div class="col-1">
                    <input type="submit" VALUE="Submit">
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <h1 class="text-center"> Actor Information Page</h1>
        <h2> Actor Information Is: </h2>
        <?php
        $query = "SELECT * FROM Actor WHERE id = $id";
        $rs = $db->query($query);
            $row = $rs->fetch_assoc();
        ?>
        <div class="row">
            <div class="col">
                <h3>Name: <?php echo $row['first'] . " " . $row['last'];?></h3>
            </div>
            <div class="col">
                <h3>Date of Birth: <?php echo $row['dob'];?></h3>
            </div>
            <div class="col">
                <?php
                if ($row['dod'] == Null) {
                ?>
                    <h3>Still Alive</h3>
                <?php } else {?>
                    <h3>Date of Death: <?php echo $row['dod'];?></h3>
                <?php } ?>
            </div>
            <div class="col">
                <h3>Gender: <?php echo $row['sex'];?></h3>
            </div>
        </div>
    </div>

    <div class="container">
        <h2> Actor's Movies and Role: </h2>
        <?php
        $query = "SELECT Movie.id, Movie.title, Act.role FROM Movie INNER JOIN (SELECT * FROM MovieActor INNER JOIN Actor ON MovieActor.aid = Actor.id) as Act ON Act.mid = Movie.id WHERE Act.id = $id";
        $rs = $db->query($query);
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Movie Title</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $rs->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['role']; ?></td>
                        <td><a href="/movie.php?id=<?php echo $row['id']; ?>">
                        <?php echo $row['title']; ?></a></td>
                    </tr>
                <?php } $rs->free(); ?>
            </tbody>
        </table>
    </div>
</body>
<?php $db->close();?>
</html>