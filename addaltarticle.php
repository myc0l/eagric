<?php
    require_once 'includes/eagriculture.php';
    if ( !$farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    if ( isset( $_POST['btnAdd'] ) ) {
        $errors = array();
        $altArticle = new AltArticle();

        if ( $_POST['txtArticleTitle'] == "" ) {
            $errors[] = 'Enter the new article\'s title.';
        } else {
            $altArticle->article_title = ucfirst( $_POST['txtArticleTitle'] );
        }

        if ( isset( $_FILES['articleFile'] ) ) {
            $file = $_FILES['articleFile'];
            $fileName = $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];

            // determine the file extension
            $fileExt = explode( ".", $fileName );
            $fileExt = strtolower( end( $fileExt ) );
            $allowed = array( 'doc', 'docx', 'pdf' ) ;
            if ( in_array($fileExt, $allowed ) ) {
                if ( $fileSize <= MAX_ADVERT_SIZE  ) {
                    $newFileName = uniqid( '', true ) . '.' . $fileExt;
                    $fileDestination = ARTICLE_DIR . DS . $newFileName;
                    if ( move_uploaded_file( $fileTmp, $fileDestination ) ) {
                        $altArticle->article_file = $newFileName;
                        $altArticle->postedBy = $_SESSION['farmerID'];
                    }
                } else {
                    $errors[] = 'Article document must not be greater than ' . ( MAX_ADVERT_SIZE / 1048576 ) . 'MB.';
                }
            } else {
                $errors[] = 'Document must either be a word or pdf file.';
            }
        } else {
            $errors[] = 'Select the advert file.';
        }

        if ( empty( $errors ) ) {
            $sql = "select * from tblaltarticles where article_title = '{$altArticle->article_title}'";
            $result = $database->query( $sql );
            if ( $database->numRows( $result ) == 0 ) {
                if ( $altArticle->create() ) {
                    redirect( 'altdownloads.php' );
                }
            } else {
                $errors[] = 'Article with same title already exists. Enter a different title.';
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
                <h2>Post Article</h2>
                <?php if ( isset( $errors ) && is_array( $errors ) && !empty( $errors ) ): ?>
                    <div id="panel">
                        <ul>
                            <li><?php echo implode( '<li></li>', $errors ); ?></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data" action="">
                    <p>
                        <label for="articleFile">Select Article Document:</label>
                        <input type="file" name="articleFile" id="articleFile" />
                    </p>

                    <p>
                        <label for="txtArticleTitle">Title:</label>
                        <input type="text" id="txtArticleTitle" name="txtArticleTitle" value="<?php if ( isset( $_POST['txtArticleTitle'] ) ) echo $_POST['txtArticleTitle']; ?>"
                    </p>

                    <p>
                        <input type="submit" value="Add Article" name="btnAdd" />
                        <input type="button" value="Cancel" onclick="window.location.href='altarticles.php'" />
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>