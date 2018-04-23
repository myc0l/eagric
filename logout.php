<?php
    require_once 'includes/eagriculture.php';

    $farmerSession->logout();
    redirect( 'index.php' );