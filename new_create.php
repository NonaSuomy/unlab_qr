<?php
/**
 * New Create php as of version 1.2
 * Uses the PHPQRCode library from
 * http://phpqrcode.sourceforge.net
 *
 * @date 8th Nov 2012
 */
//include the phpqrcode library
require_once("config.php");

use Unlab\QRCode as unQR;
use Unlab\Utility as Utility;

if ( Utility::getGetVal("q", FALSE) !== FALSE )
{
	//Get some values
    $data 		= Utility::getGetVal("q", "Visit #unlab on Freenode");
    $scale 		= Utility::getGetVal("logoScale", 0.1);
    $size 		= Utility::getGetVal("qrSize", 250);
    $qrScale    = Utility::getGetVal("qrScale", 4);
    $logoName   = "img/logo.png";
	$filename 	= "img/qr/original-" . time() . ".png";
	//Create the original QR Code
	QRcode::png($data, $filename, 'L', $qrScale, 2);

    //Create a new QRCode Object
    $qrCode 	= new unQR($data, $logoName, $scale, $size,$size );

    //get the plain QRCode
    $logo 		= $qrCode->getSourceImage();
    $qrFinal 	= $qrCode->getImageFromFile($filename);

    //recolour the $newLogo
    $newLogo 	= $qrCode->resizeImage( $logo );
    //$newLogo = $qrCode->swapColor( $newLogo, array("red" => 0, "green"=> 0, "blue" => 0), false, array("red" => 255, "green"=> 0, "blue" => 255) );
    //$newLogo = $qrCode->removeColor($newLogo, "ffffff");

    //Caluclate the Center Point of the QR image
    $qrCode->postionSourceOnDest($newLogo, $qrFinal, "bottom_right");

    //Show the outcome
    if ( $qrCode->getSuccess() === true )
    {
        print unLab\PathLoader::getRootURL() . "/" . $qrCode->save($qrFinal);
    }
}
else
{
    print "You need to specify the data you want to put in the QR.";
}