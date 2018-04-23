<?php
    require_once 'includes/eagriculture.php';

    $sql = "select article_id, article_topic, datePosted, postedBy from tblarticles order by datePosted desc limit 5";
    $articles = Article::findBySQL( $sql );
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>eAgriculture: Articles</title>
        <link rel="stylesheet" href="css/stylesheet.css" media="all" type="text/css" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <img src="images/logo2.PNG" />
                <div class="nav">
                    <?php
                        if ( !$farmerSession->isLoggedIn() ) {
                            ?>
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="articles.php">Articles</a></li>
                                <li><a href="adverts.php">Advertisements</a></li>
                                <!--<li><a href="users.php">Users</a></li> -->
                                <li><a href="demonstrations.php">Demonstration Videos</a></li>
                                <li><a href="register.php">Register</a></li>
                                <li><a href="login.php">Log in</a></li>
                            </ul>
                        <?php
                        } elseif ( $farmerSession->isLoggedIn() ) {
                            $farmer = Farmer::findByID( $_SESSION['farmerID'] );
                            ?>
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="articles.php">Articles</a></li>
                                <li><a href="adverts.php">Advertisements</a></li>
                                <li><a href="demonstrations.php">Demonstration Videos</a></li>
                                <li><a href="forums.php">Forum</a></li>
                                <!-- <li><a href="register.php">Log Out</a></li> -->
                                <li><a href="myprofile.php"><b><?php echo $farmer->fullName(); ?></b></a></li>
                                <li><a href="logout.php">Sign Out</a></li>
                            </ul>
                        <?php
                        }
                    ?>
                </div>
            </div>

            <div id="content">
                <?php
                    $sql = "select article_title, article_text, datePosted from tbladminarticles order by datePosted
                            desc limit 1";
                    $result = $database->query( $sql );
                    $row = $database->fetchArray( $result );
                ?>
                <h2><?php echo $row['article_title'];  ?></h2>

                <p>Posted on <?php echo $row['datePosted']; ?></p>

                <p><?php echo $row['article_text']; ?></p>
            </div>
        </div>
    </body>
</html>