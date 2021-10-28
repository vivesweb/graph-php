<?php


/**
 * example.php of img2img.class.php 
 * 
 * - Convert format from image to another format image
 * - Create thumbnails
 * 
 * REQUERIMENTS:
 * 
 * - PHP with GD enabled: sudo apt install php-gd
 * - PHP with Imagick for some functions: sudo apt install php-imagick
 * - For open pdf's, if you get attempt to perform an operation not allowed by the security policy `PDF'
 *   Add 
 *   <policy domain="coder" rights="read | write" pattern="PDF" />
 *   just before </policymap> in /etc/ImageMagick-7/policy.xml
 *   * Change ImageMagick-7 with your Imagick version
 * 
 * @author Rafael Martin Soto
 * @author {@link https://www.inatica.com/ Inatica}
 * @link https://rafamartin10.blogspot.com/
 * @since October 2021
 * @version 1.0.1
 * @license GNU General Public License v3.0
 */
   

 include __DIR__ . '/img2img.class.php';


// filter instragram old
$img2img = new img2img( __DIR__.'/source_example.jpg' );
$img2img->filter( IMG_FILTER_INSTGR_OLD );
$img2img->save( '/tmp/img2img_result_0.jpg' );
unset( $img2img );
 
 // Example of use directly from php GD
$test = imagecreatefromjpeg( __DIR__.'/source_example.jpg');
$img2img = new img2img( $test );
$img2img->thumb( '120x90' );
$img2img->save( '/tmp/img2img_result_1.jpg' );
unset( $img2img );


// Flip Horizontal
$img2img = new img2img( __DIR__.'/source_example.jpg' );
$img2img->flip( );
$img2img->save( '/tmp/img2img_result_2.jpg' );
unset( $img2img );


// filter sepia
$img2img = new img2img( __DIR__.'/source_example.jpg' );
$img2img->filter( IMG_FILTER_SEPIA, 4, 80 );
$img2img->save( '/tmp/img2img_result_3.jpg' );
unset( $img2img );


// filter Black & White
$img2img = new img2img( __DIR__.'/source_example.jpg' );
$img2img->filter( IMG_FILTER_BLACK_WHITE );
$img2img->save( '/tmp/img2img_result_4.jpg' );
unset( $img2img );


// Example of use from file & use of array default sizes defined by id & Change format to png
// It can use to make different sizes of thumbnails at once
$img2img = new img2img( __DIR__.'/source_example.jpg' );
for($i=5;$i<7;$i++){
   $img2img->thumb( $i );
   $img2img->save( '/tmp/img2img_result_'.$i.'.png' );
}
unset( $img2img );


// filter VIGNETTE
$img2img = new img2img( __DIR__.'/source_example.jpg' );
$img2img->filter( IMG_FILTER_VIGNETTE, 100, 100, 100, 100, ); // arg1: blackPoint, arg2: $whitePoint, arg3: $x, arg4: $y
$img2img->save( '/tmp/img2img_result_7.jpg' );
unset( $img2img );


// create preview from PHOTOSHOP PSD
$img2img = new img2img( __DIR__.'/source_example_psd.psd' );
$img2img->resample( 120, 90 );
$img2img->save( '/tmp/img2img_result_8.jpg' );
unset( $img2img );


// create preview form PDF
$img2img = new img2img( __DIR__.'/source_example_pdf.pdf' );
$img2img->resample( 90, 120 );
$img2img->save( '/tmp/img2img_result_9.jpg' );
unset( $img2img );


// Change size maintaining original aspect ratio
$img2img = new img2img( __DIR__.'/source_example.jpg' );
$img2img->resample( 300, 90 );
$img2img->save( '/tmp/img2img_result_10.jpg' );
unset( $img2img );


// Change size WHITHOUT maintaining original aspect ratio
$img2img = new img2img( __DIR__.'/source_example.jpg' );
$img2img->resample( 300, 90, false );
$img2img->save( '/tmp/img2img_result_11.jpg' );
unset( $img2img );
?>