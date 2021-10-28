<?php
 /** example.php // example file for graph-php.class.php
  *  
  * 
  * @author Rafael Martin Soto
  * @author {@link https://www.inatica.com/ Inatica}
  * @blog {@link https://rafamartin10.blogspot.com/ Blog Rafael Martin Soto}
  * @since October 2021
  * @version 1.0.0
  * @license GNU General Public License v3.0
  *
  * */

require __DIR__ . '/graph-php.class.php';
?><!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Example Graph-PHP</title>
  <meta name="description" content="Example Graph-PHP">
  <meta name="author" content="SitePoint">

  <meta property="og:title" content="Example Graph-PHP">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://www.inatica.com">
  <meta property="og:description" content="Example Graph-PHP">

</head>
<body>
<?php

//$graph = new graph();
//$max_min = [10, 15];
//print "for ".$max_min[0]."/".$max_min[1]." diff ".($max_min[1]-$max_min[0]).": ";
//echo $graph->compute_offset($max_min[0])."/".$graph->compute_offset($max_min[1]);
//var_dump($graph->compute_offset($max_min) );
  
//unset($graph);



$graph = new graph();
$graph->bar( [1, 2, 3, 4] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();
$graph->title("Here your graph TITLE");
$graph->bar( [1, 2, 3, 4] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$graph->ylabel( 'Here your graph Y LABEL' );
$graph->bar( [1, 2, 3, 4] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$graph->xlabel( 'Here your graph X LABEL' );
$graph->bar( [1, 2, 3, 4] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);




$graph = new graph();

$graph->bar( [10, 20, 30, 40], [1, 4, 9, 16] );
$graph->title("With X & Y Values");
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();

$graph->bar( [1, 2, 3, 4], [1, 4, 9, 16] );
$graph->axes([0, 6, 0, 20]);
$graph->title("Limits Axis X & Y");
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$graph->plot( [1, 1.5, 2, 1.8, 3] );
$graph->title("Simple Plot graph with line");
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$graph->plot( [1, 1.5, 2, 1.8, 3] );
$graph->plot( [2, 2.8, 1.7, 2, 2.3] );
$graph->title("Multi Line");
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$x = $graph->math->linspace( 0, 2, 50 );
$graph->plot( $x, $x, ['label'=>'linear'] );
$graph->plot( $x, $graph->math->pow($x, 2), ['label'=>'quadratic'] );
$graph->plot( $x, $graph->math->pow($x, 3), ['label'=>'cubic'] );
$graph->xlabel('x label');
$graph->ylabel('y label');
$graph->title("Simple Plot. With Legend & Labels X, Y");
$graph->legend( );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->bar( [1, 2, 3, 4], [10, 9, 10, 8] );
$graph->bar( [1, 2, 3, 4], [8, 6, 9, 7] );
$graph->bar( [1, 2, 3, 4], [6, 5, 7, 5] );
$graph->bar( [1, 2, 3, 4], [3, 3, 4, 2] );
$graph->axes([0, 6, 0, 20]);
$graph->title( 'Multi Bar & fixed Axis Values' );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->bar( [1, 2, 3, 4, 5, 6, 7], [1, 4, 9, 16, 17, 18, 17] );
$graph->plot( [1, 2, 3, 4, 5, 6, 7], [10,8, 5, 10,15, 16, 15] );
$graph->title( 'Bar & Line' );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->bar( [1, 2, 3, 4, 5, 6, 7], [1, 4, 9, 16, 17, 18, 17] );
$graph->plot( [1, 2, 3, 4, 5, 6, 7], [10,8, 5, 10,15, 16, 15] );
$graph->title( 'Legend' );
$graph->legend( );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->bar( [1, 2, 3, 4, 5, 6, 7], [1, 4, 9, 16, 17, 18, 17], ['label'=>'Name Legend 1'] );
$graph->plot( [1, 2, 3, 4, 5, 6, 7], [10,8, 5, 10,15, 16, 15], ['label'=>'Name Legend 2'] );
$graph->title( 'Legend with label names' );
$graph->legend( );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();

$graph->plot( [4, 5, 6, 7], [1, 4, 9, 16], ['marker' => 'x'] );
$graph->plot( [4, 5, 6, 7], [5, 8, 7, 10], ['marker' => 'o'] );
$graph->axes([2, 9, 0, 20]);
$graph->title( 'Lines & Legend with "x" & "o" markers' );
$graph->legend( );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);

$graph = new graph();

$graph->plot( [4, 5, 6, 7], [1, 4, 9, 16], ['marker' => 'd'] );
$graph->plot( [4, 5, 6, 7], [5, 8, 7, 10], ['marker' => 'd'] );
$graph->axes([2, 9, 0, 20]);
$graph->title( '"d" - Diamond Marker' );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->plot( [4, 5, 6, 7], [1, 4, 9, 16], 'o' );
$graph->plot( [4, 5, 6, 7], [5, 8, 7, 10], 'x-' );
$graph->axes([2, 9, 0, 20]);
$graph->title( 'Line with marker & only markers' );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);





$graph = new graph();
$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
$graph->title( 'Colors, disctont. line & markers "--", "square", "^"' );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->bar( [4.2, 4.4, 4.6, 4.8, 5, 5.2, 5.4, 5.6, 5.8, 6], [1, 4, 9, 16, 1, 4, 9, 16, 5, 4] );
$graph->xlabel( 'entry a' );
$graph->title( 'Histogram of IQ' );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->plot( [1, 2, 3, 4], [1, 4, 9, 16] );
$graph->plot( [1, 2, 3, 4], [10, 3, 5, 10] );
$graph->plot( [1, 2, 3, 4], [5, 4, 3, 4] );
$graph->plot( [1, 2, 3, 4], [7, 4, 10, 15] );
$graph->plot( [1, 2, 3, 4], [7, 8, 4, 2] );
$graph->plot( [1, 2, 3, 4], [2, 1, 2, 20] );
$graph->plot( [1, 2, 3, 4], [20, 10, 20, 20] );
$graph->plot( [1, 2, 3, 4], [3, 4, 5, 4] );
$graph->plot( [1, 2, 3, 4], [7, 8, 9, 10] );
$graph->plot( [1, 2, 3, 4], [10, 11, 12, 13] );
$graph->plot( [1, 2, 3, 4], [14, 15, 16, 17] );
$graph->plot( [1, 2, 3, 4], [16, 17, 18, 19] );
$graph->axes([null, null, 0, 20]);
$graph->title( 'A lot of lines' );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();
$graph->set_drawguidelines( );

$graph->plot( [1, 2, 3, 4], [1, 4, 9, 16] );
$graph->plot( [1, 2, 3, 4], [10, 3, 5, 10] );
$graph->plot( [1, 2, 3, 4], [5, 4, 3, 4] );
$graph->plot( [1, 2, 3, 4], [7, 4, 10, 15] );
$graph->plot( [1, 2, 3, 4], [7, 8, 4, 2] );
$graph->plot( [1, 2, 3, 4], [2, 1, 2, 20] );
$graph->plot( [1, 2, 3, 4], [20, 10, 20, 20] );
$graph->plot( [1, 2, 3, 4], [3, 4, 5, 4] );
$graph->plot( [1, 2, 3, 4], [7, 8, 9, 10] );
$graph->plot( [1, 2, 3, 4], [10, 11, 12, 13] );
$graph->plot( [1, 2, 3, 4], [14, 15, 16, 17] );
$graph->plot( [1, 2, 3, 4], [16, 17, 18, 19] );
$graph->axes([null, null, 0, 20]);
$graph->title( 'Better with Guidelines' );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->plot( [4, 5, 6, 7], [1, 4, 9, 16], ['marker' => __DIR__ . '/author.png',] );
$graph->title( 'Custom image ^_^\'' );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->plot( [4, 5, 6, 7], [1, 4, 9, 16], ['marker' => __DIR__ . '/custom_marker.png', 'label'=>'PHP'] );
$graph->plot( [4, 5, 6, 7], [3, 7, 13, 8], ['marker' => __DIR__ . '/tux.png', 'label'=>'GNU/Linux'] );
$graph->plot( [4, 5, 6, 7], [5, 2, 7, 5], ['marker' => __DIR__ . '/nginx.png', 'label'=>'NGINX'] );
$graph->legendwidthlines( 65 );
$graph->legendlabelheight( 33 );
$graph->title( 'Custom Images with Legend' );
$graph->legend( );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$graph->plot( [4, 5, 6, 7], [1, 4, 9, 16], ['marker' => __DIR__ . '/custom_marker.png', 'label'=>'PHP'] );
$graph->plot( [4, 5, 6, 7], [3, 7, 13, 8], ['marker' => __DIR__ . '/tux.png', 'label'=>'GNU/Linux'] );
$graph->plot( [4, 5, 6, 7], [5, 2, 7, 5], ['marker' => __DIR__ . '/nginx.png', 'label'=>'NGINX'] );
$graph->set_drawguidelines( );
$graph->legendwidthlines( 65 );
$graph->legendlabelheight( 33 );
$graph->title( 'Better with Guidelines' );
$graph->legend( );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);





$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$x = $graph->math->linspace( 0, 5, 20 );
$graph->title( 'Original Background' );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);





$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Scaled Bicubic Background' );
$graph->bckgr_img_gd->imagescale( 64, -1, IMG_BICUBIC );
$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Smooth Background' );
$graph->bckgr_img_gd->filter( IMG_FILTER_SMOOTH, -7 );
$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Gaussian Blur Filter Background' );
for($i = 0; $i< 10; $i++ ){
  $graph->bckgr_img_gd->filter( IMG_FILTER_GAUSSIAN_BLUR );
}
$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);







$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Sepia, Brightness & contrast Background' );
$graph->bckgr_img_gd->filter( IMG_FILTER_SEPIA, 4, 80 );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, -50 );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, 100 );
$graph->bckgr_img_gd->filter( IMG_FILTER_CONTRAST, 50 );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, 100 );
$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);




$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Gray, Brightness & contrast Background' );
$graph->bckgr_img_gd->filter( IMG_FILTER_GRAYSCALE );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, -50 );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, 100 );
$graph->bckgr_img_gd->filter( IMG_FILTER_CONTRAST, 50 );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, 115 );
$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);




$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'B/W, Brightness & contrast Background' );
$graph->bckgr_img_gd->filter( IMG_FILTER_BLACK_WHITE );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, -50 );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, 100 );
$graph->bckgr_img_gd->filter( IMG_FILTER_CONTRAST, 50 );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, 100 );
$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);




// Interpolation IMG_NEAREST_NEIGHBOUR
$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Scaled & unscaled with Bilinear/G. Blur Background' );

$graph->bckgr_img_gd->imagescale( 64, -1, IMG_BILINEAR_FIXED );
  $graph->bckgr_img_gd->filter( IMG_FILTER_GAUSSIAN_BLUR );
$graph->bckgr_img_gd->imagescale( 400, -1, IMG_BILINEAR_FIXED );

$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



// Interpolation IMG_NEAREST_NEIGHBOUR
$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Scaled & unscaled with Bicubic/G. Blur Background x1' );

$graph->bckgr_img_gd->imagescale( 64, -1, IMG_BICUBIC );
$graph->bckgr_img_gd->filter( IMG_FILTER_GAUSSIAN_BLUR );
$graph->bckgr_img_gd->imagescale( 400, -1, IMG_BICUBIC );

$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



// Interpolation IMG_NEAREST_NEIGHBOUR
$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Scaled & unscaled with Bicubic/G. Blur Background x3' );

$graph->bckgr_img_gd->imagescale( 64, -1, IMG_BICUBIC );
for($i = 0; $i< 3; $i++ ){
  $graph->bckgr_img_gd->filter( IMG_FILTER_GAUSSIAN_BLUR );
}
$graph->bckgr_img_gd->imagescale( 400, -1, IMG_BICUBIC );

$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



// Interpolation IMG_NEAREST_NEIGHBOUR
$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Scaled & unscaled with Bicubic/G. Blur Background x5' );

$graph->bckgr_img_gd->imagescale( 64, -1, IMG_BICUBIC );
for($i = 0; $i< 5; $i++ ){
  $graph->bckgr_img_gd->filter( IMG_FILTER_GAUSSIAN_BLUR );
}
$graph->bckgr_img_gd->imagescale( 400, -1, IMG_BICUBIC );

$x = $graph->math->linspace( 0, 5, 20 );
$graph->plot( [ [$x, $x, 'r--'], [$x, $graph->math->pow($x, 2), 'bs'], [$x, $graph->math->pow($x, 3), 'g^'] ] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$x = $graph->math->linspace( 0, 2, 50 );
$graph->plot( $x, $x, ['label'=>'linear'] );
$graph->plot( $x, $graph->math->pow($x, 2), ['label'=>'quadratic'] );
$graph->plot( $x, $graph->math->pow($x, 3), ['label'=>'cubic'] );
$graph->xlabel('Don\'t use darkness images O_o. Is an example');
$graph->ylabel('y label');
$graph->title("Simple Plot with background & Legend");
$graph->legend( );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->set_drawguidelines( );
$x = $graph->math->linspace( 0, 2, 50 );
$graph->plot( $x, $x, ['label'=>'linear'] );
$graph->plot( $x, $graph->math->pow($x, 2), ['label'=>'quadratic'] );
$graph->plot( $x, $graph->math->pow($x, 3), ['label'=>'cubic'] );
$graph->xlabel('Horrible, but is an example of what you can do ;D');
$graph->ylabel('y label');
$graph->title("Simple Plot with background, Legend & Guidelines");
$graph->legend( );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);







$graph = new graph();
$graph->plot( [4, 5, 6, 7], [1, 4, 9, 13], ['marker' => __DIR__ . '/custom_marker.png', 'label'=>'PHP'] );
$graph->plot( [4, 5, 6, 7], [3, 6, 12, 8], ['marker' => __DIR__ . '/tux.png', 'label'=>'GNU/Linux'] );
$graph->plot( [4, 5, 6, 7], [5, 2, 7, 5], ['marker' => __DIR__ . '/nginx.png', 'label'=>'NGINX'] );
$graph->legendwidthlines( 65 );
$graph->legendlabelheight( 33 );
$graph->imread( __DIR__ .'/background_example.jpg');
$graph->title( 'Better use of background' );
$graph->set_drawguidelines( );
$graph->bckgr_img_gd->filter( IMG_FILTER_GRAYSCALE );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, -50 );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, 100 );
$graph->bckgr_img_gd->filter( IMG_FILTER_CONTRAST, 50 );
$graph->bckgr_img_gd->filter( IMG_FILTER_BRIGHTNESS, 115 );
$graph->bckgr_img_gd->flip( );
$graph->legend();
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);







$graph = new graph();
$graph->plot( [40000, 50000, 60000, 70000], [1, 4, 9, 13] );
$graph->title( 'Rotation Xticks' );
$graph->set_drawguidelines( );
$graph->xticks( ['rotation' => 45]);
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$arr_values = [
    [ [1, 1.5, 2, 2, 3, 4], [10, 9.5, 9, 10, 8, 9] ],
    [ [4, 5, 5.7, 6, 7, 8], [8, 6, 7.3, 8, 7, 8] ],
];

$graph->title( 'Scatter' );
$graph->scatter( $arr_values );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);



$graph = new graph();

$arr_values = [
    [ [1, 1.5, 2, 2, 3, 4], [10, 9.5, 9, 10, 8, 9], ['label'=>'Male'] ],
    [ [4, 5, 5.7, 6, 7, 8], [8, 6, 7.3, 8, 7, 8], ['label'=>'Female'] ],
];

$graph->title( 'Scatter & legend' );
$graph->scatter( $arr_values );
$graph->legend( );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$graph->title( 'VALUES FOR HISTOGRAM' );
$graph->bar( [10, 11, 40, 45, 50, 55, 60, 60, 70, 80, 85, 90, 95, 100, 105, 106, 107, 108, 109, 110, 111, 112, 123, 140, 150] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$graph->title( 'DEFAULT HISTOGRAM' );
$graph->hist( [10, 11, 40, 45, 50, 55, 60, 60, 70, 80, 85, 90, 95, 100, 105, 106, 107, 108, 109, 110, 111, 112, 123, 140, 150] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$graph->title( '30 xval HISTOGRAM' );
$graph->hist( [10, 11, 40, 45, 50, 55, 60, 60, 70, 80, 85, 90, 95, 100, 105, 106, 107, 108, 109, 110, 111, 112, 123, 140, 150], ['num_blocks' => 30] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


$graph = new graph();
$graph->title( '7 xval HISTOGRAM' );
$graph->hist( [10, 11, 40, 45, 50, 55, 60, 60, 70, 80, 85, 90, 95, 100, 105, 106, 107, 108, 109, 110, 111, 112, 123, 140, 150], ['num_blocks' => 7] );
?>

  <img src="<?php echo $graph->output_gd_png_base64( );?>">
  <?php
  
unset($graph);


?>
</body>
</html>