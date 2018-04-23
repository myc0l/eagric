<?php
    require_once 'includes/eagriculture.php';
    if ( !$farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    if ( isset( $_POST['upload'] ) ) {
        $errors = array();
        $advert = new Advert();
        // die( 'i have been submitted.' );
        if ( isset( $_FILES['advertFile'] ) ) {
            $file = $_FILES['advertFile'];

            $fileName = $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];

            // determine the file extension
            $fileExt = explode( ".", $fileName );
            $fileExt = strtolower( end( $fileExt ) );
            $allowed = array( 'jpg', 'jpeg', 'png' ) ;
            if ( in_array($fileExt, $allowed ) ) {
                if ( $fileSize <= MAX_ADVERT_SIZE  ) {
                    $newFileName = uniqid( '', true ) . '.' . $fileExt;
                    $fileDestination = ADVERTS_DIR . DS . $newFileName;
                    if ( move_uploaded_file( $fileTmp, $fileDestination ) ) {
                        $advert->img = $newFileName;
                        $advert->postedBy = $_SESSION['farmerID'];
                    }
                } else {
                    $errors[] = 'Advert banner must not be greater than ' . ( MAX_ADVERT_SIZE / 1048576 ) . 'MB.';
                }
            } else {
                $errors[] = 'Banner must either be a .jpg or .png or .jpeg file.';
            }
        } else {
            $errors[] = 'Select the advert file.';
        }

        if ( empty( $errors ) ) {
            if ( $advert->create() ) {
                redirect( 'adverts.php' );
            }
        }
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>eAgriculture: Add Advert</title>
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="all" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <img src="images/logo2.PNG">
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
                <h2>Post Advert</h2>
                <?php if ( isset( $errors ) && is_array( $errors ) && !empty( $errors ) ): ?>
                    <div id="panel">
                        <ul>
                            <li><?php echo implode( '<li></li>', $errors ); ?></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data" action="">
                    <p>
                        <label for="advertFile">Select Advert Image:</label>
                        <input type="file" name="advertFile" id="advertFile" />
                    </p>

                    <p>
                        <input type="submit" value="Upload Advert" name="upload" />
                        <input type="button" value="Cancel" onclick="window.location.href='index.php'" />
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>