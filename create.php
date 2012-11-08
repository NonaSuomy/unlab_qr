<?php
/**
 * Create php as of version 1.0
 *
 * @date 8th Nov 2012
 */
//include the phpqrcode library
require_once("config.php");

use Unlab\QRCode as unQR;
use Unlab\Utility as Utility;

if ( Utility::getGetVal("q", FALSE) !== FALSE )
{
    $data       = Utility::getGetVal("q", "Visit #unlab on Freenode");
    $scale      = Utility::getGetVal("logoScale", 0.1);
    $size       = Utility::getGetVal("qrSize", 250);

    $qrCode = new unQR($data, "img/logo.png", $scale, $size,$size );

    //Get the google QR
    $qrFinal       = $qrCode->getGoogleQR($data, $size, $size);

    //recolour the $newLogo
    $newLogo = $qrCode->resizeImage($qrCode->getSourceImage());
    $newLogo = $qrCode->swapColor($newLogo, array("red" => 0, "green"=> 0, "blue" => 0), false, array("red" => 255, "green"=> 0, "blue" => 255) );
    //$newLogo = $qrCode->removeColor($newLogo, "ffffff");

    //Caluclate the Center Point of the QR image
    $qrCode->postionSourceOnDest($newLogo, $qrFinal, "bottom_right");

    //Show the outcome
    if ($qrCode->getSuccess() === true )
    {
        print unLab\PathLoader::getRootURL() . "/" . $qrCode->save($qrFinal);
    }
}
else
{
    print "You need to specify the data you want to put in the QR.";
}