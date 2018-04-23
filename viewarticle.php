<?php
    require_once 'includes/eagriculture.php';

    if ( !empty( $_GET['articleid'] ) && isset( $_GET['articleid'] ) && is_numeric( $_GET['articleid'] ) ) {
        $articleID = $_GET['articleid'];
        $sql = "select * from tblarticles where article_id = {$_GET['articleid']}";
        if ( $database->numRows( $database->query( $sql ) ) == 1 ) {
            $article = Article::findByID( $_GET['articleid'] );
        } else {
            die( '<p>You have accessed this page in error. Click <a href="articles.php">here</a> to go back.</p>' );
        }
    } else {
        die( '<p>You have accessed this page in error. Click <a href="index.php">here</a> to go back.</p>' );
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>View Article</title>
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css" media="all" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <img src="images/logo.PNG" />
                <div class="nav">
                    <?php
                        if ( !$farmerSession->isLoggedIn() ) {
                            ?>
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="articles.php">Articles</a></li>
                                <li><a href="adverts.php">Advertisements</a></li>
                                <li><a href="altdownloads.php">Download Articles</a></li>
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
                                <li><a href="altdownloads.php">Download Articles</a></li>
                                <li><a href="demonstrations.php">Demonstration Videos</a></li>
                                <li><a href="forums.php">Forum</a></li>
                                <li><a href="register.php">Log Out</a></li>
                                <li><a href="myprofile.php"><b><?php echo $farmer->fullName(); ?></b></a></li>
                                <li><a href="logout.php">Sign Out</a></li>
                            </ul>
                        <?php
                        }
                        ?>
                </div>
            </div>

            <div id="content">
                <h2><?php echo $article->article_topic; ?></h2>
                <br />
                <p><?php echo $article->article_body; ?></p>
            </div>
        </div>
    </body>
</html>