<?php
    require_once 'includes/eagriculture.php';

    if ( $farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    if ( isset( $_POST['submitted'] ) ) {
        $errors = array();

        if ( $_POST['txtPassword'] == "" ) {
            $errors[] = 'Please enter your password to sign in.';
        } else {
            $password = $_POST['txtPassword'];
        }

        if ( $_POST['txtPhone'] == "" ) {
            $errors[] = 'Enter your phone number to register.';
        } else {
            $phoneNumber = $_POST['txtPhone'];
        }

        if ( empty( $errors ) ) {
            $salt = generateSalt( $phoneNumber );
            $password = generateHash( $password, $salt );
            $farmer = Farmer::authenticate( $phoneNumber, $password );
            if ( $farmer ) {
                if ( $farmer->active === 'yes' ) {
                    $farmerSession->login( $farmer );
                    redirect( 'index.php' );
                } elseif ( $farmer->active === 'no' ) {
                    $errors[] = 'Your account is not active.';
                }
            } else {
                $errors[] = 'Wrong login credentials combination. ' . $password;
            }
        }
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
            <div id="content">
                <img src="images/logo2.PNG" />
                <h2>Farmer Login Details</h2>
                <?php if ( isset( $errors ) && is_array( $errors ) && !empty( $errors ) ): ?>
                    <div id="panel">
                        <ul>
                            <li><?php echo implode( '<li></li>', $errors ); ?></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="post" class="normal_form" action="">
                    <p>
                        <label for="txtPhone">Phone Number:</label>
                        <input type="text" name="txtPhone" id="txtPhone" value="<?php if ( isset( $_POST['txtPhone'] ) ) echo $_POST['txtPhone']; ?>" />
                    </p>

                    <p>
                        <label for="txtPassword">Password:</label>
                        <input type="password" id="txtPassword" name="txtPassword" />
                    </p>

                    <p>
                        <input type="submit" value="Sign In" name="submitted" />
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>