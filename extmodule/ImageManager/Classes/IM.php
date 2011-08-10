<?php

/***********************************************************************
** Title.........:  ImageMagick Driver
** Version.......:  1.0
** Author........:  Xiang Wei ZHUO <wei@zhuo.org>
** Filename......:  IM.php
** Last changed..:  30 Aug 2003 
** Notes.........:  Orginal is from PEAR
**/

// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Peter Bowyer <peter@mapledesign.co.uk>                      |
// +----------------------------------------------------------------------+
//
// $Id: IM.php 27 2004-04-01 08:31:57Z Wei Zhuo $
//
// Image Transformation interface using command line ImageMagick
//

require_once "Transform.php";

Class Image_Transform_Driver_IM extends Image_Transform
{
    /**
     * associative array commands to be executed
     * @var array
     */
    var $command = array();
    var $handle = 0;

    /**
     *
     *
     */
    function __construct()
    {
        return true;
    } // End Image_IM

    /**
     * Load image
     *
     * @param string filename
     *
     * @return mixed none or a PEAR error object on error
     * @see PEAR::isError()
     */
    function load($image)
    {

        $this->uid = md5($_SERVER['REMOTE_ADDR']);
        /*if (!file_exists($image)) {
            return PEAR::raiseError('The image file ' . $image . ' does\'t exist', true);
        }*/
        $this->image = $image;
        $this->_get_image_details($image);
        $this->handle=@imagick_readimage( $image ) ;        
        
    } // End load

    /**
     * Resize Action
     *
     * @param int   new_x   new width
     * @param int   new_y   new height
     *     
     */
    function _resize($new_x, $new_y)
    {           
        
        $this->command['resize'] = "${new_x}x${new_y}";
        $this->new_x = $new_x;
        $this->new_y = $new_y;
		
    } // End resize

    /**
     * Crop the image
     *
     * @param int $crop_x left column of the image
     * @param int $crop_y top row of the image
     * @param int $crop_width new cropped image width
     * @param int $crop_height new cropped image height
     */
    function crop($crop_x, $crop_y, $crop_width, $crop_height) 
    {           
        $this->command['crop'] = "{$crop_x}x{$crop_y}x{$crop_width}x{$crop_height}";		
    }

    /**
     * Flip the image horizontally or vertically
     *
     * @param boolean $horizontal true if horizontal flip, vertical otherwise
     */
    function flip($horizontal) 
    {
        if($horizontal){            
            $this->command['flop'] = "1";
        }
        else{            
            $this->command['flip'] = "1";
        }

		
    }
    /**
     * rotate
     *
     * @param   int     angle   rotation angle
     * @param   array   options no option allowed
     *
     */
    function rotate($angle, $options=null)
    {
        if ('-' == $angle{0}) {
            $angle = 360 - substr($angle, 1);
        }         
         $this->command['rotate'] = "$angle";		 
    } // End rotate

    /**
     * addText
     *
     * @param   array   options     Array contains options
     *                              array(
     *                                  'text'  The string to draw
     *                                  'x'     Horizontal position
     *                                  'y'     Vertical Position
     *                                  'Color' Font color
     *                                  'font'  Font to be used
     *                                  'size'  Size of the fonts in pixel
     *                                  'resize_first'  Tell if the image has to be resized
     *                                                  before drawing the text
     *                              )
     *
     * @return none
     * @see PEAR::isError()
     */
    function addText($params)
    {
        $default_params = array(
                                'text' => 'This is Text',
                                'x' => 10,
                                'y' => 20,
                                'color' => 'red',
                                'font' => 'Arial.ttf',
                                'resize_first' => false // Carry out the scaling of the image before annotation?
                                );
                                
                                        
         $params = array_merge($default_params, $params); 
         
         $this->command['text'] = $params{'font'}.'x'.$params{'color'}.'x'.$params{'x'}.'x'.$params{'y'}.'x'.$params{'text'};              
         		 
       
    } // End addText

    /**
     * Adjust the image gamma
     *
     * @param float $outputgamma
     *
     * @return none
     */
    function gamma($outputgamma=1.0) {       
       $this->command['gamma'] = "$outputgamma";	   
    }

    /**
     * Save the image file
     *
     * @param $filename string  the name of the file to write to
     * @param $quality  quality image dpi, default=75
     * @param $type     string  (JPG,PNG...)
     *
     * @return none
     */
    function save($filename, $type='', $quality = 85)
    {
    	$this->remake();
    	@imagick_writeimage( $this->handle, $filename );
    	chmod($filename,0664);
		
    } // End save

    /**
     * Display image without saving and lose changes
     *
     * @param string type (JPG,PNG...);
     * @param int quality 75
     *
     * @return none
     */
    function display($type = '', $quality = 75)
    {
    	$this->remake();
        $image_data = @imagick_image2blob( $this->handle );
        header( "Content-type: " .@imagick_getmimetype( $this->handle ). "\n\n" ) ;
        
		print $image_data ;
    }
    
    
    function remake(){
    	foreach($this->command as $k=>$v){
    		$param=explode('x',$v);
    		switch($k){
    			case('resize'):
    				@imagick_resize( $this->handle, $param[0], $param[1], IMAGICK_FILTER_GAUSSIAN, 0);
    			break;
    		
    			case('crop'):
    				@imagick_crop( $this->handle, $param[0], $param[1], $param[2], $param[3] );
    			break;
    			
    			case('flop'):
    				@imagick_flop( $this->handle );
    			break;
    			
    			case('flip'):
    				@imagick_flip( $this->handle );
    			break;
    				
    			case('rotate'):
    				@imagick_rotate( $this->handle, $param[0] );
    			break;
    			
    			case('gamma'):
    				@imagick_gamma( $this->handle, $param[0] ) ;
    			break;
    			
    			case('text'):
    				@imagick_begindraw( $this->handle ) ;
			        @imagick_setfontface( $this->handle, $param[0] );
			        @imagick_setfillcolor( $this->handle, $param[1] );
			        @imagick_drawannotation( $this->handle, $param[2], $param[3], $param[4]);   			        
    			break;
    		
    		}
    		
    	}
    @imagick_setcompressionquality ($this->handle,85);
    }


    /**
     * Destroy image handle
     *
     * @return none
     */
    function free()
    {
        return true;
    }	

} // End class ImageIM
?>
