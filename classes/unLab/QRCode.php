<?php
/**
 * This class is there to create a Google API QR Code
 * It can copy another image onto the QR code and position it as wanted
 * Furthermore it can alter the image, display it directly or save it to the disk
 * @version 1.0.0
 */

namespace Unlab;

class QRCode
{
    /**
     * Is the Name of the source file for the logo
     * @var string
     * @since 1.0
     */
    private $sourceLogo    = "";


    /**
     * Is the data you want to put in the QR
     * @var string
     * @since 1.0
     */
    private $data          = "";

    /**
     * Is the scale the logo will be resized to its a % where 1= 100% and 0=0%
     * @var double
     * @since 1.0
     */
    private $resizeScale   = 1;


    /**
     * This is the width of the source logo image
     * @var int
     * @since 1.0
     */
    private $sourceWidth   = 0;

    /**
     * This is the height of the source logo image
     * @var int
     * @since 1.0
     */
    private $sourceHeight  = 0;

    /**
     * TThis is the resource for the outcome picture (QR code with Logo )
     * @var image resource
     * @since 1.0
     */
    private $outcome       = NULL;

    /**
     * This is the width of the outcome qr code image
     * @var int
     * @since 1.0
     */
    private $outcomeWidth  = 0;

    /**
     * This is the height of the outcome qr code image
     * @var int
     * @since 1.0
     */
    private $outcomeHeight = 0;

    /**
     * This is the opacity/transparency the logo will be put on to
     * the QR code, default is 100% visibility
     * @var int
     * @since 1.0
     */
    private $opacity       = 100;


    /**
     * If the success is true the image will be shown
     * if not there has been an error, that could have been prevented
     * @var boolean
     * @since 1.0
     */
    private $success       = FALSE;

    /**
     * The constructor takes a few optional parameters
     * @since 1.0
     * @param $data data what you want to put into the qr
     * @param $sourceLogo sourcelogo  name of the logo file
     * @param $resizeScale resizeScale the scale between 0 and 1 how big the logo will be printed onto the QR
     * @param $outcomeWidth outcomeWidth final width of the QR
     * @param $outcomeHeight outcomeHeight final height of the QR
     */
    public function __construct($data = "", $sourceLogo = "", $resizeScale = 1, $outcomeWidth = 0, $outcomeHeight = 0)
    {
        //set the vars when they are not empty or on their default values
        if ( $data != "" )
        {
            $this->data = $data;
        }

        if ( $resizeScale != 1)
        {
            $this->resizeScale = $resizeScale;
        }

        if ( $sourceLogo != "" )
        {
            $this->sourceLogo = $sourceLogo;
        }

        if ( $outcomeWidth != 0 )
        {
            $this->outcomeWidth = $outcomeWidth;
        }

        if ( $outcomeHeight != 0 )
        {
            $this->outcomeHeight    = $outcomeHeight;
        }
    }

    /**
     * Removes a color from the image
     * @since 1.0
     * @param $image image the source image
     * @param $color color  either a HEX String or an array in form of array("green"=>0, "blue"=>0, "red"=>0)
     * @param $xor xor  to determine weather it is NOT the color or only the color
     * @param $tolerance tolerance is the tolerance in the color RGB values + - 5
     */
    public function removeColor($image, $color, $xor = false, $tolerance = 5)
    {
        //get the color array, weather its hex or already an array we want an array in the end
        $colorArray     = $this->getColorArray($color);

        //go through the picture px
        for ( $i = 0; $i < imagesx($image); $i++ )
        {
            for ($j = 0; $j < imagesy($image); $j++)
            {
                //get an index
                $rgb        = imagecolorat($image, $i, $j);
                //get the color for the px at index $rgb
                $colors     = imagecolorsforindex($image, $rgb);
                $k          = 0;

                //determine if the values are the in the target color
                $a = ( !$xor && ( $colors['green'] >= ($colorArray['green'] - $tolerance ) ) && ( $colors['green'] <= ($colorArray['green'] + $tolerance) ) );
                $b = (  $xor && ( $colors['green'] <= ($colorArray['green'] - $tolerance ) ) && ( $colors['green'] >= ($colorArray['green'] + $tolerance) ) );
                if ( $a || $b )
                {
                    $k++;
                }

                $a = ( !$xor && ( $colors['red'] >= ($colorArray['red'] - $tolerance ) ) && ( $colors['red'] <= ($colorArray['red'] + $tolerance) ) );
                $b = (  $xor && ( $colors['red'] <= ($colorArray['red'] - $tolerance ) ) && ( $colors['red'] >= ($colorArray['red'] + $tolerance) ) );
                if ( $a || $b )
                {
                    $k++;
                }

                $a = ( !$xor && ( $colors['blue'] >= ($colorArray['blue'] - $tolerance ) ) && ( $colors['blue'] <= ($colorArray['blue'] + $tolerance) ) );
                $b = (  $xor && ( $colors['blue'] <= ($colorArray['blue'] - $tolerance ) ) && ( $colors['blue'] >= ($colorArray['blue'] + $tolerance) ) );
                if ( $a || $b )
                {
                    $k++;
                }

                //if we have a match then we want to make that px transparent
                if ( $k == 3)
                {
                    $c = imagecolorallocate ($image, $colors['red'],$colors['green'],$colors['blue']);
                    imagecolortransparent($image, $c);
                }
            }
        }
        return $image;
    }

    /**
     * Swaps a color in the image
     * @since 1.0
     * @param $image image the source image
     * @param $color color  either a HEX String or an array in form of array("green"=>0, "blue"=>0, "red"=>0)
     * @param $xor xor  to determine weather it is NOT the color or only the color
     * @param $newColor newColor  either a HEX String or an array in form of array("green"=>0, "blue"=>0, "red"=>0)
     * @param $tolerance tolerance is the tolerance in the color RGB values + - 5
     */
    public function swapColor($image, $color, $xor = false, $newColor, $tolerance = 5)
    {
        //get the colors as color array
        $colorArray     = $this->getColorArray($color);
        $newColorArray  = $this->getColorArray($newColor);

        //go through every px in the image
        for ( $i = 0; $i < imagesx($image); $i++ )
        {
            for ($j = 0; $j < imagesy($image); $j++)
            {
                //get the index for that px
                $rgb        = imagecolorat($image, $i, $j);
                //get the colors for that index
                $colors     = imagecolorsforindex($image, $rgb);
                $k          = 0;

                //determine if the values are the in the target color
                $a = ( !$xor && ( $colors['green'] >= ($colorArray['green'] - $tolerance ) ) && ( $colors['green'] <= ($colorArray['green'] + $tolerance) ) );
                $b = (  $xor && ( $colors['green'] <= ($colorArray['green'] - $tolerance ) ) && ( $colors['green'] >= ($colorArray['green'] + $tolerance) ) );
                if ( $a || $b )
                {
                    $k++;
                }

                $a = ( !$xor && ( $colors['red'] >= ($colorArray['red'] - $tolerance ) ) && ( $colors['red'] <= ($colorArray['red'] + $tolerance) ) );
                $b = (  $xor && ( $colors['red'] <= ($colorArray['red'] - $tolerance ) ) && ( $colors['red'] >= ($colorArray['red'] + $tolerance) ) );
                if ( $a || $b )
                {
                    $k++;
                }

                $a = ( !$xor && ( $colors['blue'] >= ($colorArray['blue'] - $tolerance ) ) && ( $colors['blue'] <= ($colorArray['blue'] + $tolerance) ) );
                $b = (  $xor && ( $colors['blue'] <= ($colorArray['blue'] - $tolerance ) ) && ( $colors['blue'] >= ($colorArray['blue'] + $tolerance) ) );
                if ( $a || $b )
                {
                    $k++;
                }

                //if we have a match then we want to change the color at this index
                if ( $k == 3)
                {
                    $c = imagecolorallocate ($image, $newColorArray['red'], $newColorArray['green'], $newColorArray['blue']);
                    imagesetpixel($image, $i, $j, $c);
                }
            }
        }
        return $image;
    }

    /**
     * Creates an array of colours based on param
     * @since 1.0
     * @param $string / array color "aabbcc" or array('red' => 123, "green" => 123, "blue" => 123)
     */
    private function getColorArray($color)
    {
        $colorArray = array();
        //check if it is an hex value
        if ( ctype_xdigit($color) )
        {
            //convert the hex valu into a numeric val
            $rHex = substr($color, 0, 2);
            $gHex = substr($color, 2, 2);
            $bHex = substr($color, 4, 2);
            $colorArray['red']      = hexdec($rHex);
            $colorArray['green']    = hexdec($gHex);
            $colorArray['blue']     = hexdec($bHex);
        }
        //if its already an array we assume that the array has the correct format
        if ( is_array($color) )
        {
            $colorArray = $color;
        }
        return $colorArray;
    }

    /**
     * We save an image with the current timestamp as a PNG
     * @param $resource image PNG image to save
     * @param $string filename where the file is saved since 1.2
     * @since  1.0
     * @return string The Location to the file
     */
    public function save($image, $filename = "")
    {
        //added in 1.2
        if ( $filename == "" )
        {
            $filename = "img/qr/". time() . ".png";
        }
        imagepng($image, $filename);
        imagedestroy($image);
        return $filename;
    }

    /**
     * Displays the image as PNG, by changin the mime type of the header
     * @since 1.0
     * @param $resource image png image to show
     */
    public function display($image)
    {
        header("Content-type: image/png");
        //Output the image
        imagepng($image);
        //Cleanup
        imagedestroy($image);
    }

    /**
     * Positions the source image onto the destination image based on the positon, default is center
     * @since 1.0
     * @param $resource sourceImage the source image aka the logo
     * @param $resource destinationImage the QR code
     * @param $string position default is center | bottom_right only in V1
     * @return boolean
     */
    public function postionSourceOnDest($sourceImage, $destinationImage, $position = "center")
    {
        //do something based on the position
        //we should introduce more positons, even though the other corners dont make sense
        //otherwise introduce specific X and Y values
        switch ($position)
        {
            case "bottom_right":
                $destX = imagesx($destinationImage) - $this->getResizedSourceWidth();
                $destY = imagesy($destinationImage) - $this->getResizedSourceHeight();
            break;

            case "center":
            default:
                $destX = (imagesx($destinationImage) / 2) - ( $this->getResizedSourceWidth() / 2);
                $destY = (imagesy($destinationImage) / 2) - ($this->getResizedSourceHeight() / 2);
        }
        //should return a bool
        return imagecopymerge($destinationImage, $sourceImage, $destX, $destY, 0, 0, $this->getResizedSourceWidth(), $this->getResizedSourceHeight(), $this->getOpacity());
    }

    /**
     * Resizes the image
     * @param $resource image
     * @since 1.0
     */
    public function resizeImage($image)
    {
        //calculate the new sizes first
        $this->calculateSourceLogo();

        $newLogo        = imagecreatetruecolor($this->sourceWidth, $this->sourceHeight);
        $this->success  = imagecopyresampled($newLogo, $image, 0, 0, 0, 0, $this->getResizedSourceWidth(), $this->getResizedSourceHeight(), $this->getSourceWidth(), $this->getSourceHeight());
        return $newLogo;
    }

    /**
     * Returns the source image
     * @since 1.0
     * @return resource The image or NULL
     */
    public function getSourceImage()
    {
       return $this->getImageFromFile($this->sourceLogo);
    }

    /**
     * Returns an image from filename
     * @param $string filename path to file
     * @since  1.2
     */
    public function getImageFromFile($filename)
    {
        $image  =   imagecreatefrompng( $filename );
        if ($image)
        {
            $this->success = TRUE;
            return $image;
        }
        return NULL;
    }

    /**
     * This sets the height and width of the source image
     * @since 1.0
     * @return void
     */
    private function calculateSourceLogo()
    {
        $this->sourceWidth    = imagesx($this->getSourceImage());
        $this->sourceHeight   = imagesy($this->getSourceImage());
    }

    /**
     * Returns an image resource - Google QR code API
     * @since 1.0
     * @param $string data the data that we want to hide in the QR
     * @param $int width the width of the google QR
     * @param $int height the height of the google QR
     */
    public function getGoogleQR($data = "", $width, $height)
    {
        //The Google QR Code
        $googleQRX  = $width;
        $googleQRY  = $height;
        if ( $this->data == "" && $data != "" )
        {
            $this->data = $data;
        }
        $data       = urlencode($this->data);
        return imagecreatefrompng("http://chart.apis.google.com/chart?chs=".$googleQRX."x".$googleQRY."&cht=qr&chld=H|0&chl=".$data);
    }

    /** GETTER AND SETTER **/
    /** They are not available for all of the vars!**/
    public function setData($val)
    {
        $this->data = $val;
    }

    public function setResizeScale($val)
    {
        $this->resizeScale = $val;
    }

    public function getResizedSourceWidth()
    {
        return intval( $this->sourceWidth * $this->resizeScale );
    }

    public function getResizedSourceHeight()
    {
        return intval( $this->sourceHeight * $this->resizeScale );
    }

    public function getSourceWidth()
    {
        return $this->sourceWidth;
    }

    public function getSourceHeight()
    {
        return $this->sourceHeight;
    }


    public function getOutcomeWidth()
    {
        return $this->outcomeWidth;
    }
    public function getOutcomeHeight()
    {
        return $this->outcomeHeight;
    }

    public function getOpacity()
    {
        return $this->opacity;
    }

    public function setOpacity($val)
    {
        $this->opacity = $val;
    }

    public function getSuccess()
    {
        return $this->success;
    }
}
