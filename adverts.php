<?php
    require_once 'includes/eagriculture.php';

    $page = !empty( $_GET['page'] ) ? ( int )$_GET['page'] : 1;
    $perPage = 15;
    $totalCount = Advert::countAll();

    $pagination = new Pagination( $page, $perPage, $totalCount );
    $sql = "select * from tbladverts where approved = 'yes' order by datePosted desc limit {$perPage} offset
            {$pagination->offset()}";
    $adverts = Advert::findBySQL( $sql );
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
                <img src="images/logo2.PNG">
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
                <h2>List Of Adverts</h2>
                <table>
                    <thead>
                    <tr>
                        <td>Advert Banner</td>
                        <!-- <td>Date Posted</td>-->
                        <td>Posted By</td>
                        <td>Date Posted</td>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="3" align="right">
                                <input type="button" value="Add New" onclick="window.location.href='addadvert.php'" />
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        foreach( $adverts as $advert ) {
                                $farmer = Farmer::findByID( $advert->postedBy );
                            ?>
                            <tr>
                                <td><img src="adverts/<?php echo $advert->img; ?>" /></td>
                                <td><?php echo $farmer->fullName(); ?></td>
                                <td><?php echo $advert->datePosted; ?></td>
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