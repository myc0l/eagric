<?php
    require_once 'includes/eagriculture.php';
    if ( !$farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    if ( isset( $_POST['register'] ) ) {
        $errors = array();
        $newFarmer = Farmer::findByID( $_SESSION['farmerID'] );

        if ( $_POST['txtFirstName'] == "" ) {
            $errors[] = 'Please enter your first name.';
        } else {
            if ( preg_match( '/^[A-Z \'.-]{3,20}$/i', $_POST['txtFirstName'] ) ) {
                $newFarmer->first_name = ucwords( $_POST['txtFirstName'] );
            } else {
                $errors[] = 'First name must contain letters and spaces only.';
            }
        }

        if ( $_POST['txtLastName'] == "" ) {
            $errors[] = 'Please enter your surname.';
        } else {
            if ( preg_match( '/^[A-Z \'.-]{3,20}$/i', $_POST['txtLastName'] ) ) {
                $newFarmer->last_name = ucwords( $_POST['txtLastName'] );
            } else {
                $errors[] = 'Surname must contain letters and spaces only.';
            }
        }

        if ( empty( $errors ) ) {
            $newFarmer->save();
            redirect( 'index.php' );
        }
    } elseif ( $_REQUEST_METHOD = 'GET' ) {
        $farmer = Farmer::findByID( $_SESSION['farmerID'] );
    }
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
                <img src="images/logo.PNG" />
                <div class="nav">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="articles.php">Articles</a></li>
                        <li><a href="register.php">Register</a></li>
                        <li><a href="forums.php">Forum</a></li>
                        <li><a href="#">Notices</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    </ul>
                </div>
            </div>

            <div id="content">
                <h2>Farmer Registration Details</h2>
                <?php if ( isset( $errors ) && is_array( $errors ) && !empty( $errors ) ): ?>
                    <div id="panel">
                        <ul>
                            <li><?php echo implode( '<li></li>', $errors ); ?></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="" method="post" class="normal_form">
                    <p>
                        <label for="txtFirstName">First Name:</label>
                        <input type="text" id="txtFirstName" name="txtFirstName" value="<?php
                                                                                            if ( isset( $_POST['txtFirstName'] ) ) {
                                                                                                echo $_POST['txtFirstName'];
                                                                                            } elseif ( isset( $farmer->first_name ) ) {
                                                                                                echo $farmer->first_name;
                                                                                            }
                                                                                        ?>" />
                    </p>

                    <p>
                        <label for="txtLastName">Last Name:</label>
                        <input type="text" id="txtLastName" name="txtLastName" value="<?php
                                                                                        if ( isset( $_POST['txtLastName'] ) ) {
                                                                                            echo $_POST['txtLastName'];
                                                                                        } elseif ( isset( $farmer->last_name ) ) {
                                                                                            echo $farmer->last_name;
                                                                                        }
                                                                                    ?>" />
                    </p>

                    <p>
                        <label for="txtPhone">Phone Number:</label>
                        <input type="text" id="txtPhone" name="txtPhone" readonly="readonly" value="<?php
                                                                                    if ( isset( $_POST['txtPhone'] ) ) {
                                                                                        echo $_POST['txtPhone'];
                                                                                    } elseif ( $farmer->phone_number ) {
                                                                                        echo $farmer->phone_number;
                                                                                    }
                                                                                ?>" />
                    </p>

                    <p>
                        <input type="submit" name="register" value="Update Profile" />&nbsp;&nbsp;
                        <input type="button" value="Deactivate Account" onclick="window.location.href='deletefarmer.php'" />
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>