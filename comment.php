<?php
    require_once 'includes/eagriculture.php';
    if ( !$farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    if ( isset( $_POST['submitted'] ) ) {
        $errors = array();
        $newComment = new Comment();

        if ( $_POST['txtComment'] == "" ) {
            $errors[] = 'Please enter the comment you want to post.';
        } else {
            $newComment->commentText = ucfirst( $_POST['txtComment'] );
            $newComment->farmerID = $_SESSION['farmerID'];
            $newComment->forumID = $_GET['forumid'];
        }

        if ( empty( $errors ) ) {
            if ( $newComment->create() ) {
                redirect( 'forums.php' );
            } else {
                $errors[] = 'Your comment could not be posted now. Try again later.';
            }
        }
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>eAgriculture: Post Comment</title>
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="all" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <img src="images/logo2.PNG" />
                <div class="nav">
                    <?php
                        $farmer = Farmer::findByID( $_SESSION['farmerID'] );
                    ?>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="articles.php">Articles</a></li>
                        <li><a href="adverts.php">Advertisements</a></li>
                        <li><a href="demonstrations.php">Demonstration Videos</a></li>
                        <li><a href="forums.php">Forum</a></li>
                        <!--<li><a href="register.php">Log Out</a></li>-->
                        <li><a href="myprofile.php"><b><?php echo $farmer->fullName(); ?></b></a></li>
                        <li><a href="logout.php">Sign Out</a></li>
                    </ul>
                </div>
            </div>

            <div id="content">
                <?php
                    $forum = Forum::findByID( $_GET['forumid'] );
                ?>
                <h3 class="topic"><?php echo $forum->topic; ?></h3>
                `<?php
                    $sql = "select commentDate, commentText, farmerID from tblcomments where forumID = ";
                    $sql .= "{$_GET['forumid']} order by commentDate asc";
                    $result = $database->query( $sql );
                    if ( $database->numRows( $result ) != 0 ) {
                        while( $row = $database->fetchArray( $result ) ) {
                            $farmer = Farmer::findByID( $row['farmerID'] );
                            ?>
                            <p><span class="farmerName"><?php echo $farmer->fullName(); ?></span> wrote on <span
                                    class="commentDate"><?php echo $row['commentDate']; ?></span> </p>
                            <p><?php echo $row['commentText']; ?></p>
                        <?php
                        }
                    }
                ?>
                <br />
                <h2>Your Comment:</h2>
                <form method="post" action="" class="normal_form">
                    <?php if ( isset( $errors ) && is_array( $errors ) && !empty( $errors ) ): ?>
                        <div id="panel">
                            <ul>
                                <li><?php echo implode( '<li></li>', $errors ); ?></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <p>
                        <label for="txtComment">Comment</label>
                        <textarea name="txtComment" id="txtComment"><?php if ( isset( $_POST['txtComment'] ) ) echo $_POST['txtComment']; ?></textarea>
                    </p>

                    <p>
                        <input type="submit" name="submitted" value="Post Comment" />
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>