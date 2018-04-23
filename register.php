<?php
    require_once 'includes/eagriculture.php';
    if ( $farmerSession->isLoggedIn() ) {
        redirect( 'index.php' );
    }

    if ( isset( $_POST['register'] ) ) {
        $errors = array();
        $newFarmer = new Farmer();

        if ( $_POST['cbpFarmingType'] == "" ) {
            $errors[] = 'Please select the type of farming you are doing.';
        } else {
            $newFarmer->farming_typeID = $_POST['cbpFarmingType'];
        }
        if ( $_POST['txtPhone'] == "" ) {
            $errors[] = 'Please enter your phone number without the leading zero.';
        } else {
            $newFarmer->phone_number = $_POST['txtPhone'];
        }

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

        if ( $_POST['txtPassword'] == "" ) {
            $errors[] = 'Please enter your password.';
        } else {
            if ( $_POST['txtConfirm'] == "" ) {
                $errors[] = 'Please confirm your password.';
            } else {
                if ( preg_match( '/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){8,16}$/', $_POST['txtConfirm'] ) ) {
                    if ( $_POST['txtConfirm'] == $_POST['txtPassword'] ) {
                        $salt = generateSalt( $newFarmer->phone_number );
                        $newFarmer->password = generateHash( $_POST['txtConfirm'], $salt );
                    } else {
                        $errors[] = 'Passwords do not match.';
                    }
                } else {
                    $errors[] = 'Password must contain at least one uppercase character, one lowercase character and one numeric character.';
                }
            }
        }

        if ( empty( $errors ) ) {
            $sql = "select * from tblfarmers where phone_number = '{$newFarmer->phone_number}'";
            $result = $database->escapeValue( $sql );
            if ( $database->numRows( $result ) == 0 ) {
                if ( $newFarmer->save() ) {
                    redirect( 'login.php' );
                } else {
                    $errors[] = 'You could not be registered now. Try again later.';
                }
            } else {
                $errors[] = 'Phone number already exists. Enter a different phone number to complete registration.';
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
            <div id="header">
                <img src="images/logo2.PNG" />
                <div class="nav">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="articles.php">Articles</a></li>
                        <li><a href="adverts.php">Advertisements</a></li>
                        <!--<li><a href="users.php">Users</a></li> -->
                        <li><a href="demonstrations.php">Demonstration Videos</a></li>
                        <li><a href="register.php">Register</a></li>
                        <li><a href="login.php">Log in</a></li>
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
                        <input type="text" id="txtFirstName" name="txtFirstName" value="<?php if ( isset( $_POST['txtFirstName'] ) ) echo $_POST['txtFirstName']; ?>" />
                    </p>

                    <p>
                        <label for="txtLastName">Last Name:</label>
                        <input type="text" id="txtLastName" name="txtLastName" value="<?php if ( isset( $_POST['txtLastName'] ) ) echo $_POST['txtLastName']; ?>" />
                    </p>

                    <p>
                        <label for="txtPhone">Phone Number:</label>
                        <input type="text" id="txtPhone" name="txtPhone" value="<?php if ( isset( $_POST['txtPhone'] ) ) echo $_POST['txtPhone']; ?>" />
                    </p>

                    <p>
                        <label for="cboFarmingTypeID">Farming Type:</label>
                        <select id="cboFarmingTypeID" name="cboFarmingTypeID">
                            <option>Select Farming Type</option>
                            <?php
                                $sql = "select * from tblfarmingtypes order by farming_type asc ";
                                $result = $database->query( $sql );
                                while( $row = $database->fetchArray( $result ) ) {
                                    if ( isset( $_POST['cboFarmingTypeID'] ) && ( $_POST['cboFarmingTypeID'] == $row['farming_type_id'] ) ) {
                                        $selectedFType = ' selected ';
                                    } else {
                                        $selectedFType = '';
                                    }
                                    ?>
                                    <option value="<?php echo $row['farming_type_id']; ?>"<?php echo $selectedFType; ?>><?php echo $row['farming_type']; ?></option>
                                <?php
                                }
                            ?>
                        </select>
                    </p>

                    <p>
                        <label for="txtPassword">Password:</label>
                        <input type="password" name="txtPassword" id="txtPassword" />
                    </p>

                    <p>
                        <label for="txtConfirm">Confirm Password:</label>
                        <input type="password" name="txtConfirm" id="txtConfirm" />
                    </p>

                    <p>
                        <input type="submit" name="register" value="Register" />
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>