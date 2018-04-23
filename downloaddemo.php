<?php
    require_once 'includes/eagriculture.php';

    if ( isset( $_GET['demoid'] ) && !empty( $_GET['demoid'] ) && is_numeric( $_GET['demoid'] ) ) {
        $demoID = $_GET['demoid'];
        $demo = Demo::findByID( $demoID );
        if ( $demo ) {
            $file = 'demos' . DS . $demo->file;
            if ( file_exists( $file ) ) {
                $ext = Mime( $file );
                $size = filesize( $file );
                header( 'Content-Description: File Transfer' );

                header( 'Content-Disposition: attachment; filename="' . $file . '"' );
                header( 'Expires: 0' );
                header( 'Cache-Control: must-revalidate' );
                header( 'Pragma: public' );
                header( 'Content-Length: ' . filesize( $file ) );
                readfile( $file );
                // redirect( 'demonstrations.php' );
            }
        } else {
            die( '<p>Record not found. Click <a href="demonstrations.php">here</a> to go back.</p>' );
        }
    } else {
        die( '<p>You have access this page in error. Click <a href="index.php">here</a> to go back.</p>' );
    }