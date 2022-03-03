<!DOCTYPE html>
<html lang = "en">

<head>
    <link href="/bootstrap.min.css" rel="stylesheet">
    <title> Search Page </title>
</head>

<body>
    <?php
        $db = new mysqli('localhost', 'cs143', '', 'class_db');
        if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
        }
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

    <h1 class="text"> Search Page </h1>
    <h2 class="text"> Actor Name: </h2>
    <div class="container">
        <form action = "<?php $_PHP_SELF ?>" method = "GET">
        <input type = "text" name = "actor" />
        <?php
        $sanitized_actor = $db->real_escape_string($actor);
        $exploded_actor = explode(" ", $sanitized_actor);

        $query = "SELECT id, first, last, dob FROM Actor WHERE ";
        $w_query = "(Actor.first LIKE '%s' OR Actor.last LIKE '%s')";
        $l_actor = '%' . $exploded_actor[0] . '%';
        $total_query = $query . sprintf($w_query, $l_actor, $l_actor);

        if (count($exploded_actor) > 1) {
            for ($i = 1; $i < count($exploded_actor); $i++) {
                $l_actor = '%' . $exploded_actor[$i] . '%';
                $new_w_query = sprintf($w_query, $l_actor, $l_actor);
                $total_query = $total_query . " AND " . $new_w_query;
            }
        }
        $rs = $db->query($total_query);

        if ($rs->num_rows == 0) { ?>
            <h4 class="text"> No matching actors... </h4>
            <?php
        } else {
            ?>
                <h4 class="text"> Matching Actors: </h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Actor's Name: </th>
                            <th>Actor's Date of Birth: </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $rs->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><a href="/actor.php?id=<?php echo $row['id']; ?>"><?php echo $row['first'] . " " . $row['last']; ?></a></td>
                                <td><a href="/actor.php?id=<?php echo $row['id']; ?>"><?php echo $row['dob']; ?></a></td>
                            </tr>
                    <?php
                        }
                    }
                    $rs->free();?>
                    </tbody>
                </table>
    </div>

    <h2 class="text"> Movie Title: </h2>
    <div class="container">
        <form action = "<?php $_PHP_SELF ?>" method = "GET">
        <input type = "text" name = "movie"/>        
        <?php
        $sanitized_movie = $db->real_escape_string($movie);
        $exploded_movie = explode(" ", $sanitized_movie);

        $query = "SELECT id, title, year FROM Movie WHERE ";
        $w_query = "(title LIKE '%s')";
        $l_movie = '%' . $exploded_movie[0] . '%';
        $total_query = $query . sprintf($w_query, $l_movie, $l_movie);

        if (count($exploded_movie) > 1) {
            for ($i = 1; $i < count($exploded_movie); $i++) {
                $l_movie = '%' . $exploded_movie[$i] . '%';
                $new_w_query = sprintf($w_query, $l_movie);
                $total_query = $total_query . " AND " . $new_w_query;
            }
        }
        $rs = $db->query($total_query);
        ?>

        <?php
        if ($rs->num_rows == 0) { ?>
            <h4 class="text"> No matching movies...</h4>
            <?php
        } else {
            ?>
                <h4 class="text"> Matching movies: </h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Movie Title: </th>
                            <th>Movie Release Year: </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $rs->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><a href="/movie.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>
                                <td><a href="/movie.php?id=<?php echo $row['id']; ?>"><?php echo $row['year']; ?></a></td>
                            </tr>
                    <?php
                        }
                    }
                    $rs->free();
                    ?>
                    </tbody>
                </table>
    </div>
</body>
<?php
$db->close();
?>

</html>