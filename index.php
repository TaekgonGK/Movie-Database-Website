<!DOCTYPE html>
<html lang = "en">
    
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <h1 class="text-center"> Actor Search Page </h1>
        <div class="container">
            <form action="/search.php">
                <div class="row">
                    <div class="col">
                        <input type="text" id="search_input" placeholder="Search" name="name">
                    </div>

                    <div class="col-1">
                        <input class="btn btn-primary" type="submit" VALUE="Submit">
                    </div>
                </div>
            </form>
        </div>
    </body>
    <?php $db->close(); ?>