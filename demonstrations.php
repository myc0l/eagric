<?php
    require_once 'includes/eagriculture.php';

    $page = !empty( $_GET['page'] ) ? ( int )$_GET['page'] : 1;
    $perPage = 15;
    $totalCount = Demo::countAll();

    $pagination = new Pagination( $page, $perPage, $totalCount );
    $sql = "select * from tbldemos order by datePosted desc limit {$perPage} offset {$pagination->offset()}";
    $demos = Demo::findBySQL( $sql );
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>eAgriculture Administration: List of Video Demonstrations</title>
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="all" />
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
                <h2>Demonstration Videos</h2>
                <table>
                    <thead>
                    <tr>
                        <td>Filename</td>
                        <td>Demonstration Title</td>
                        <td>Posting Date</td>
                        <td>&nbsp;</td>
                    </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                    <?php
                        foreach( $demos as $demo ) {
                            ?>
                            <tr>
                                <td><?php echo $demo->file; ?></td>
                                <td><?php echo $demo->demoTopic; ?></td>
                                <td><?php echo $demo->datePosted; ?></td>
                                <td><a href="downloaddemo.php?demoid=<?php echo $demo->demo_id; ?>">Download</a></td>
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