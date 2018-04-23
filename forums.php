<?php
    require_once 'includes/eagriculture.php';
    if ( !$farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    $page = !empty( $_GET['page'] ) ? ( int )$_GET['page'] : 1;
    $perPage = 15;
    $totalCount = Forum::countAll();

    $pagination = new Pagination( $page, $perPage, $totalCount );

    $sql = "select forum_id, topic, farmer_id, datePosted from tblforums order by datePosted desc limit {$perPage} ";
    $sql .= "offset {$pagination->offset()}";
    $forums = Forum::findBySQL( $sql );
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
                        <li><a href="forums.php">Forum Topics</a></li>
                        <!--li><a href="register.php">Log Out</a></li> -->
                        <li><a href="myprofile.php"><b><?php echo $farmer->fullName(); ?></b></a></li>
                        <li><a href="logout.php">Sign Out</a></li>
                    </ul>
                </div>
            </div>

            <div id="content">
                <h2>Forum Topics</h2>

                <?php
                    foreach( $forums as $forum ) {
                        $farmer = Farmer::findByID( $forum->farmer_id );
                        ?>
                        <p class="forumTopic"><?php echo $forum->topic; ?></p>
                        <p>Posted By: <span class="farmerName"><?php echo $farmer->fullName(); ?></span> on <?php echo
                            $forum->datePosted; ?>. <a href="comment.php?forumid=<?php echo $forum->forum_id; ?>">View Comments</a></p>

                    <?php
                    }
                ?>
                <br />
                <input type="button" value="Create Topic" onclick="window.location.href='newtopic'" />
            </div>
        </div>
    </body>
</html>