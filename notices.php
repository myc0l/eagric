<?php
    require_once 'includes/eagriculture.php';

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>eAgriculture: Forum</title>
        <link rel="stylesheet" href="css/stylesheet.css" media="all" type="text/css" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                Header Content Comes Here
                <div class="nav">
                    <?php
                        if ( $farmerSession->isLoggedIn() ) {
                            ?>
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="articles.php">Articles</a></li>
                                <li><a href="#">my Account</a></li>
                                <li><a href="forums.php">Forum Topics</a></li>
                                <li><a href="#">Notices</a></li>
                                <li><a href="#">Change My Password</a></li>
                                <li><a href="logout.php">Log Out</a></li>
                            </ul>
                        <?php
                        } elseif ( $farmerSession->isLoggedIn() ) {
                            ?>
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="articles.php">Articles</a></li>
                                <li><a href="register.php">Register</a></li>
                                <li><a href="forums.php">Forum</a></li>
                                <li><a href="#">Notices</a></li>
                                <!-- <li><a href="logout.php">Log Out</a></li> -->
                            </ul>
                        <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>