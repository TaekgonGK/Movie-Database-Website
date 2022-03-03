<!DOCTYPE html>
<?php // This page is embedded within review.php and used to get user input ?>

<head>
    <link href="/bootstrap.min.css" rel="stylesheet">
    <title> Review Reader Page </title>
</head>

<body>
    <div class="container">
        <a class="btn btn-primary" href="/">Home Page</a>
    </div>

    <div class="container">
        <div class="text">
            <h4> Thanks for the comment! <br> Your review was added.</h4>
            <a class="btn btn-primary" href="/movie.php?id=<?php echo $mid ?>"> Click here to go back to the movie page.</a>
        </div>
    </div>

</body>
</html>