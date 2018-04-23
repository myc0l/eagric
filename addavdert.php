<?php
    require_once 'includes/eagriculture.php';
    if ( !$farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    if ( isset( $_POST['submit'] ) ) {
        $errors = array();
        $newAdvert = new Advert();

        if ( !empty( $_FILES['advertFile'] ) && ( $_FILES['advertFile']['error'] == UPLOAD_ERR_OK ) ) {
            // advert uploaded successfully
            $tempFile = $_FILES['advertFile']['tmp_name'];
            $targetPath = __DIR__ . DS . 'adverts' . DS . $_FILES['advertFile']['name'];
        } else {
            $errors[] = new UploadException( $_FILES['advertFile']['error'] );
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
                header comes here
                <div class="nav">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="articles.php">Articles</a></li>
                        <li><a href="#">My Account</a></li>
                        <li><a href="forums.php">Forum</a></li>
                        <li><a href="#">Notices</a></li>
                        <li><a href="#">Change Password</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    </ul>
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
                            <input type="hidden" value="2097152" name="MAX_FILE_SIZE" />
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
        </div>
    </body>
</html>