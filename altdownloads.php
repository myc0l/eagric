<?php
    require_once 'includes/eagriculture.php';

    $page = !empty( $_GET['page'] ) ? ( int )$_GET['page'] : 1;
    $perPage = 15;
    $totalCount = AltArticle::countAll();

    $pagination = new Pagination( $page, $perPage, $totalCount );
    $sql = "select article_id, article_file, article_title, postedBy, datePosted from tblaltarticles where approved = 'yes' order by ";
    $sql .= "datePosted desc limit {$perPage} offset {$pagination->offset()}";
    $articles = AltArticle::findBySQL( $sql );
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
                <h2>List Of Articles</h2>
                <table>
                    <thead>
                    <tr>
                        <td>Title</td>
                        <td>Body</td>
                        <td>Posted By</td>
                        <td>Date Posted</td>
                        <td>&nbsp;</td>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="5" align="right">
                            <input type="button" value="Add New" onclick="window.location.href='addaltarticle.php'" />
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        foreach( $articles as $article ) {
                            $farmer = Farmer::findByID( $article->postedBy );
                            ?>
                            <tr>
                                <td><?php echo $article->article_title; ?></td>
                                <td><?php echo $article->article_file; ?></td>
                                <td><?php echo $farmer->fullName(); ?></td>
                                <td><?php echo $article->datePosted; ?></td>
                                <td><a href="articles/<?php echo $article->article_file; ?>">View Article</a></td>
                            </tr>
                        <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>