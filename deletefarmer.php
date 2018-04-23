<?php
    require_once 'includes/eagriculture.php';

    $farmer = Farmer::findByID( $_SESSION['farmerID'] );
    if ( $farmer->deactivate() ) {
        redirect( 'logout.php' );
    }
