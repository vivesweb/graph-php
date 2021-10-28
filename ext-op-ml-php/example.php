<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Example of ext-op.class.php</title>
  <meta name="description" content="Example of ext-op.class.php">
  <meta name="author" content="Rafael Martin Soto">

</head>
<body><?php
/** ext-op-ml.class.php
 *  
 * Class that do some extended operations such math cacls, string calcs, gd calcs
 * Useful for calculations in graphs, Machine learning processes and others
 * 
 * Note: For do de test with str_len_ttf() you need specify a true type font path with the font file .ttf. In this example is used https://dejavu-fonts.github.io/
 * 
 * @author Rafael Martin Soto
 * @author {@link https://www.inatica.com/ Inatica}
 * @blog {@link https://rafamartin10.blogspot.com/ Blog Rafael Martin Soto}
 * @since October 2021
 * @version 1.0.0
 * @license GNU General Public License v3.0
 * 
 * */
 
 require_once __DIR__ . '/ext-op-ml-php.class.php';

 $ext_op = new ext_op_ml();

 echo '<strong>linspace( -5, 5 )</strong>: -5 to 5 array in 100 steps:<br />';
 var_dump( $ext_op->linspace( -5, 5 ) );
 
 echo '<br /><br />';
 

 echo '<strong>linspace( -5, 5, 7 )</strong>: -5 to 5 array in 7 steps:<br />';
 var_dump( $ext_op->linspace( -5, 5, 7 ) );
 
 echo '<br /><br />';



  echo '<strong>pow( [2, 4, 6] )</strong>: Pow 2 array [2, 4, 6]:<br />';
 var_dump( $ext_op->pow( [2, 4, 6] ) );
 
 echo '<br /><br />';
 

 echo '<strong>pow( [2, 4, 6], 3 )</strong>: Pow 3 array [2, 4, 6]:<br />';
 var_dump( $ext_op->pow( [2, 4, 6], 3 ) );
 
 echo '<br /><br />';
 

 echo '<strong>str_len_ttf( "Hellow Wold", __DIR__ . "/fonts/dejavu-fonts-ttf-2.37/ttf/DejaVuSans.ttf", 12 )</strong>: Length in pixels of "Hellow Wold" string, with DejaVuSans & size 12:<br />';
 $font_path = __DIR__ . '/fonts/dejavu-fonts-ttf-2.37/ttf/DejaVuSans.ttf';
 if( !file_exists( $font_path) ){
    echo 'For do this test you need to specify a valid file name. '.$font_path.' not found. You can download a test fonts from here <a href="https://dejavu-fonts.github.io/">https://dejavu-fonts.github.io/</a>';
 } else {
    var_dump( $ext_op->str_len_ttf( 'Hellow Wold', $font_path, 12 ) );
 }
 
 echo '<br /><br />';
 

 echo '<strong>inch_2_pixels( 6.4, 100)</strong>: 6.4 inches at 100 dpis in Pixels:<br />';
 var_dump( $ext_op->inch_2_pixels( 6.4, 100) );
 
 echo '<br /><br />';
 
 
 echo '<strong>hex2rgb( "#1f77b4" )</strong>: Color "#1f77b4" in vector of integers RGB:<br />';
 var_dump( $ext_op->hex2rgb( '#1f77b4' ) );
 
 echo '<br /><br />';
 
 echo '<br />';

 
 echo '<strong>From V.1.0.1:</strong><br />';
 echo '<strong>-------------------</strong><br />';
 
 echo '<br />';
 
 
 echo '<strong>copysign(1, 50)</strong>:<br />';
 var_dump( $ext_op->copysign(1, 50) );
 
 echo '<br /><br />';
 
 
 echo '<strong>copysign(1, -50)</strong>:<br />';
 var_dump( $ext_op->copysign(1, -50) );
 
 echo '<br /><br />';
 
 echo '<br />';

 
 echo '<strong>From V.1.0.2:</strong><br />';
 echo '<strong>-------------------</strong><br />';
 
 echo '<br />';
 
 
 echo '<strong>avg([1, 2, 3, 4, 5])</strong>:<br />';
 var_dump( $ext_op->avg( [1, 2, 3, 4, 5]) );
 
 echo '<br /><br />';
 
 
 echo '<strong>freq([1, 2, 2, 3, 3, 4, 5], 2, 3)</strong>:<br />';
 var_dump( $ext_op->freq( [1, 2, 2, 3, 3, 4, 5], 2, 3) );
 
 echo '<br /><br />';
 
 
 echo '<strong>freq([1, 2, 2, 3, 3, 4, 5], 2, 3, true)</strong>:<br />';
 var_dump( $ext_op->freq( [1, 2, 2, 3, 3, 4, 5], 2, 3, true) );
 
 echo '<br /><br />';
 
 
 
 
 echo '<strong>binarySearch([1, 2, 3, 4, 5], 4)</strong>:<br />';
 var_dump( $ext_op->binarySearch([1, 2, 3, 4, 5], 4) );
 
 echo '<br /><br />';
 ?>
 </body>
 </html>