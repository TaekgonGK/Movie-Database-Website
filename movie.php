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

    $query = "SELECT * FROM Movie WHERE id = $id";
    $rs = $db->query($query);
        $row = $rs->fetch_assoc();

    $title = $row['title'];

    ?>
    <div class="container">
        <form action="/search.php">
            <div class="row">
                <div class="col-1">
                    <a class="btn btn-primary" href="/">Home Page</a>
                </div>
                <div class="col">
                    <input type="text" id="search_input" placeholder="Search" name="name">
                </div>
                <div class="col-1">
                    <input class="btn btn-outline-primary" type="submit" VALUE="Submit">
                </div>
            </div>
        </form>
    </div>

    <h1 class="text-center"> Movie Information Page</h1>

    <div class="container">
        <h2> Movie Information Is: </h2>
        <div class="row">
            <div class="col">
                <h3>Title: <?php echo $row['title']; ?></h3>
            </div>
            <div class="col">
                <h3>Year: <?php echo $row['year']; ?></h3>
            </div>
            <div class="col">
                <h3>Producer: <?php echo $row['producer']; ?></h3>
            </div>
            <div class="col">
                <h3>Rating: <?php echo $row['rating']; ?></h3>
            </div>
            <div class="col">
                <h3>Director: <?php echo $row['director']; ?></h3>
            </div>
            <div class="col">
                <h3>Genre: <?php echo $row['genre']; ?></h3>
            </div>
        </div>
    </div>

    <div class="container">
        <h2> Actors In This Movie: </h2>
        <?php
        $query = "SELECT Actor.id, first, last, role FROM  MovieActor INNER JOIN Actor ON MovieActor.aid = Actor.id WHERE MovieActor.mid = $id";
        $rs = $db->query($query); 
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $rs->fetch_assoc()) { ?>
                    <tr>
                        <td><a href="/actor.php?id=<?php echo $row['id']; ?>"><?php echo $row['first'] . " " . $row['last']; ?></a></td>
                        <td><?php echo $row['role']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php
    $query = "SELECT * FROM Review WHERE mid=$id;";
    $rs = $db->query($query);

    $avg_query = "SELECT AVG(Review.rating) as Average FROM Review WHERE mid=$id;";
    $rs_avg = $db->query($avg_query);
        $row = $rs_avg->fetch_assoc();


    if (count($row['Average']) == Null) {
    ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h4> No review yet, be the first to review.</h4>
                </div>
                <div class="col-2">
                    <a class="btn btn-primary" href="/review.php?title=<?php echo $title ?>&id=<?php echo $id ?>">Add Review</a>
                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="container">
            <h2> User Review: </h2>
            <div class="row">
                <div class="col">
                    <h4>Average movie score is: <?php echo round($row['Average'], 2); ?>/5 based on <?php echo $rs->num_rows ?> reviews.</h4>
                </div>
                <div class="col-2">
                    <a class="btn btn-primary" href="/review.php?title=<?php echo $title ?>&id=<?php echo $id ?>">Leave your review here.</a>
                </div>
            </div>

            <h2> Comment Details: </h2>
            <div class="row">
                <?php while ($row = $rs->fetch_assoc()) { ?>
                <div class = "col">
                    <h4><?php echo $row['name'] ?> rated this movie with score <?php echo $row['rating'] ?> at <?php echo $row['time'] ?>. </h4>
                </div>
                <div class="col-2">
                    <h4>They commented: <?php echo $row['comment'] ?> </h4>
                </div>
                <?php
                    }
                    $rs->free(); ?>
            </div>
        </div>
    <?php } ?>
</body>
<?php
$db->close();
?>
</html>