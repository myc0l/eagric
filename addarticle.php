<?php
    require_once 'includes/eagriculture.php';
    if ( !$farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    if ( isset( $_POST['submitted'] ) ) {
        $errors = array();
        $article = new Article();

        if ( $_POST['txtArticleBody'] == "" ) {
            $errors[] = 'Enter your article\'s body.';
        } else {
            $article->article_body = ucfirst( $_POST['txtArticleBody'] );
        }

        if ( $_POST['txtArticleTopic'] == "" ) {
            $errors[] = 'Enter your article\'s title.';
        } else {
            $article->article_topic = ucfirst( $_POST['txtArticleTopic'] );
        }

        if ( empty( $errors ) ) {
            $sql = "select * from tblarticles where article_topic = '{$article->article_topic}'";
            $result = $database->query( $sql );
            if ( $database->numRows( $result  )== 0 ) {
                $article->postedBy = $_SESSION['farmerID'];
                if ( $article->save() ) {
                    redirect( 'articles.php' );
                } else {
                    $errors[] = 'Could not save article now. Try again later.';
                }
            } else {
                $errors[] = 'Article title already exists. Enter a different title.';
            }
        }
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>eAgriculture: Add Article</title>
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="all" />
        <script src="ckeditor.js"></script>
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
                                <!--<li><a href="users.php">Users</a></li> -->
                                <li><a href="demonstrations.php">Demonstration Videos</a></li>
                                <li><a href="register.php">Register</a></li>
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
                <h2>New Article</h2>
                <?php if ( isset( $errors ) && is_array( $errors ) && !empty( $errors ) ): ?>
                    <div id="panel">
                        <ul>
                            <li><?php echo implode( '<li></li>', $errors ); ?></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="" method="post" class="normal_form">
                    <p>
                        <label for="txtArticleTopic">Article Title:</label>
                        <input type="text" name="txtArticleTopic" id="txtArticleTopic" value="<?php if ( isset( $_POST['txtArticleTopic'] ) ) echo $_POST['txtArticleTopic']; ?>" />
                    </p>

                    <p>
                        <label for="txtArticleBody">Article Body:</label>
                        <textarea name="txtArticleBody" id="txtArticleBody"><?php if ( isset( $_POST['txtArticleBody'] ) ) echo $_POST['txtArticleBody']; ?></textarea>
                        <script>
                            CKEDITOR.replace( 'txtArticleBody' );
                        </script>
                    </p>

                    <p>
                        <input type="submit" value="Add Article" name="submitted" />
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>