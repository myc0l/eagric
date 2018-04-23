<?php
    require_once 'includes/eagriculture.php';
    if ( !$farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    if ( isset( $_POST['submitted'] ) ) {
        $errors = array();
        $newTopic = new Forum();

        if ( $_POST['txtTopic'] == "" ) {
            $errors[] = 'Please enter the forum topic.';
        } else {
            $newTopic->topic = ucfirst( $_POST['txtTopic'] );
            $newTopic->farmer_id = $_SESSION['farmerID'];
        }

        if ( empty( $errors ) ) {
            if ( $newTopic->create() ) {
                redirect( 'forums.php' );
            } else {
                $errors[] = 'Could not save topic. Try again later.';
            }
        }
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>eAgriculture: Add New Topic</title>
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="all" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <img src="images/logo.PNG" />
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
                        <!-- <li><a href="register.php">Log Out</a></li> -->
                        <li><a href="myprofile.php"><b><?php echo $farmer->fullName(); ?></b></a></li>
                        <li><a href="logout.php">Sign Out</a></li>
                    </ul>
                </div>
            </div>

            <div id="content">
                <h2>New Topic</h2>
                <?php if ( isset( $errors ) && is_array( $errors ) && !empty( $errors ) ): ?>
                    <div id="panel">
                        <ul>
                            <li><?php echo implode( '<li></li>', $errors ); ?></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="" method="post" class="normal_form">
                    <p>
                        <label for="txtForum">Topic:</label><br />
                        <textarea id="txtForum" name="txtTopic"><?php if ( isset( $_POST['txtTopic'] ) ) echo $_POST['txtTopic']; ?></textarea>
                    </p>

                    <p>
                        <input type="button" value="Cancel" onclick="window.location.href='forums.php'" />
                        <input type="submit" value="Add Topic" name="submitted" />
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>