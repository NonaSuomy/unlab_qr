<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
require_once("classes/QRCode.class.php");

if ( isset($_GET['q']) && $_GET['q'] != "" )
{
    $data = $_GET['q'];
    //Create a new QRCode Object
    if ( isset($_GET['sa']) && !empty($_GET['sa']) )
    {
        $scale = $_GET['sa'];
    }
    else
    {
        $scale = 0.15;
    }

    if ( isset($_GET['si']) && !empty($_GET['si'] ) )
    {
        $size = $_GET['si'];
    }
    else
    {
        $size = 250;
    }
    $qrCode = new QRCode($data, "img/logo.png", $scale, $size,$size );

    //Get the google QR
    $googleQR       = $qrCode->getGoogleQR($data, $size, $size);

    //recolour the $newLogo
    $newLogo = $qrCode->resizeImage($qrCode->getSourceImage());
    $newLogo = $qrCode->swapColor($newLogo, array("red" => 0, "green"=> 0, "blue" => 0), false, array("red" => 255, "green"=> 0, "blue" => 255) );
    //$newLogo = $qrCode->removeColor($newLogo, "ffffff");

    //Caluclate the Center Point of the QR image
    $qrCode->postionSourceOnDest($newLogo, $googleQR, "bottom_right");


    //Show the outcome
    $result = $qrCode->getSuccess();
    if ( $result === true )
    {
        print $qrCode->save($googleQR);
    }
    else
    {
        var_dump($result);
    }
}
else
{
    print "You need to specify the data you want to put in the QR.";
}