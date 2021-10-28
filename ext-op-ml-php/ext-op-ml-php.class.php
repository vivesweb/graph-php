<?php
/** ext-op-ml.class.php
 *  
 * Class that do some extended operations such math cacls, string calcs, gd calcs
 * Useful for calculations in graphs, Machine learning processes and others
 * 
 * This package of methods has been created to bring together in a single package a set of tools used in machine learning processes.
 * Python is a widely used language in Machine Learning, but there are few tools in PHP, so different useful tools have been created in this regard to bring Machine Learning closer to the PHP programming language.
 * The linspace() method appears in almost all python examples, but in php we don't have any function, so now we have this function.
 * Graphs in Pyplot are used to visualize the data. A library close to this use is being made in PHP. Some functions are required for this operation, such as going from inches to pixels or going from a hexadecimal color to its values ​​in RGB.
 * Knowing what a text occupies in pixels is very useful and is used in the graph generation functions, but since it is an element widely used for other utilities, it has also been decided to implement it in this library.
 * Another of the functions widely used in graphing examples is the use of mathematical functions to square, cube, etc ... the values ​​of an array. This function has been recursively created to be able to perform these calculations.
 * In short, this set of methods aims to gather all those methods that are missing in Machine Learning processes in PHP, but which in turn, can be very useful for other types of applications.
 * 
 * Why ext_op_ml name for this class???? First I wanted to specify it for mathematical functions, but since I needed other functions that were not related to calculations and to add others related to graphical topics, I decided to call it the Machine Learning operations extension: ext_op_ml, but as I have commented previously, its use is beyond the exclusive Machine Learning functions.
 * 
 * @author Rafael Martin Soto
 * @author {@link https://www.inatica.com/ Inatica}
 * @blog {@link https://rafamartin10.blogspot.com/ Blog Rafael Martin Soto}
 * @since October 2021
 * @version 1.0.4
 * @license GNU General Public License v3.0
 * 
 * */
 
 class ext_op_ml
    {
    public function __construct( ) {
		// Void()
	} // / __construct



    /**
     * Return an array with incremental values with steps. Space between points will be ($end-$start)/($numsamples-1)
     * 
     * Range of points, specified as a pair of numeric scalars. $start and $end define the interval over which linspace generates the points.
     * $start and $end can be real or complex and $end can be greater or less than $start. If $end is less than $start, the vector contains descending values.
     *
     * If $numsamples is 1, linspace returns $end.
     * If $numsamples is zero or negative, linspace returns an empty 1-by-0 array.
     * If $numsamples is not an integer value, linspace rounds down and returns floor ($numsamples) points.
     * 
     * ex: linspace(-5,5,7) = [ -5.0000, -3.3333, -1.6667, 0, 1.6667, 3.3333, 5.0000 ]
     * 
     * @param float $start
     * @param float $end
     * @param float $numsamples // Samples between $begin and $end
     * @return array $linspace
     */
    public function linspace( $start, $end, $numsamples = null ){
        $linspace = [];

        if( is_null( $numsamples ) ){
            $numsamples = 100;
        } else if( $numsamples == 1 ){
            unset( $linspace );
            return $end;
        } else if( $numsamples <= 0 ){
            unset( $linspace );
            return [0];
        } else if( !is_integer( $numsamples ) ){
            $numsamples = floor( $numsamples );
        }
        
        $step = ( $end - $start ) / ( $numsamples - 1 );
        for( $i = 0; $i < $numsamples; $i++ ){
            $linspace[] = (float)( $start + ( $i * $step ) );
        }

        // Freemem()
        unset( $step );
        unset( $i );

        return $linspace;
    } // /linspace()



    /**
     * return a powered value/s or an array/multiarray
     * 
     * Ex:
     * pow( [2, 4, 6], 3 ): Pow 3 array [2, 4, 6]:
     *   array(3) { [0]=> int(8) [1]=> int(64) [2]=> int(216) }
     * 
     * @param array $arrvalues
     * @param integer $exp
     * @return array $arrvaluespowered
     */
    public function pow( $values, $exp = 2 ){
        if( is_array( $values ) ){
            foreach( $values as &$value ){
                $value = $this->pow( $value, $exp );
            }
            return $values;
        } else {
            return pow( $values, $exp );
        }
    } // /pow()



    /**
     * Calculate max .ttf length in pixels of arry of strings
     *
     * @param string $text
     * @param string $font_path
     * @param float $text
     * @param string $font_size
     * @param float $angle // Default 0 degrees
     * @return int $max_length
     */
    public function arr_max_len_ttf( $arr, $font_path, $font_size, $angle = 0 ){
        $max_length = 0;
        foreach( $arr as $key => $value){
            $length_value = $this->str_len_ttf( $value, $font_path, $font_size );
            if( $length_value > $max_length ){
                $max_length = $length_value;
            }
        }

        unset( $length_value );
        unset( $value );

        return $max_length;
    }// /arr_max_len_ttf()
    

    
    /** 
     * Return Length in pixels of $text with a True Type Font & Size given
     * 
     * ex:
     * str_len_ttf( "Hellow Wold", __DIR__ . "/fonts/dejavu-fonts-ttf-2.37/ttf/DejaVuSans.ttf", 12 ): Length in pixels of "Hellow Wold" string, with DejaVuSans & size 12:
     *   int(100)
     *
     * Note: Better to get here to remember returned values of imagettfbbox():
     * 0	lower left corner, X position
     * 1	lower left corner, Y position
     * 2	lower right corner, X position
     * 3	lower right corner, Y position
     * 4	upper right corner, X position
     * 5	upper right corner, Y position
     * 6	upper left corner, X position
     * 7	upper left corner, Y position
     *
     * @param string $text
     * @param string $font_path
     * @param float $text
     * @param string $font_size
     * @param float $angle // Default 0 degrees
     * @return int $str_len_ttf
     */
    public function str_len_ttf( $text, $font_path, $font_size, $angle = 0 ){
        $font_measures  = imagettfbbox( $font_size, $angle,  $font_path, $text );
        return abs( $font_measures[2] - $font_measures[0] );
    } // /str_len_ttf()
    

    
    /** 
     * Return Height in pixels of $text with a True Type Font & Size given
     * 
     * ex:
     * str_len_ttf( "Hellow Wold", __DIR__ . "/fonts/dejavu-fonts-ttf-2.37/ttf/DejaVuSans.ttf", 12 ): Height in pixels of "Hellow Wold" string, with DejaVuSans & size 12:
     *   int(100)
     *
     * Note: Better to get here to remember returned values of imagettfbbox():
     * 0	lower left corner, X position
     * 1	lower left corner, Y position
     * 2	lower right corner, X position
     * 3	lower right corner, Y position
     * 4	upper right corner, X position
     * 5	upper right corner, Y position
     * 6	upper left corner, X position
     * 7	upper left corner, Y position
     *
     * @param string $text
     * @param string $font_path
     * @param float $text
     * @param string $font_size
     * @param float $angle // Default 0 degrees
     * @return int $str_len_ttf
     */
    public function str_height_ttf( $text, $font_path, $font_size, $angle = 0 ){
        $font_measures  = imagettfbbox( $font_size, $angle,  $font_path, $text );
        return abs( $font_measures[3] - $font_measures[1] );
    } // /str_height_ttf()



    /**
     * Transform inches in pixels with a dpis given
     * 
     * ex:
     * inch_2_pixels( 6.4, 100): 6.4 inches at 100 dpis in Pixels:
     *   float(640)
     * 
     * @param array $size_inch
     * @param array $dpis // Default 72 dpis
     * @return int $size_inch * $dpis
     */
    public function inch_2_pixels( $size_inch, $dpis = 72 ){
        return (int)( $size_inch * $dpis );
    } // /inch_2_pixels()
	
	

    /**
     * Transform Hex to rgb array ['red', 'green, 'blue']
     * Thanks to https://stackoverflow.com/questions/15202079/convert-hex-color-to-rgb-values-in-php
     * 
     * ex:
     * hex2rgb( "#1f77b4" ): Color "#1f77b4" in vector of integers RGB:
     *   array(3) { [0]=> int(31) [1]=> int(119) [2]=> int(180) }
     * 
     * @param array $hex_color
     * @return array [$r, $g, $b]
     */
    public function hex2rgb( $hex_color ){
        list( $r, $g, $b ) = array_map(
            function ( $c ) {
            return hexdec( str_pad( $c, 2, $c ) );
            },
            str_split( ltrim( $hex_color, '#' ), strlen( $hex_color ) > 4 ? 2 : 1 )
        );

        return [$r, $g, $b];
    } // /hex2rgb()

     /**
     * Returns the magnitude value with the sign of the sign number
     * 
     * Thanks to https://github.com/markrogoyski/math-php/blob/master/src/Arithmetic.php
     *
     * @param float $magnitude
     * @param float $sign
     *
     * @return float $magnitude with the sign of $sign
     */
    public function copySign(float $magnitude, float $sign){
        return ( ( $sign >= 0 )?abs( $magnitude ):-abs( $magnitude ) );
    }

    /**
     * search a number in SORTED array
     * Return id in array
     * if not found, return false
     * NOTE: Be carefull with comparations on id = 0 and id = false.
     *  Use: if( binarySearch() === false )
     * 
     * Thanks to https://www.geeksforgeeks.org/binary-search-php/
     * 
     * @param array $arr
     * @param number $x
     * @param integer $start
     * @param integer $end
     */

    public function binarySearch($arr, $x, $start = 0, $end = null){
        if( is_null( $end) ){
            $end = count( $arr );
        }

        if ($end < $start){
            return false;
        }
        
        $mid = floor(($end + $start)/2);
        
        if ($arr[$mid] == $x) 
            return (int)$mid;
        else if ($arr[$mid] > $x) {
            // call binarySearch on [start, mid - 1]
            return $this->binarySearch($arr, $x, $start, $mid - 1);
        } else {
            // call binarySearch on [mid + 1, end]
            return $this->binarySearch($arr, $x, $mid + 1, $end);
        }
    } // /binarySearch()



     /**
     * method to get frequency values in array between $min & $max. $min <= $values < $max
     * $max is not included in comparation by default. Only lower values that $max will be inside sum of $freq.
     * Set $includemax to true to include the values equal to $max too.  $min <= $values <= $max
     * 
     * @param array $arrval
     * @param array $min
     * @param array $max
     * @param boolean $includemax // if false, values < $max ar included. if true, values <= $max are included
     * @param boolean $arrvalsorted // if the array is sorted you can to pass true for more speed
     * @return integer $freq
     */
    public function freq( $arrval, $min, $max, $includemax = false, $arrvalsorted = false ){
        return ( ( $arrvalsorted ) ? $this->freqsorted( $arrval, $min, $max, $includemax ) : $this->frequnsorted( $arrval, $min, $max, $includemax ) );
    } // /freq()

    

    /**
     * method to get frequency values in SORTED array between $min & $max. $min <= $values < $max
     * $max is not included in comparation by default. Only lower values that $max will be inside sum of $freq.
     * Set $includemax to true to include the values equal to $max too.  $min <= $values <= $max
     * 
     * @param array $arrval
     * @param number $min
     * @param number $max
     * @param boolean $includemax // if false, values < $max ar included. if true, values <= $max are included
     * @return integer $freq
     */
    private function freqsorted( $arrval, $min, $max, $includemax = false ){
        $freq = 0;

        // Binary search
        // Thanks to https://stackoverflow.com/questions/6553970/find-the-first-element-in-a-sorted-array-that-is-greater-than-the-target
        $count  = count( $arrval );
        $low    = 0;
        $high   = $count;

        while( $low != $high ) {
            $mid = ($low + $high) / 2;
            if ($arrval[$mid] < $min) {
                $low = $mid + 1;
            }
            else {
                $high = $mid;
            }
        }
        /* Now, low and high both point to the element in question. */

        // Find $min in array. It may be that there are minors equal before
        $i = $low;
        while( $arrval[$i]>=$min && ($arrval[$i]<$max || ($arrval[$i]==$max && $includemax)) && $i < $count ){
            ++$freq;
            ++$i;
        }

        unset( $count );
        unset( $low );
        unset( $high );
        unset( $mid );
        unset( $i );

        return $freq;
    } // /freqsorted()



    /**
     * method to get frequency values in UNSORTED array between $min & $max. $min <= $values < $max
     * $max is not included in comparation by default. Only lower values that $max will be inside sum of $freq.
     * Set $includemax to true to include the values equal to $max too.  $min <= $values <= $max
     * 
     * @param array $arrval
     * @param number $min
     * @param number $max
     * @param boolean $includemax // if false, values < $max ar included. if true, values <= $max are included
     * @return integer $freq
     */
    private function frequnsorted( $arrval, $min, $max, $includemax = false ){
        $freq = 0;

        foreach($arrval as $val){
            if( $val>=$min && ($val<$max || ($val==$max && $includemax)) ){
                ++$freq;
            }
        }

        unset( $val );

        return $freq;
    } // /frequnsorted()



    /**
     * Metohd to get a Average of array
     * @param array $arrval
     * @return float $avg
     */
    public function avg( $arrval ){
        return array_sum($arrval)/count($arrval);
    } // /avg()



    /**
     * Metohd to check if array is associative array
     * @param array $var
     * @return boolean $is_assoc
     */
    function is_assoc($var){
            return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
    } // /is_assoc()
    
}// /ext_op
?>