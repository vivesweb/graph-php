<?php
 /** graph-php.class.php
  *  
  * Class for generate graphs
  * 
  * @author Rafael Martin Soto
  * @author {@link https://www.inatica.com/ Inatica}
  * @blog {@link https://rafamartin10.blogspot.com/ Blog Rafael Martin Soto}
  * @since October 2021
  * @version 1.0.0
  * @license GNU General Public License v3.0
  *
  * */

 
  require_once __DIR__ . '/img2img/img2img.class.php';
  require_once __DIR__ . '/ext-op-ml-php/ext-op-ml-php.class.php';
 
 class graph
    {
    /**
     * Definition of Defaut Format values
     *
     * @var    array
     * @access private
     *
     **/
    private $default_cfg = [
        'width'     => 6.4, // 6.4 inches
        'height'    => 4.8, // 4.8 inches 
        'dpi'       => 100, // 100 dpis
        'padding'   => .6, // 0.6 inches
        'fontdir'   => __DIR__.'/fonts',
        'fontfamilypath' => 'dejavu-fonts-ttf-2.37/ttf',
        'font'      => 'DejaVuSans.ttf',    
        'fontsize'  => 10.5,   
        'xtickfontsize'  => 10.5,   
        'ytickfontsize'  => 10.5,
        'axes'      => [ 'prop_cycle' => []
            ],
        'lines'     =>
            ['width' => 3],
        'values'     => [],
        'x_values'     => [],
        'y_values'     => [],
        'ylabel'    => '',
        'xlabel'    => '',
        'title'     => '',
        'cycler'    => [ 
            'color' => [ 
                'default' => ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf']
                ],
            'linestyle'  => [ '-', '--', ':', '-.' ]
            ],
        'backgroundstyle'       => 'solid',
        'backgroundcolor'       => '#ffffff',
        'bordertype'            => 'square',
        'paddingleft'           => .79,
        'paddingright'          => .63,
        'paddingtop'            => .58,
        'paddingbottom'         => .515,
        'paddinginsideleft'     => .2,
        'paddinginsideright'    => .2,
        'paddinginsidetop'      => .15,
        'paddinginsidebottom'   => .15,
        'ymarginleftlabel'      => 10,
        'xmarginlabelsticks'    => 16,
        'ymarginlabelsticks'    => 10,
        'xshowlabelticks'       => true,
        'yshowlabelticks'       => true,
        'margintitle'           => 50,
        'x_drawguidelines'      => false,
        'y_drawguidelines'      => false,
		'centerlabels'			=> false,
		'bars'	                => ['percmarginbetwbars' => 20 ],
		'legend'			    => false,
		'legendmarginleft'		=> 7,
        'legendmargintop'		=> 6,
        'legendpaddingleft'		=> 5,
        'legendpaddingtop'		=> 1,
        'legendpaddingright'	=> 5,
        'legendpaddingbottom'	=> 3,
        'legendwidthlines'	    => 28,
        'legendlabelheight'     => 21,
		'width_marker_x'		=> 9,
		'height_marker_x'		=> 9,
		'width_marker_o'		=> 10,
		'height_marker_o'		=> 10,
        'xticks'                => ['rotation' => 0]
		
    ]; // /$default_cfg



    /**
     * Define colors relations
     */
    private $colors_rel = ['b' => '#0000ff', 'g' => '#008000', 'r' => '#ff0000', 'c' => '#00cccc', 'm' => '#cc0000', 'y' => '#cc0000', 'k' => '#000000', 'w' => '#ffffff',
        '#1f77b4' => '#1f77b4', '#ff7f0e' => '#ff7f0e', '#2ca02c' => '#2ca02c', '#d62728' => '#d62728', '#9467bd' => '#9467bd', '#8c564b' => '#8c564b',
        '#e377c2' => '#e377c2', '#7f7f7f' => '#7f7f7f', '#bcbd22' => '#bcbd22', '#17becf' => '#17becf'];



    /**
     * Define markers
     */
    private $markers = ['.png', 'o', 'x', '^', 's', 'd'];
	
	

    /**
     * Define line & bar styles
     */
    private $linestyles = ['bar', '--', '-.', ':', '-'];



    /**
     * Define Background Image GD
     */
    public $bckgr_img_gd = null;



    /**
     * Define math object for ext_op_ml class
     */
    public $math = null;
		


    /**
     * Config
     *
     * @var    array
     * @access protected
     *
     **/
    protected $cfg = [];



    /**
     * GD
     *
     * @var    image
     * @access private
     *
     **/
    protected $gd = null;



    public function __construct( $cfg = null) {
		$this->set_config( ( is_null($cfg) ) ? $this->default_cfg : $cfg );
        $this->init_defaults( );
        $this->math = new ext_op_ml( );
	} // / __construct



    /**
     * Set CONFIG
     * @param array $cfg
     */
    public function set_config( $cfg ){
        $this->cfg = $cfg;
    } // /set_config()
	
	


    /**
     * Set 'backgroundimage' CONFIG
     * @param string $filename
     */
    public function imread( $filename ){
        $this->cfg['backgroundimage'] = $filename;

        $this->bckgr_img_gd = new img2img( $this->cfg['backgroundimage'] );
    } // /imread()



    /**
     * Set 'draw_guidelines' CONFIG
     * @param boolean $show
     */
    public function set_drawguidelines( $show = true ){
        $this->set_x_drawguidelines( $show );
        $this->set_y_drawguidelines( $show );
    } // /set_drawguidelines()



    /**
     * Set 'x_draw_guidelines' CONFIG
     * @param boolean $show
     */
    public function set_x_drawguidelines( $show = true ){
        $this->cfg['x_drawguidelines'] = $show;
    } // /set_x_drawguidelines()



    /**
     * Set 'width' CONFIG
     * @param float $width
     */
    public function width( $width = 6.4 ){
        $this->cfg['width'] = $width;

        // Change paddings automatically
        // 6.4    -> .79
        // $width -> X
        $this->cfg['paddingleft'] = $width * .79 / 6.4;
        $this->cfg['paddingright'] = $width * .63 / 6.4;

        // Change font size automatically
        $ponderation = 6.4 - (6.4 - $width)/2;
        $this->cfg['xtickfontsize'] = $ponderation * 10.5 / 6.4;

        // Change margin labels ticks automatically
        $this->cfg['xmarginlabelsticks'] = $this->cfg['height'] * 16 / 4.8;
        $this->cfg['ymarginlabelsticks'] = $this->cfg['width'] * 10 / 6.4;
        
    } // /width()



    /**
     * Set 'legendwidthlines' CONFIG
     * @param float $legendwidthlines
     */
    public function legendwidthlines( $legendwidthlines = 28 ){
        $this->cfg['legendwidthlines'] = $legendwidthlines;
    } // /legendwidthlines()



    /**
     * Set 'xticks' CONFIG
     * @param array $xticks
     */
    public function xticks( $xticks ){
        if( isset($xticks['rotation']) ){
            $this->cfg['xticks']['rotation'] = $xticks['rotation'];
        }
    } // /xticks()



    /**
     * Set 'legendlabelheight' CONFIG
     * @param float $legendlabelheight
     */
    public function legendlabelheight( $legendlabelheight = 21 ){
        $this->cfg['legendlabelheight'] = $legendlabelheight;
    } // /legendlabelheight()
    


    /**
     * Set 'height' CONFIG
     * @param float $height
     */
    public function height( $height = 4.8 ){
        $this->cfg['height'] = $height;



        // Change paddings automatically
        // 4.8    -> .58
        // $height -> X
        $this->cfg['paddingtop'] = $height * .58 / 4.8;
        $this->cfg['paddingbottom'] = $height * .515 / 4.8;

        // Change font size automatically
        // For the size of horizontal text, we need to check width
        $ponderation = 6.4 - (6.4- $this->cfg['width'])/2;
        $this->cfg['ytickfontsize'] = $ponderation * 10.5 / 6.4;

        // Change margin labels ticks automatically
        $this->cfg['ymarginlabelsticks'] = $this->cfg['width'] * 10 / 6.4;
        $this->cfg['xmarginlabelsticks'] = $this->cfg['height'] * 16 / 4.8;

        // Change title margin automatically
        $this->cfg['margintitle'] = $this->cfg['height'] * 50 / 4.8;
    } // /height()


    
    /**
     * ASSIGN values
     * 
     * @param array $values
     */
    private function set_values( $values ){
        $this->cfg['values'] = $values;

    } // /set_values()



    /**
     * Set 'y_draw_guidelines' CONFIG
     * @param boolean $show
     */
    public function set_y_drawguidelines( $show = true ){
        $this->cfg['y_drawguidelines'] = $show;
    } // /set_y_drawguidelines()



    /**
     * Set 'legend' CONFIG
     * @param boolean $legend
     */
    public function legend( $legend = true ){
        $this->cfg['legend'] = $legend;
    } // /legend()



    /**
     * Set X LABEL
     * @param string $xlabel
     */
    public function xlabel( $xlabel = '' ){
        $this->cfg['xlabel'] = $xlabel;
    } // /xlabel()



    /**
     * Synonym of xlabel()
     * @param string $xlabel
     */
    public function set_xlabel( $xlabel = '' ){
        $this->xlabel( $xlabel );
    } // /set_xlabel()



    /**
     * Synonym of ylabel()
     * @param string $ylabel
     */
    public function set_ylabel( $ylabel = '' ){
        $this->ylabel( $ylabel );
    } // /set_ylabel()



    /**
     * Set Y LABEL
     * @param string $ylabel
     */
    public function ylabel( $ylabel = '' ){
        $this->cfg['ylabel'] = $ylabel;
    } // /ylabel()



    /**
     * Set TITLE
     * @param string $title
     */
    public function title( $title = '' ){
        $this->cfg['title'] = $title;
    } // /title()



    /**
     * Synonym of title()
     * @param string $title
     */
    public function set_title( $title = '' ){
        $this->title( $title );
    } // /set_title()



    /**
     * INIT DEFAULT CONFIGURATIONS
     */
    private function init_defaults( ){
        $this->cfg['axes']['prop_cycle'] = $this->cycler( 'color', 'default' ); // Assign a cycler to axes
    } // /init_defaults()

    

    /**
     * GET cycler
     * 
     * @param string $key
     * @return array $cycler
     */
    public function cycler( $key, $value = '' ){
        switch(strtolower(trim($key))){
            case 'color':   return $this->cycler_color( $value );
                            break;
        }
    } // /cycler()

    

    /**
     * GET cycler Color
     * 
     * @param string $colors
     * @return array $cycler
     */
    public function cycler_color( $colors = '' ){
        if( is_array( $colors ) ){
            $cycler = $this->get_colors_array_assoc( $colors );
        } else {
            // Is string. Need to split and return each rel color
            switch(strtolower(trim($colors))){
                case 'default':
                case 'category10':
                case 'vega':
                case 'd3':          $cycler = $this->cycler_color( $this->default_cfg['cycler']['color']['default'] ); // Return default config cycler colors
                                    break;

                case '':            $cycler = $this->cfg['axes']['prop_cycle']; // Return assigned cycler colors
                                    break;

                default:            $colors_splitted = split( $colors );
                                    $cycler = $this->cycler_color( $colors_splitted ); // Return splitted cycler colors
                                    unset($colors_splitted);
                                    break;
            } // /Switch $colors
        } // /if is array

        return $cycler;
    } // /cycler_color()



    /**
     * GET colors array from abreviations
     * 
     * @param string $colors_abrev
     * @return array $colors
     */
    private function get_colors_array_assoc($colors_abrev){
        $colors = [];
        
        foreach( $colors_abrev as $color){
            $colors[] = $this->colors_rel[ $color ];
        }

        unset( $color );

        return $colors;
    } // /get_colors_array_assoc()



    /**
     * axes takes a list of [xmin, xmax, ymin, ymax] and specifies the viewport of the axes.
     * 
     * 1st Method: Set Max & Min with params [ 'xmin' => $xmin, 'xmax' => $xmax, 'ymin' => $ymin, 'ymax' => $ymax ]
     * 2nd Method: Set Max & Min with array [$xmin, $xmax, $ymin, $ymax]
     * @param array $arr_values_min_max
     */
    public function axes( $arr_values_min_max ){
        if( $this->math->is_assoc($arr_values_min_max) ){
            // Set Max & Min with associative array [ 'xmin' => $xmin, 'xmax' => $xmax, 'ymin' => $ymin, 'ymax' => $ymax ]
            if(  isset($arr_values_min_max['xmin']) && !is_null($arr_values_min_max['xmin']) ){
                $this->cfg['global_force_min_x'] = $arr_values_min_max['xmin'];
            }
            if(  isset($arr_values_min_max['xmax']) && !is_null($arr_values_min_max['xmax']) ){
                $this->cfg['global_force_max_x'] = $arr_values_min_max['xmax'];
            }
            if(  isset($arr_values_min_max['ymin']) && !is_null($arr_values_min_max['ymin']) ){
                $this->cfg['global_force_min_y'] = $arr_values_min_max['ymin'];
            }
            if(  isset($arr_values_min_max['ymax']) && !is_null($arr_values_min_max['ymax']) ){
                $this->cfg['global_force_max_y'] = $arr_values_min_max['ymax'];
            }
        } else {
            // Set Max & Min with array [$xmin, $xmax, $ymin, $ymax]
            if(  isset($arr_values_min_max[0]) && !is_null($arr_values_min_max[0]) ){
                $this->cfg['global_force_min_x'] = $arr_values_min_max[0];
            }
            if(  isset($arr_values_min_max[1]) && !is_null($arr_values_min_max[1]) ){
                $this->cfg['global_force_max_x'] = $arr_values_min_max[1];
            }
            if(  isset($arr_values_min_max[02]) && !is_null($arr_values_min_max[2]) ){
                $this->cfg['global_force_min_y'] = $arr_values_min_max[2];
            }
            if(  isset($arr_values_min_max[3]) && !is_null($arr_values_min_max[3]) ){
                $this->cfg['global_force_max_y'] = $arr_values_min_max[3];
            }
        }
    }// /axes()



    /**
     * PLOT sub method to check if begin with 0
     * 
     * @param array $cfg // ['y_begin_with_zero' => true] to draw y values begin with value 0
     * @return boolean $y_begin_with_zero
     */
    public function plot_y_begin_with_zero( $cfg = null ){
        $y_begin_with_zero = false;
		
		if( !is_null($cfg) ){
            if( isset($cfg['y_begin_with_zero']) && $cfg['y_begin_with_zero'] ){
                $y_begin_with_zero = true;
            }
        }

        return $y_begin_with_zero;
    } // /plot_y_begin_with_zero()



    /**
     * PLOT sub method to get plot type
     * 
     * @param array $cfg  // ['type' => '-' || '--' 'bar'
     * @return string $type
     */
    public function plot_type( $cfg = null ){
        $type = '-';
		
		if( !is_null($cfg) ){
            if( isset($cfg['type']) ){
                if( strpos($cfg['type'], 'bar') !== false ){
                    $type = 'bar';
                } else 
                if( strpos($cfg['type'], 'scatter') !== false ){
                    $type = 'scatter';
                } else if( strpos($cfg['type'], '--') !== false ){
                    $type = '--';
                } else if( strpos($cfg['type'], '-') !== false ){
                    $type = '-';
                } 
            }
        }

        return $type;
    } // /plot_type()



    /**
     * PLOT sub method to get plot color
     * 
     * @param array $cfg  // ['color' => ...
     * @return string $color
     */
    public function plot_next_color( $cfg = null ){
        $arr_color_cycler = $this->cycler( 'color' );
        $countval = count($this->cfg['values']);
        
        $color_id = $countval % count($this->cycler( 'color', 'default' ));
		
		$color = $arr_color_cycler[ $color_id ];

        unset( $arr_color_cycler );
        unset( $countval );
        unset( $color_id );

        return $color;
    } // /plot_next_color()


    
    /**
     * RECALCULATES MAX & MIN of all values
     */
    private function recalc_max_min( ){
        $values =$this->cfg['values'][0];

        $global_max_x   = max( $values['values_x'] );
        $global_min_x   = min( $values['values_x'] );
        $global_max_y   = max( $values['values_y'] );
        $global_min_y   = min( $values['values_y'] );

        foreach( $this->cfg['values'] as $key => $value ){
            if( $key == 0) continue;

            $values =$this->cfg['values'][$key];

            if( $global_max_x < max( $values['values_x'] ) ){
                $global_max_x = max( $values['values_x'] );
            }
            
            if( $global_min_x > min( $values['values_x'] ) ){
                $global_min_x = min( $values['values_x'] );
            }

            if( $global_max_y < max( $values['values_y'] ) ){
                $global_max_y = max( $values['values_y'] );
            }

            if( $global_min_y > min( $values['values_y'] ) ){
                $global_min_y = min( $values['values_y'] ) ;
            }
        } // /foreach $this->cfg['values']

        $global_diff_x = $global_max_x - $global_min_x;
        $global_diff_y = $global_max_y - $global_min_y;

        $this->cfg['global_max_x']        = $global_max_x;
        $this->cfg['global_min_x']        = $global_min_x;
        $this->cfg['global_max_y']        = $global_max_y;
        $this->cfg['global_min_y']        = $global_min_y;
        $this->cfg['global_diff_x']       = $global_diff_x;
        $this->cfg['global_diff_y']       = $global_diff_y;
        $this->cfg['global_count_x']      = count( $values['values_x'] );
        $this->cfg['global_count_y']      = count( $values['values_y'] );

        unset( $values );

        unset( $global_diff_x );
        unset( $global_diff_y );
        unset( $global_max_x );
        unset( $global_min_x );
        unset( $global_max_y );
        unset( $global_min_y );
        unset( $key );
        unset( $value );
        unset( $values );
    }// /recalc_max_min()



    /**
     * PLOT. Add serie of values to graph
     * 
     * @param array $arr_values
     * @param array $arr_values_y_param
     * @param array $cfg // ['type' => '-' || '--' || 'o' | 'x' || '^' || 's']
     */
    public function plot( $arr_values, $arr_values_y_param = null, $cfg = null ){
		if( is_array($arr_values[0]) ){
			// Call plot() recursively
			foreach( $arr_values as $value){
				$param1 = $value[0];
				$param2 = ( isset( $value[1] )?$value[1]:null );
				$param3 = ( isset( $value[2] )?$value[2]:null );
				$this->plot( $param1, $param2, $param3 );
			}

            unset( $param1 );
            unset( $param2 );
            unset( $param3 );
            unset( $value );
		  return;
		}
		
        $y_begin_with_zero = $this->plot_y_begin_with_zero( $cfg );
        $type = $this->plot_type( $cfg );
        $color = $this->plot_next_color( $cfg );
        $values_are_keys = is_null($arr_values_y_param);
		
		$label = '';
		if( !is_null( $cfg ) && isset($cfg['label']) ){
			$label = $cfg['label'];
		}
		
		$marker = $markerfilename = '';
		if( !is_null( $cfg ) && isset($cfg['marker']) ){
			$marker = strtolower( trim( $cfg['marker'] ) );
			
			if( strpos( $marker, '.png' ) !== false ){
				$markerfilename = $marker;
				$marker = '.png';
			}
		}
		
		if( !is_null( $cfg ) && !is_array( $cfg ) && is_string( $cfg ) ){
			// Config param is string. Extract config parts
			
			// search for markers as 'o', 'x', '^', 's', 'd'
			$cfg = strtolower( trim( $cfg ) );
			foreach( $this->markers as $mark ){
				if( strpos( $cfg, $mark ) !== false ){
					$marker = $mark;
				}
			}
            unset( $mark );
			
			// Search for colors
			foreach( $this->colors_rel as $key => $col_rel ){
				if( strpos( $cfg, $key ) !== false ){
					$color = $col_rel;
				}
			}

            unset( $col_rel );
            unset( $key );
			
			// search for styles as '--', '-', 'bar'
			// Needed in config str. If not given, will not drawed line
			$type = '';
			foreach( $this->linestyles as $style ){
				if( strpos( $cfg, $style ) !== false ){
					$type = $style;
					break;
				}
			}
            unset( $style );
		}

		if( $values_are_keys ) {
            $x_values_return = [];
            for($i=0;$i<count($arr_values);$i++){
                $x_values_return[] = $i;
            }
            $arr_values_x = $x_values_return;

            unset( $x_values_return );
		} else {
			array_multisort( $arr_values, $arr_values_y_param);
        	$arr_values_x = $arr_values;
		}

		if( $values_are_keys ){
			$arr_values_y = $arr_values;
		} else {
        	$arr_values_y = $arr_values_y_param;
		}
        
        
        $max_x      = max( $arr_values_x );
        $max_y      = max( $arr_values_y );
        $min_x      = min( $arr_values_x );
        $min_y      = min( $arr_values_y );
        $count_x    = count( $arr_values_x );
        $count_y    = count( $arr_values_y );
        $diff_x     = ( $max_x - $min_x );
        $diff_y     = ( $max_y - $min_y );


        $this->cfg['values'][] = [ 'type' => $type, 'color'=>$color, 'values_x' => $arr_values_x, 'values_y' => $arr_values_y, 'max_x' => $max_x, 'min_x' => $min_x, 'max_y' => $max_y, 'min_y' => $min_y,
                                    'count_x' => $count_x, 'count_y' => $count_y, 'diff_x' => $diff_x, 'diff_y' => $diff_y, 'values_are_keys' => $values_are_keys, 'label' => $label,
									'marker' => $marker, 'markerfilename' => $markerfilename ];

        unset( $y_begin_with_zero );
        unset( $type );
        unset( $color );
        unset( $values_are_keys );
        unset( $label );
        unset( $marker );
        unset( $max_x );
        unset( $max_y );
        unset( $min_x );
        unset( $min_y );
        unset( $count_x );
        unset( $count_y );
        unset( $diff_x );
        unset( $diff_y );
        unset( $arr_values_x );
        unset( $arr_values_y );
        unset( $i );
    } // /plot()



    /**
     * BAR GRAPH PLOT. generate graph
     * 
     * @param array $arr_values
     * @param array $arr_values_y_param
     * @param array $cfg // ['type' => '-' || '--' || 'o' || '^' || 's' || 'd']
     */
    public function bar( $arr_values, $arr_values_y_param = null, $cfg = null ){
        if( is_null($cfg) ){
            $cfg = [];
        }

        $cfg['type'] = 'bar';

        $this->plot( $arr_values, $arr_values_y_param, $cfg );
    } // /bar()



    /**
     * SCATTER GRAPH PLOT. generate graph
     * 
     * $arr_values have all series of values as:
     * [
     *  [ [x0, x1, x2, x3], [y0, y1, y2, y3], $cfg ], // first serie. $cfg can be null
     *  [ [x0, x1, x2, x3], [y0, y1, y2, y3], $cfg ] // second serie. $cfg can be null
     *  ..... // n series. $cfg can be null
     * ]
     * 
     * @param array $arr_values
     * @param array $cfg // ['type' => '-' || '--' || 'o' || '^' || 's' || 'd']
     */
    public function scatter( $arr_values ){
        foreach( $arr_values as $arr_values_serie){

            if( !isset( $arr_values_serie[2] ) || (isset( $arr_values_serie[2] ) && is_null($arr_values_serie[2])) ){
                $cfg = [];
            } else {
                $cfg = $arr_values_serie[2];
            }

            $cfg['type']    = 'scatter';
            $cfg['marker']  = 'o';

            $this->plot( $arr_values_serie[0], $arr_values_serie[1], $cfg );
        }
    } // /scatter()



    /**
     * HISTOGRAM GRAPH PLOT. generate graph
     * 
     * $cfg['num_blocks] = blocks to divide hist. Default = 10
     * 
     * @param array $arr_values
     */
    public function hist( $arr_values, $cfg = null ){
        if( is_null($cfg) ){
            $cfg = [];
        }

        $num_blocks = (( isset($cfg['num_blocks']) )?$cfg['num_blocks']:10);

        $min = min($arr_values);
        $max = max($arr_values);

        $diff = $max - $min;

        $arr_hist = array_fill(0, $num_blocks, 0); // Fill count values to 0

        $div = ( ( $num_blocks - 1 ) / $diff );

        foreach( $arr_values as $value){
            //    $diff           -> ( $num_blocks - 1 )
            //    ($value - $min) -> X
            
            $block_index = (int)round( ($value - $min) * $div ); //$block_index = ( ($value - $min) * ( $num_blocks - 1 ) / $diff );
            ++$arr_hist[$block_index];
        }

        $cfg['type'] = 'bar';

        $this->plot( $this->math->linspace($min, $max, $num_blocks), $arr_hist, $cfg );

        $this->axes([null, null, 0, max($arr_hist) ]);

        unset( $arr_hist );
        unset( $min );
        unset( $max );
        unset( $diff );
        unset( $value );
        unset( $num_blocks );
        unset( $div );
        unset( $block_index );
    } // /hist()
    


    /**
     * Show Legend
     */
    public function generate_gd_legend( ){

        $this->set_labels_if_empty();

        $left = $this->cfg['pix_paddingleft'] + 1 + $this->cfg['legendmarginleft'];
        $top = $this->cfg['pix_paddingtop'] + 1 + $this->cfg['legendmargintop'];

        $width = $this->cfg['legendpaddingleft'] + $this->cfg['legendpaddingright'];
        $width +=  $this->cfg['legendwidthlines'] + 12; // 12 = margin between lines and text

        // Calculates max length of labels
        $font_path  = $this->cfg['fontdir']. '/' . $this->cfg['fontfamilypath']. '/' . $this->cfg['font'];
        $font_size  = $this->cfg['fontsize'];
        $arrlabels = [];
        foreach( $this->cfg['values'] as $val ){
            $arrlabels[] = $val['label'];
        }
        $max_length = $this->math->arr_max_len_ttf( $arrlabels, $font_path, $font_size );

        $width += $max_length;

        $height = $this->cfg['legendpaddingtop'] + $this->cfg['legendpaddingbottom'];
        $height +=  $this->cfg['legendlabelheight'] * count( $this->cfg['values'] );

        // White Transp
        $white_transp = imagecolorallocatealpha($this->gd, 255, 255, 255, 25);
        imagefilledrectangle( $this->gd, $left, $top, $left + $width, $top + $height, $white_transp) ;

		$color = imagecolorallocate( $this->gd, 214, 214, 214); // gray
        $this->generate_gd_legend_round_border( $left, $top, $width, $height, $color );

		$color = imagecolorallocate( $this->gd, 247, 247, 247); // light gray
        $this->generate_gd_legend_round_border( $left-1, $top-1, $width+2, $height+2, $color );
        $this->generate_gd_legend_round_border( $left+1, $top+1, $width-2, $height-2, $color );

        foreach( $this->cfg['values'] as $key => $values){
            $this->generate_gd_legend_line( $left, $top, $key, $this->cfg['legendlabelheight'] );
        }

        foreach( $this->cfg['values'] as $key => $values){
            $this->gd_draw_text_legend( $left, $top, $key, $this->cfg['legendlabelheight'] );
        }

        unset( $left );
        unset( $top );
        unset( $width );
        unset( $height );
        unset( $max_length );
        unset( $key );
        unset( $values );
        unset( $color );
        unset( $white_transp );
        unset( $length_value );
        unset( $font_path );
        unset( $font_size );
        unset( $val );
        unset( $arrlabels );
    }// /generate_gd_legend()



    /**
     * Set labels to init texts if they are empty
     */
    private function set_labels_if_empty( ){
        foreach( $this->cfg['values'] as $key => $values){
            if( !isset( $values['label'] ) || isset( $values['label'] ) && $values['label'] == '' ){
                $this->cfg['values'][$key]['label'] = 'legend ['.$key.']';
            }
        }
    } // /set_labels_if_empty()


    
    /** 
     * Draw the legend
     * 
     * @param integer $left
     * @param integer $top
     * @param integer $key
     * @param integer $labelheight
     */
    private function gd_draw_text_legend( $left, $top, $key, $labelheight ){
           $angle = 0;
           $font_path = $this->cfg['fontdir']. '/' . $this->cfg['fontfamilypath']. '/' . $this->cfg['font'];
           $text_color = imagecolorallocate( $this->gd, 0, 0, 0); // Black

           $left += $this->cfg['legendpaddingleft'] + $this->cfg['legendwidthlines'] + 12;
           $top += $this->cfg['legendpaddingtop'] + $labelheight * $key + ($labelheight/1.4);
           
           imagettftext($this->gd,  $this->cfg['fontsize'], $angle, $left, $top, $text_color, $font_path, $this->cfg['values'][$key]['label'] );

           unset( $angle );
           unset( $font_path );
           unset( $text_color );
           unset( $left );
           unset( $top );
    } // /gd_draw_text_legend()



    /**
     * Show rectanle with round corners
     * 
     * Draw a rectangle with rounded corners.
     * from https://gist.github.com/mistic100/9301c0eebaef047bfdc8
     * 
     * @param integer $left
     * @param integer $top
     * @param integer $width
     * @param integer $height
	 * @param object $color
     */
    public function generate_gd_legend_round_border( $left, $top, $width, $height, $color ){
        $r = 1;
        $x1 = $left;
        $x2 = ( $left + $width );
        $y1 = $top;
        $y2 = ( $top + $height );

        $img = &$this->gd;
        
        $r = min($r, floor(min(($x2-$x1)/2, ($y2-$y1)/2)));
    
        // top border
        imageline($img, $x1+$r, $y1, $x2-$r, $y1, $color);
        // right border
        imageline($img, $x2, $y1+$r, $x2, $y2-$r, $color);
        // bottom border
        imageline($img, $x1+$r, $y2, $x2-$r, $y2, $color);
        // left border
        imageline($img, $x1, $y1+$r, $x1, $y2-$r, $color);
        
        // top-left arc
        imagearc($img, $x1+$r, $y1+$r, $r*2, $r*2, 180, 270, $color);
        // top-right arc
        imagearc($img, $x2-$r, $y1+$r, $r*2, $r*2, 270, 0, $color);
        // bottom-right arc
        imagearc($img, $x2-$r, $y2-$r, $r*2, $r*2, 0, 90, $color);
        // bottom-left arc
        imagearc($img, $x1+$r, $y2-$r, $r*2, $r*2, 90, 180, $color);

        unset( $r );
        unset( $x1 );
        unset( $x2 );
        unset( $y1 );
        unset( $y2 );
        unset( $img );
    }// /generate_gd_legend_round_border()

    

    /**
     * Show line Legend
     * 
     * @param integer $left
     * @param integer $top
     * @param integer $key
     * @param integer $labelheight
     */
    public function generate_gd_legend_line( $left, $top, $key, $labelheight ){
        $left += $this->cfg['legendpaddingleft'];
        $top += $this->cfg['legendpaddingtop'] + $labelheight * $key + ( $labelheight / 2 );

        $right = $left + $this->cfg['legendwidthlines'];

        $line_color_rgb = $this->math->hex2rgb( $this->cfg['values'][$key]['color'] );
        $line_color = imagecolorallocate( $this->gd, $line_color_rgb[0], $line_color_rgb[1], $line_color_rgb[2]);

        imagesetthickness($this->gd, 2);
		imageline($this->gd, $left, $top, $right, $top, $line_color );

         // marker
         $this->gd_marker(  $this->cfg['values'][$key]['marker'], $left + ( $right - $left ) / 2, $top - 1, $line_color, $this->cfg['values'][$key]['markerfilename'] );

        unset( $right );
        unset( $line_color_rgb );
        unset( $line_color );
    }// /generate_gd_legend_line()

    

    /**
     * Show Graph
     * 
     * @param array $cfg
     */
    public function show( $cfg = null ){
        $this->draw_to_output( $cfg );
    } // /show()



    /**
     * Draw to desired output
     * 
     * @param array $cfg
     */
    public function draw_to_output( $cfg ){
		if( is_null($this->gd) ){
			$this->generate_gd_work_space( ); // ['y_drawguidelines' => false] With bar graphs don't want y guidelines
		}

        // First draw all Bars
        foreach( $this->cfg['values'] as $key => $value){
            if( $value['type'] == 'bar'){
                $this->generate_gd_bar_graph( $key );
            }
        }

        // Second draw all lines
        foreach( $this->cfg['values'] as $key => $value){
            if( $value['type'] != 'bar'){
                $this->generate_gd_line_graph( $key );
            }
        }

        // Third draw legend
		if( $this->cfg['legend'] ){
			$this->generate_gd_legend( );
		}

        // Fourth show in format
        if(isset( $cfg['filename']) ){
            // write to file
            if( !isset($cfg['filename']) ){
                echo 'Missing (filename) in config. Exiting';
                exit(1);
            }
            $this->write_gd_file( $cfg['filename'] );
        } else if( isset( $cfg['format']) ){
            switch( $cfg['format'] ){
                case 'png':         // get raw png
                                    $this->output_gd_png_raw( );
                                    break;

                case 'png_base64':  // get base64 png. Used directly in html documents as: echo '<img src="'.$graph->plot( [1,2], [3,4], ['output'=>'png_base64'] ).'" />';
                                    $this->output_gd_png_base64( );
                                    break;

                default:            echo 'Unrecognized output ('.$cfg['output'].'). Exiting';
                                    exit(1);
            }
        }
    }// /draw_to_output()



    /**
     * ASSIGN X values
     * 
     * @param array $x_values
     * @param boolean $values_are_keys
     */
    private function set_x_values( $x_values, $values_are_keys = false ){
        $this->cfg['x_values'] = [];
        $min_labels = ((count($x_values)<7)?7:count($x_values));
        $step_values = (max($x_values) - min($x_values)) / ($min_labels-1);
        $min_value =  (($values_are_keys)?0:min($x_values));

        $step = (($values_are_keys)?(count($x_values))/($min_labels+1):max($x_values)/$min_labels);
        $step = (count($x_values))/($min_labels+1);

        for($i=0;$i<$min_labels;$i++){
            $this->cfg['x_values'][] = (($values_are_keys)?($i*$step)+$min_value:$min_value+($i*$step_values));
        }
		
		$this->cfg['x_values'] = $this->arr_2_less_decimals( $this->cfg['x_values'] );

        unset( $min_labels );
        unset( $step_values );
        unset( $min_value );
        unset( $step );
        unset( $i );
    } // /set_x_values()



    /**
     * Transform X values
     * 
     * @param array $x_values
     * @param boolean $values_are_keys
     * @return array $x_values_return
     */
    private function transform_x_values( $x_values, $values_are_keys = false ){
        $x_values_return = [];

        $min_labels     = ((count($x_values)<7)?7:count($x_values));
        $step_values    = (max($x_values) - min($x_values)) / ($min_labels-1);
        $min_value      = (($values_are_keys)?0:min($x_values));
        $step           = (($values_are_keys)?(count($x_values))/($min_labels+1):max($x_values)/$min_labels);
        $step           = (count($x_values))/($min_labels+1);

        for($i=0;$i<$min_labels;$i++){
            $x_values_return[] = (($values_are_keys)?($i*$step)+$min_value:$min_value+($i*$step_values));
        }

        unset( $min_labels );
        unset( $step_values );
        unset( $min_value );
        unset( $step );
        unset( $i );
		
		return $this->arr_2_less_decimals( $x_values_return );
    }
	


    /**
     * return a png stream of graph base64
     * 
     * @param array $cfg
     * @return string $png_stream
     */
	public function output_gd_png_base64( $cfg = null){
        
        $this->draw_to_output( $cfg );

		return 'data:image/png;base64,' . base64_encode( $this->output_gd_png_raw( ) );
	} // /output_gd_png_base64()
	
	

    /**
     * return a png stream of graph raw
     * 
     * @return string $png_stream
     */
	public function output_gd_png_raw( ){
		$filename = '/tmp/graph-php.class.png.'.time().'.tmp';
		
		imagepng( $this->gd, $filename );
		
		$fp = fopen($filename, "rb");
		$content = fread($fp, filesize($filename));
		fclose($fp);
		
		unlink( $filename );
        
        unset( $fp );
        unset( $filename );
		
		return $content;
	} // /output_gd_png_raw()



    /**
     * TRANSFORM Y values
     * 
     * @param array $y_values
     * @return array $y_values_return
     */
    private function transform_y_values( $y_values ){
        $y_values_return = [];

        $max = max( $y_values );
        $min = min( $y_values );
        $num_ticks = 7;
        $step = ($max-$min) / ($num_ticks -1);
        for($i=0;$i<$num_ticks;$i++){
            $y_values_return[] = $max - ($step * $i);
        }

        unset( $i );
        unset( $max );
        unset( $min );
        unset( $num_ticks );
        unset( $step );
		
		return $this->arr_2_less_decimals( $y_values_return );
    } // /transform_y_values()



    /**
     * ASSIGN Y values
     * 
     * @param array $y_values
     */
    private function set_y_values( $y_values ){
        $this->cfg['y_values'] = [];

        $max = max( $y_values );
        $min = min( $y_values );
        $num_ticks = 7;
        $step = ($max-$min) / ($num_ticks -1);
        for($i=0;$i<$num_ticks;$i++){
            $this->cfg['y_values'][] = $max - ($step * $i);
        }
		
		$this->cfg['y_values'] = $this->arr_2_less_decimals( $this->cfg['y_values'] );

        unset( $i );
        unset( $max );
        unset( $min );
        unset( $num_ticks );
        unset( $step );
    } // /set_y_values()



    /**
     * REDUCE decimals in array values if needed for visualize better data values
     * 
     * @param array $values
     * @return array $arr_values_less_decimals
     */
    private function arr_2_less_decimals( $values ){
		$max = max( $values );
		$min = min( $values );
		$arr_values_less_decimals = [];
		
		if( $max >=10 ){
			if( ($max-$min) < 10 ){
				$cut_decimals = 2;
			} else {
				$cut_decimals = 0;
			}
		} else if( $max >=1 ){
            $cut_decimals = 1;
        } else {
			$cut_decimals = 2;
		}
		
		// Search if there is one decimal at least
		$there_are_decimals = false;
		
		foreach($values as $value){
			if( is_float($value)){
				$there_are_decimals = true;
				break;
			}
		}
		
		if( $there_are_decimals ){
			// Cut to X decimals
			foreach($values as $value){
				$arr_values_less_decimals[] = number_format($value, $cut_decimals, '.', '');
			}
		} else {
			$arr_values_less_decimals = $values;
		}

        unset( $min );
        unset( $max );
        unset( $cut_decimals );
        unset( $there_are_decimals );
        unset( $value );
		
	 	return $arr_values_less_decimals;
	}// /arr_2_less_decimals()



    /**
     * Generate Graph Lines
     * 
     * @param $id_serie
     */
    private function generate_gd_line_graph( $id_serie = 0 ){
		
        $values = $this->cfg['values'][$id_serie];

		// Maths axis X
		$global_min_x = ( isset($this->cfg['global_force_min_x'])?$this->cfg['global_force_min_x']:$this->cfg['global_min_x']);
        $global_max_x = ( isset($this->cfg['global_force_max_x'])?$this->cfg['global_force_max_x']:$this->cfg['global_max_x']);
		
        $arr_short_values_x = $this->long_2_short_arrays( $this->arr_2_less_decimals($values['values_x']) );
        $count_short_values_x = count( $arr_short_values_x );
        $pixels_available_x = $this->pixels_available_x();
		if( isset($this->cfg['global_inside_margin_x_axis']) ){		
		 	$pixels_available_x -= $this->cfg['global_inside_margin_x_axis'] * 2;
		}
        $pixels_size_step_x   = $pixels_available_x / ($count_short_values_x - 1);
		
		// Maths axis Y
        $global_min_y = ( isset($this->cfg['global_force_min_y'])?$this->cfg['global_force_min_y']:$this->cfg['global_min_y']);
        $global_max_y = ( isset($this->cfg['global_force_max_y'])?$this->cfg['global_force_max_y']:$this->cfg['global_max_y']);
		
        $arr_short_values_y = $this->long_2_short_arrays(  $this->arr_2_less_decimals([$global_min_y, $global_max_y ]) );
        $count_short_values_y = count( $arr_short_values_y );
        $pixels_available_y = $this->cfg['pix_height'] - $this->cfg['pix_paddingtop'] - 1 - $this->cfg['pix_paddinginsidetop'] - $this->cfg['pix_paddingbottom'] - 1 - $this->cfg['pix_paddinginsidebottom'];
		
		$line_color_rgb = $this->math->hex2rgb( $values['color'] );
        $line_color = imagecolorallocate( $this->gd, $line_color_rgb[0], $line_color_rgb[1], $line_color_rgb[2]);
		
		$style_dashed = Array(
                $line_color, 
                $line_color, 
                $line_color, 
                $line_color, 
                IMG_COLOR_TRANSPARENT, 
                IMG_COLOR_TRANSPARENT, 
                IMG_COLOR_TRANSPARENT, 
                IMG_COLOR_TRANSPARENT
                );
				
		imagesetstyle($this->gd, $style_dashed);

        $max_top    = $this->cfg['pix_paddingtop'] + 1 + $this->cfg['pix_paddinginsidetop'];
        $min_bottom = $this->cfg['pix_height'] - 1 - $this->cfg['pix_paddingbottom'] - 1 - $this->cfg['pix_paddinginsidebottom'];
        $left_begin = $this->cfg['pix_paddingleft'] + 1 + $this->cfg['pix_paddinginsideleft'];
		
		if( isset($this->cfg['global_inside_margin_x_axis']) ){		
		 	$left_begin += $this->cfg['global_inside_margin_x_axis'];
		}

        for( $i = 1; $i < $count_short_values_x; $i++ ){
			$previous_value_x = $values['values_x'][$i-1];
			$previous_value_y = $values['values_y'][$i-1];
			$diff_x = ($global_max_x-$global_min_x);
			if( $diff_x == 0 ){
				// Cannot divide by 0
				$diff_x = 1;
			}
			$diff_y = ($global_max_y-$global_min_y);
			if( $diff_y == 0 ){
				// Cannot divide by 0
				$diff_y = 1;
			}
            $left = (int)($left_begin + ($previous_value_x-$global_min_x) * $pixels_available_x / $diff_x);
            $top = (int)($min_bottom - ($previous_value_y-$global_min_y) * $pixels_available_y / $diff_y);
			
            $right = (int)($left_begin + ($values['values_x'][$i]-$global_min_x) * $pixels_available_x / $diff_x);
            $bottom = (int)($min_bottom - ($values['values_y'][$i]-$global_min_y) * $pixels_available_y / $diff_y);

			if( in_array($values['type'], [ '-', '--' ] ) ){
				imagesetthickness($this->gd, 1);
				imagefilledellipse ( $this->gd , $right, $bottom, $this->cfg['lines']['width'], $this->cfg['lines']['width'], $line_color); // Draw end of line rounded
				
				if( $values['type'] == '--' ){
					$this->imagepatternedline($this->gd, $left, $top, $right, $bottom, $line_color, $this->cfg['lines']['width'], '1111110000');
				} else {
					imagesetthickness($this->gd, $this->cfg['lines']['width']);
					imageline($this->gd, $left, $top, $right, $bottom, $line_color );
				}
			}

            // marker
            $this->gd_marker(  $values['marker'], $left, $top, $line_color, $values['markerfilename'] );
        }
		
		// At the end we need to draw the marker at right bottom last line
		// marker
        $this->gd_marker( $values['marker'], $right, $bottom, $line_color, $values['markerfilename'] );		
		
		imagesetthickness($this->gd, 1); // Set to default pixel width

        unset( $value );
        unset( $line_color );
        unset( $i );
        unset( $count_short_values_x );
        unset( $previous_value_x );
        unset( $previous_value_y );
        unset( $diff_x );
        unset( $diff_y );
        unset( $left );
        unset( $top );
        unset( $right );
        unset( $bottom );
        unset( $left_begin );
        unset( $min_bottom );
        unset( $max_top );
        unset( $style_dashed );
        unset( $line_color_rgb );
        unset( $pixels_available_y );
        unset( $count_short_values_y );
        unset( $arr_short_values_y );
        unset( $global_max_y );
        unset( $global_min_y );
        unset( $values );
    } // /generate_gd_line_graph()    



    /**
     * Draw Marker
     * 
     * @param string $marker
     * @param string $left
     * @param string $top
     * @param string $line_color
     * @param integer|string $key // for png files
     */
    public function gd_marker( $marker, $left, $top, $line_color, $key ){
        // marker
        switch( $marker ){
            case 'x':	$this->gd_marker_x( $left, $top, $line_color );
                        break;
            case 'o':	$this->gd_marker_o( $left, $top, $line_color );
                        break;
            case '^':	$this->gd_marker_triangle( $left, $top, $line_color );
                        break;
            case 's':	$this->gd_marker_rectangle( $left, $top, $line_color );
                        break;
            case 'd':	$this->gd_marker_diamond( $left, $top, $line_color );
                        break;
            case '.png':	$markerfilename = ((is_integer($key))?$this->cfg['values'][$key]['markerfilename']:$key);
                            $this->gd_marker_png( $left, $top, $markerfilename );
                            unset( $markerfilename );
                            break;
        }
    } // /gd_marker()
	
	

	/**
	* imagepatternedline() function
	* 
	* thanks to: https://www.php.net/manual/es/function.imagedashedline.php#99437
	* 
	*  Routine was developed to draw any kind of straight line with thickness. Routine uses imageline() function to draw line.
	*  Parameters are (similar to imageline() function):
	*    $image: (resource) imagefile
	*    $xstart, $ystart: (int) x,y coordinates for first point
	*    $xend, $yend: (int) x,y coordinates for last point
	*    $color: (int) color identifier that created with imagecolorallocate()
	*  extra parameters:
	*    $thickness: (int) thickness of line in pixel
	*    $pattern: (string) pattern of line, which repeats continuously while line is being drawed.
	*    If there is '1' in the pattern that means the actual dot of line is visible,
	*    '0' means dot is not visible (space between two line elements).
	*    All characters regard for one pixel. Default: 1 dot wide dashed line with 4-4 dots and spaces.
	*  Examples for pattern:
	*  "1" or "" continuous line
	*  "10" close dotline
	*  "10000" dotline
	*  "111111110000001100000011111111" dotline for design drawing
	*  "111111111100000011000000110000001111111111" double dotline
	*  some examples for using imagepatternedline():
	*  imagepatternedline($image,300,300,442,442,$color,200,""); // a square with 200 length of edge and rotated 45 degrees
	*  imagepatternedline($image,100,200,289,200,$color,100,
	*   "11001100000011001111000011001111110000001100001100"
	*  ."00001111001100111100000011000000110000110011001100"
	*  ."11000011111100111111000011001111001111000011110000"
	*  ."1111001111110011000011000000001100110011"); // barcode
	*/
	
	private function imagepatternedline($image, $xstart, $ystart, $xend, $yend, $color, $thickness=1, $pattern="11000011") {
	   $pattern=(!strlen($pattern)) ? "1" : $pattern;
	   $x=$xend-$xstart;
	   $y=$yend-$ystart;
	   $length=floor(sqrt(pow(($x),2)+pow(($y),2)));
	   $fullpattern=$pattern;
	   while (strlen($fullpattern)<$length) $fullpattern.=$pattern;
	   if (!$length) {
		  if ($fullpattern[0]) imagefilledellipse($image, $xstart, $ystart, $thickness, $thickness, $color);
		  return;
	   }
	   $x1=$xstart;
	   $y1=$ystart;
	   $x2=$x1;
	   $y2=$y1;
	   $mx=$x/$length;
	   $my=$y/$length;
	   $line="";
	   for($i=0;$i<$length;$i++){
		  if (strlen($line)==0 or $fullpattern[$i]==$line[0]) {
			 $line.=$fullpattern[$i];
		  }else{
			 $x2+=strlen($line)*$mx;
			 $y2+=strlen($line)*$my;
			 if ($line[0]) imageline($image, round($x1), round($y1), round($x2-$mx), round($y2-$my), $color);
			 $k=1;
			 for($j=0;$j<$thickness-1;$j++) {
				$k1=-(($k-0.5)*$my)*(floor($j*0.5)+1)*2;
				$k2= (($k-0.5)*$mx)*(floor($j*0.5)+1)*2;
				$k=1-$k;
				if ($line[0]) {
				   imageline($image, round($x1)+$k1, round($y1)+$k2, round($x2-$mx)+$k1, round($y2-$my)+$k2, $color);
				   if ($y) imageline($image, round($x1)+$k1+1, round($y1)+$k2, round($x2-$mx)+$k1+1, round($y2-$my)+$k2, $color);
				   if ($x) imageline($image, round($x1)+$k1, round($y1)+$k2+1, round($x2-$mx)+$k1, round($y2-$my)+$k2+1, $color);
				}
			 }
			 $x1=$x2;
			 $y1=$y2;
			 $line=$fullpattern[$i];
		  }
	   }
	   $x2+=strlen($line)*$mx;
	   $y2+=strlen($line)*$my;
	   if ($line[0]) imageline($image, round($x1), round($y1), round($xend), round($yend), $color);
	   $k=1;
	   for($j=0;$j<$thickness-1;$j++) {
		  $k1=-(($k-0.5)*$my)*(floor($j*0.5)+1)*2;
		  $k2= (($k-0.5)*$mx)*(floor($j*0.5)+1)*2;
		  $k=1-$k;
		  if ($line[0]) {
			 imageline($image, round($x1)+$k1, round($y1)+$k2, round($xend)+$k1, round($yend)+$k2, $color);
			 if ($y) imageline($image, round($x1)+$k1+1, round($y1)+$k2, round($xend)+$k1+1, round($yend)+$k2, $color);
			 if ($x) imageline($image, round($x1)+$k1, round($y1)+$k2+1, round($xend)+$k1, round($yend)+$k2+1, $color);
		  }
	   }

       unset( $x );
       unset( $y );
       unset( $x1 );
       unset( $y1 );
       unset( $x2 );
       unset( $y2 );
       unset( $k );
       unset( $k1 );
       unset( $k2 );
       unset( $mx );
       unset( $my );
       unset( $j );
       unset( $i );
       unset( $line );
       unset( $length );
       unset( $fullpattern );
	} // /imagepatternedline()



    /**
    * draw marker PNG
    * NOTE: Only PNG-8. Dont work with PNG-24
    *
    * @param int $left
    * @param int $top
    * @param object $filename
    */
    private function gd_marker_png( $left, $top, $filename ){
        $img = imagecreatefrompng($filename);
        $sx = imagesx($img);
        $sy = imagesy($img);
        
        $half_width = ( $sx / 2 );
        $half_height = ( $sy / 2 );
        
        imagesavealpha($this->gd, true);
        
        imagecopy($this->gd, $img, $left - $half_width, $top - $half_height, 0, 0, $sx, $sy);
        
        unset( $img );
        unset( $sx );
        unset( $sy );
        unset( $half_width );
        unset( $half_height );
    } // /gd_marker_png()



    /**
    * draw marker X
    *
    * @param int $left
    * @param int $top
    * @param object $line_color
    */
    private function gd_marker_x( $left, $top, $line_color ){
        imagesetthickness( $this->gd, $this->cfg['lines']['width'] - 1 );
        $half_width = ( $this->cfg['width_marker_x'] / 2 );
        $half_height = ( $this->cfg['height_marker_x'] / 2 );
        
        imageline($this->gd, $left - $half_width, $top - $half_width, $left + $half_width, $top + $half_width, $line_color );
        imageline($this->gd, $left - $half_width, $top + $half_width, $left + $half_width, $top - $half_width, $line_color );

        unset( $half_width );
        unset( $half_height );
    } // /gd_marker_x()



    /**
    * draw marker ^ = triangle
    *
    * @param int $left
    * @param int $top
    * @param object $backgr_color
    */
    private function gd_marker_triangle( $left, $top, $backgr_color ){
        imagesetthickness( $this->gd, $this->cfg['lines']['width'] - 1 );
        
        $half_width = ( $this->cfg['width_marker_x'] / 2 );
        $half_height = ( $this->cfg['height_marker_x'] / 2 );
        
        $coords = array(
                $left,  $top - $half_height,  // Point 1 (x, y)
                $left + $half_width,  $top + $half_height, // Point 2 (x, y)
                $left - $half_width,  $top + $half_height,  // Point 3 (x, y)
                $left,  $top - $half_height  // Point 4 (x, y)
                );
        
        imagefilledpolygon($this->gd, $coords, 4, $backgr_color);
        
        unset( $half_width );
        unset( $half_height );
        unset( $coords );
    } // /gd_marker_triangle()



    /**
    * draw marker 'd' = diamond
    *
    * @param int $left
    * @param int $top
    * @param object $backgr_color
    */
    private function gd_marker_diamond( $left, $top, $backgr_color ){
        imagesetthickness( $this->gd, $this->cfg['lines']['width'] - 1 );
        
        $half_width = ( $this->cfg['width_marker_x'] / 2 );
        $half_height = ( $this->cfg['height_marker_x'] / 2 );
        
        $coords = array(
                $left - $half_width,  $top,  // Point 1 (x, y)
                $left,  $top - $half_height - $half_height/2, // Point 2 (x, y)
                $left + $half_width,  $top,  // Point 1 (x, y)
                $left,  $top + $half_height + $half_height/2, // Point 2 (x, y)
                $left - $half_width,  $top,  // Point 1 (x, y)
                );
        
        imagefilledpolygon($this->gd, $coords, 5, $backgr_color);
        
        unset( $half_width );
        unset( $half_height );
        unset( $coords );
    } // /gd_marker_diamond()



    /**
    * draw marker 's' = square
    *
    * @param int $left
    * @param int $top
    * @param object $backgr_color
    */
    private function gd_marker_rectangle( $left, $top, $backgr_color ){
        imagesetthickness( $this->gd, $this->cfg['lines']['width'] - 1 );
        
        $half_width = ( $this->cfg['width_marker_x'] / 2 );
        $half_height = ( $this->cfg['height_marker_x'] / 2 );
        
        imagefilledrectangle($this->gd, $left - $half_width, $top - $half_height, $left + $half_width, $top + $half_height, $backgr_color);
        
        unset( $half_width );
        unset( $half_height );
    } // /gd_marker_rectangle()



    /**
    * draw marker 'o'
    *
    * @param int $left
    * @param int $top
    * @param object $bkgr_color
    */
    private function gd_marker_o( $left, $top, $bkgr_color ){
        imagefilledellipse ( $this->gd , $left, $top, $this->cfg['width_marker_o'], $this->cfg['height_marker_o'], $bkgr_color); // Draw ellipse
    } // /gd_marker_o()
	
	
	
	/**
     * get the PIXELS AVAILABLE in X AXIS of the zone to Draw
     * 
     */
    private function pixels_available_x( ){
		return $this->cfg['pix_width'] - $this->cfg['pix_paddingleft'] - 1 - $this->cfg['pix_paddinginsideleft'] - $this->cfg['pix_paddingright'] - 1 - $this->cfg['pix_paddinginsideright'];
	}// /pixels_available_x()
	
	
	
	/**
     * get the PIXELS AVAILABLE in Y AXIS of the zone to Draw
     * 
     */
    private function pixels_available_y( ){
		return $this->cfg['pix_height'] - $this->cfg['pix_paddingtop'] - 1 - $this->cfg['pix_paddinginsidetop'] - $this->cfg['pix_paddingbottom'] - 1 - $this->cfg['pix_paddinginsidebottom'];
	}// /pixels_available_y()
	
	
	
	/**
     * get the WIDTHS of the col Bar
	 *
     *@return array $widths //['total_width', 'bar_width', 'margin_width' ]
     */
    private function barwidths( $id_serie = 0 ){
		// Maths axis X
		$global_min_x 	= ( isset($this->cfg['global_force_min_x'])?$this->cfg['global_force_min_x']:$this->cfg['global_min_x']);
        $global_max_x 	= ( isset($this->cfg['global_force_max_x'])?$this->cfg['global_force_max_x']:$this->cfg['global_max_x']);
        $global_diff_x 	= $global_max_x - $global_min_x;
		$diff_x			= $this->cfg['values'][$id_serie]['diff_x'];
				
        $count_short_values_x 	= count( $this->cfg['values'][$id_serie]['values_x'] );// Take one sample of data
        
		// if we have 5 cols and will be drawed in 15 cols, need to do a change in $count_short_values_x
		// Then do a rule of 3
		// if  diff_x == count_short_values_x Then global_diff_x will be X
		// Math operation will be:
		// X = global_diff_x * diff_x  / count_short_values_x
		$count_short_values_x 	= ( ($global_diff_x  ) * ($count_short_values_x-1) / ( $diff_x) )+1	;
		
		
        $pixels_available_x 	= $this->pixels_available_x();
        $pixels_size_step_x   	= $pixels_available_x / ($count_short_values_x - (1*$this->cfg['bars']['percmarginbetwbars'] / 100)  ); // Add last bar margin to end at full right bar
		$margin_betw_bar_perc 	= $pixels_size_step_x * $this->cfg['bars']['percmarginbetwbars'] / 100; // margin between bars
		
		$barwidths = [];
		$barwidths['total_width'] 	= $pixels_size_step_x;
		$barwidths['margin_width'] 	= $margin_betw_bar_perc;
		$barwidths['bar_width'] 	= ( $barwidths['total_width'] - $barwidths['margin_width'] );
		
		$this->cfg['global_inside_margin_x_axis'] = ( $barwidths['bar_width'] / 2 );

        unset( $global_min_x );
        unset( $global_max_x );
        unset( $global_diff_x );
        unset( $diff_x );
        unset( $count_short_values_x );
        unset( $pixels_available_x );
        unset( $pixels_size_step_x );
        unset( $margin_betw_bar_perc );
		
		return $barwidths;
	}// /barwidths()
	


    /**
     * Generate BAR Graph
     * 
     */
    private function generate_gd_bar_graph( $id_serie = 0 ){
		$values 	= $this->cfg['values'][$id_serie];
		$barwidths 	= $this->barwidths( $id_serie ); // ['total_width', 'bar_width', 'margin_width' ]
		
		$line_color_rgb = $this->math->hex2rgb( $values['color'] );
        $line_color = imagecolorallocate( $this->gd, $line_color_rgb[0], $line_color_rgb[1], $line_color_rgb[2]);

		// Maths axis X
		$global_min_x = ( isset($this->cfg['global_force_min_x'])?$this->cfg['global_force_min_x']:$this->cfg['global_min_x']);
        $global_max_x = ( isset($this->cfg['global_force_max_x'])?$this->cfg['global_force_max_x']:$this->cfg['global_max_x']);
		$global_min_y = ( isset($this->cfg['global_force_min_y'])?$this->cfg['global_force_min_y']:$this->cfg['global_min_y']);
        $global_max_y = ( isset($this->cfg['global_force_max_y'])?$this->cfg['global_force_max_y']:$this->cfg['global_max_y']);
		$global_diff_y 	= $global_max_y - $global_min_y;
		$global_diff_x 	= $global_max_x - $global_min_x;
		
		if( $global_diff_x == 0 ){
			// Cannot divide by 0
			$global_diff_x = 1;
		}
		
		if( $global_diff_y == 0 ){
			// Cannot divide by 0
			$global_diff_y = 1;
		}
		
        $arr_short_values_x = $this->long_2_short_arrays( $this->arr_2_less_decimals($values['values_x']) );
        $count_short_values_x = count( $arr_short_values_x );
        $pixels_available_x = $this->pixels_available_x() - $this->cfg['global_inside_margin_x_axis'] * 2;
        $pixels_size_step_x   = $barwidths['total_width'];
		$margin_betw_bar_perc = $barwidths['margin_width'];
		
		// Maths axis Y
        $arr_short_values_y = $this->long_2_short_arrays( $values['values_y'] );
        $count_short_values_y = count( $arr_short_values_y );
        $pixels_available_y = $this->pixels_available_y();

        $max_top    = $this->cfg['pix_paddingtop'] + 1 + $this->cfg['pix_paddinginsidetop'];
        $min_bottom = ($this->cfg['pix_height'] -1) - $this->cfg['pix_paddingbottom'] - 1 - $this->cfg['pix_paddinginsidebottom'];
        $left_begin   = $this->cfg['pix_paddingleft'] + 1 + $this->cfg['pix_paddinginsideleft'] + $this->cfg['global_inside_margin_x_axis']; // left & right;

        for( $i = 0; $i < $count_short_values_x; $i++ ){
			//$left = (int)($left_begin + $barwidths['total_width'] * ($values['values_x'][$i]-$global_min_x));
			$left = (int)($left_begin + ($values['values_x'][$i] - $global_min_x) * $pixels_available_x / $global_diff_x) - $this->cfg['global_inside_margin_x_axis'];
            $top  = (int)($min_bottom - ($values['values_y'][$i] - $global_min_y) * $pixels_available_y / $global_diff_y);
			
            $right = (int)($left + $barwidths['bar_width'] );
            $bottom = $min_bottom;
			
			
			imagefilledrectangle( $this->gd, $left, $top, $right, $bottom, $line_color );
        }

        unset( $value );
        unset( $line_color );
        unset( $i );
        unset( $bottom );
        unset( $right );
        unset( $top );
        unset( $left );
        unset( $left_begin );
        unset( $min_bottom );
        unset( $max_top );
        unset( $pixels_available_y );
        unset( $count_short_values_y );
        unset( $arr_short_values_y );
        unset( $margin_betw_bar_perc );
        unset( $pixels_size_step_x );
        unset( $pixels_available_x );
        unset( $count_short_values_x );
        unset( $arr_short_values_x );
        unset( $global_diff_y );
        unset( $global_diff_x );
        unset( $global_max_y );
        unset( $global_min_y );
        unset( $global_max_x );
        unset( $global_min_x );
        unset( $line_color_rgb );
        unset( $barwidths );
        unset( $values );
    } // /generate_gd_bar_graph()



    /**
     * merge background image
     * 
     * */
    private function gd_backgr_img( ){
        // Load background image
        if( isset($this->cfg['backgroundimage']) ){
            $left =  $this->cfg['pix_paddingleft'] + 2;
            $top =  $this->cfg['pix_paddingtop'] + 2;

            $width = $this->pixels_available_x( ) + $this->cfg['pix_paddinginsideleft'] + 1 + $this->cfg['pix_paddinginsideright'] - 2;
            $height = $this->pixels_available_y( ) + $this->cfg['pix_paddinginsidetop'] + 1 + $this->cfg['pix_paddinginsidetop'] - 2;

            
            $this->bckgr_img_gd->resample( $width, $height, false );
            
            imagecopy($this->gd, $this->bckgr_img_gd->gd(), $left, $top, 0, 0, $width, $height);

            unset( $left );
            unset( $top );
            unset( $width );
            unset( $height );
        }
    } // /gd_backgr_img()



    /**
     * Create GD Work Space
     * 
	 * @param array $cfg
     * @param array $x_values
     */
    private function generate_gd_work_space( $cfg = null){
		$this->recalc_max_min( );

        $this->set_cfg_inch_2_pixels( );

        $this->gd_blank_backgr( );
        
        $this->gd_draw_inside_border( );

        $this->gd_backgr_img( );

        // Activate margin axis x if there is 1 bar graph at least
        foreach( $this->cfg['values'] as $key => $value){
            if( $value['type'] == 'bar'){
               $this->barwidths( 0 );
               break;
            }
        }
		
		$this->gd_draw_axis_x( $cfg );
        
        $this->gd_draw_axis_y( $cfg );

        $this->gd_drawtitle( );

        $this->gd_draw_xlabel( );

        $this->gd_draw_ylabel( );

        unset( $key );
        unset( $value );
    } // /generate_gd_work_space()



    /**
     * Draw ylabel
     * 
     * imagettfbbox():
     * 0	lower left corner, X position
     * 1	lower left corner, Y position
     * 2	lower right corner, X position
     * 3	lower right corner, Y position
     * 4	upper right corner, X position
     * 5	upper right corner, Y position
     * 6	upper left corner, X position
     * 7	upper left corner, Y position
     */
    private function gd_draw_ylabel( ){
        if( $this->cfg['ylabel'] != '' ){
            $angle = 90;
            $left = $this->cfg['ymarginleftlabel'];
            $font_path = $this->cfg['fontdir']. '/' . $this->cfg['fontfamilypath']. '/' . $this->cfg['font'];
            $text_color = imagecolorallocate( $this->gd, 0, 0, 0); // Black

            $pixels_available = $this->cfg['pix_height'] - $this->cfg['pix_paddingtop'] - 1 - $this->cfg['pix_paddinginsidetop'] - $this->cfg['pix_paddingbottom'] - 1 - $this->cfg['pix_paddinginsidebottom'];
            $font_measures = imagettfbbox( $this->cfg['fontsize'], $angle,  $font_path, $this->cfg['ylabel'] );
            $width_font     = abs($font_measures[5] - $font_measures[0]);
            $rest_available_size = $pixels_available - $width_font;
            $top = $this->cfg['pix_paddingtop'] + 1 + $this->cfg['pix_paddinginsidetop'] + ($rest_available_size/2) + ($width_font);
            imagettftext($this->gd,  $this->cfg['fontsize'], $angle, $left, $top, $text_color, $font_path, $this->cfg['ylabel'] );

            unset( $angle );
            unset( $rest_available_size );
            unset( $left );
            unset( $top );
            unset( $width_font );
            unset( $text_color );
            unset( $pixels_available );
            unset( $font_measures );
            unset( $font_path );
        }
    } // /gd_draw_ylabel()



    /**
     * Draw xlabel
     * 
     * imagettfbbox():
     * 0	lower left corner, X position
     * 1	lower left corner, Y position
     * 2	lower right corner, X position
     * 3	lower right corner, Y position
     * 4	upper right corner, X position
     * 5	upper right corner, Y position
     * 6	upper left corner, X position
     * 7	upper left corner, Y position
     */
    private function gd_draw_xlabel( ){
        if( $this->cfg['xlabel'] != '' ){
            $angle = 0;
            
            $font_path = $this->cfg['fontdir']. '/' . $this->cfg['fontfamilypath']. '/' . $this->cfg['font'];
            $text_color = imagecolorallocate( $this->gd, 0, 0, 0); // Black

            $pixels_available = $this->cfg['pix_width'] - $this->cfg['pix_paddingleft'] - 1 - $this->cfg['pix_paddinginsideleft'] - $this->cfg['pix_paddingright'] - 1 - $this->cfg['pix_paddinginsideright'];
			$top = $this->cfg['pix_height'] - 10;
            $font_measures = imagettfbbox( $this->cfg['fontsize'], $angle,  $font_path, $this->cfg['xlabel'] );
            //var_dump( $font_measures );
            $width_font     = abs($font_measures[2]) - abs($font_measures[5]);
            $rest_available_size = $pixels_available - $width_font;
            $left = $this->cfg['pix_paddingleft'] + 1 + $this->cfg['pix_paddinginsideleft'] + ($rest_available_size/2);
            imagettftext($this->gd,  $this->cfg['fontsize'], $angle, $left, $top, $text_color, $font_path, $this->cfg['xlabel'] );

            unset( $angle );
            unset( $rest_available_size );
            unset( $left );
            unset( $top );
            unset( $width_font );
            unset( $text_color );
            unset( $pixels_available );
            unset( $font_measures );
            unset( $font_path );
        }
    } // /gd_draw_xlabel()



    /**
     * Draw TITLE
     * 
     * imagettfbbox():
     * 0	lower left corner, X position
     * 1	lower left corner, Y position
     * 2	lower right corner, X position
     * 3	lower right corner, Y position
     * 4	upper right corner, X position
     * 5	upper right corner, Y position
     * 6	upper left corner, X position
     * 7	upper left corner, Y position
     */
    private function gd_drawtitle( ){
        if( $this->cfg['title'] != '' ){
            $angle = 0;
            $titlefontsize = $this->cfg['fontsize'] + 2.5;
            $font_path      = $this->cfg['fontdir']. '/' . $this->cfg['fontfamilypath']. '/' . $this->cfg['font'];
            $text_color     = imagecolorallocate( $this->gd, 0, 0, 0); // Black

            $pixels_available       = $this->pixels_available_x();
            $width_font             = $this->math->str_len_ttf( $this->cfg['title'], $font_path, $titlefontsize, $angle );
            $top                    = $this->cfg['margintitle'];
            $rest_available_size    = $pixels_available - $width_font;
            $left                   = $this->cfg['pix_paddingleft'] + 1 + $this->cfg['pix_paddinginsideleft'] + ($rest_available_size/2);
            imagettftext($this->gd,  $titlefontsize, $angle, $left, $top, $text_color, $font_path, $this->cfg['title'] );

            unset( $angle );
            unset( $titlefontsize );
            unset( $rest_available_size );
            unset( $left );
            unset( $top );
            unset( $width_font );
            unset( $text_color );
            unset( $pixels_available );
            unset( $font_measures );
            unset( $font_path );
        }
    } // /gd_drawtitle()
    
        
   
    /**
     * Draw Axis X (ticks & values)
     * 
	 * @param array $cfg
     */
    private function gd_draw_axis_x( $cfg = null ){
        $this->gd_draw_xticks( $cfg );
        if( $this->cfg['xshowlabelticks']){
            $this->gd_draw_values_x( $cfg );
        }
    } // /gd_draw_axis_x()



    /**
     * Draw Axis Y (ticks & values)
     * 
	 * @param array $cfg
     */
    private function gd_draw_axis_y( $cfg = null ){
        $this->gd_draw_yticks( $cfg );
        if( $this->cfg['yshowlabelticks']){
            $this->gd_draw_values_y( );
        }
    } // /gd_draw_axis_y()



    /**
     * Draw Axis X Values
     * 
	 * @param array $cfg
     */
    private function gd_draw_values_x( $cfg = null ){
		$centerlabels = ((isset($cfg['centerlabels']))?$cfg['centerlabels']:$this->cfg['centerlabels']); // Used for Bar graphs or Category bar graphs
		
        $font_path = $this->cfg['fontdir']. '/' . $this->cfg['fontfamilypath']. '/' . $this->cfg['font'];
        $global_min_x = ( isset($this->cfg['global_force_min_x'])?$this->cfg['global_force_min_x']:$this->cfg['global_min_x']);
        $global_max_x = ( isset($this->cfg['global_force_max_x'])?$this->cfg['global_force_max_x']:$this->cfg['global_max_x']);
		
        $arr_short_values = $this->long_2_short_arrays( $this->transform_x_values([$global_min_x, $global_max_x ]) );
        $count_short_values = count( $arr_short_values );
        $pixels_available = $this->cfg['pix_width'] - $this->cfg['pix_paddingleft'] - 1 - $this->cfg['pix_paddinginsideleft'] - $this->cfg['pix_paddingright'] - 1 - $this->cfg['pix_paddinginsideright'];
		if( isset($this->cfg['global_inside_margin_x_axis']) ){
			$pixels_available -= $this->cfg['global_inside_margin_x_axis'] * 2; // left & right
		}
		if( $centerlabels ){
			$pixels_size_step   = $pixels_available / ($count_short_values);
		} else {
			$pixels_size_step   = $pixels_available / ($count_short_values - 1);
		}

        $text_color = imagecolorallocate( $this->gd, 0, 0, 0); // Black

        $top    = $this->cfg['pix_height'] - $this->cfg['pix_paddingbottom'] + 4 + $this->cfg['xmarginlabelsticks']; // 4 pixels tick + 16 pixels margin
        $left_begin   = $this->cfg['pix_paddingleft'] + 1 + $this->cfg['pix_paddinginsideleft'] + 1;
		if( isset($this->cfg['global_inside_margin_x_axis']) ){
			$left_begin += $this->cfg['global_inside_margin_x_axis'];
		}

        $angle = $this->cfg['xticks']['rotation'];

        if( $angle != 0 ){
            $top -= 4; // Better margin for angled labels
        }

        for( $i = 0; $i < $count_short_values; $i++ ){
            // If we have angle for draw text, then we need to calc the diff between height of font at angle 0 and height of font at $angle to draw text with margin
            $height_font_angle_0 = $this->math->str_height_ttf( $arr_short_values[ $i ], $font_path, $this->cfg['xtickfontsize']);
            $width_font         = $this->math->str_len_ttf( $arr_short_values[ $i ], $font_path, $this->cfg['xtickfontsize'], $angle );
            $height_font        = $this->math->str_height_ttf( $arr_short_values[ $i ], $font_path, $this->cfg['xtickfontsize'], $angle );

            // Calc diff between height angle 0 and $angle
            $diff_pix_angle     = $height_font - $height_font_angle_0;
            //$diff_pix_angle     /= 2; // Divide the pixels margin between 2 (up & down pixels)

            $left_center = $left_begin + ($pixels_size_step * $i) - 1;
            if( $angle == 0 ){
                $left = $left_center - $width_font / 2;
            } else {
                $left = $left_center - $width_font + 8; // 8 = margin aprox 1 char to right. Last char will be in the middel of the tick
            }
			if( $centerlabels ){
				$left += $pixels_size_step/2;
			}

            imagettftext($this->gd,  $this->cfg['xtickfontsize'], $angle, $left, $top + $diff_pix_angle, $text_color, $font_path, $arr_short_values[ $i ] );
        }

        unset( $arr_short_values );
        unset( $count_short_values );
        unset( $pixels_available );
        unset( $pixels_size_step );
        unset( $line_color );
        unset( $top );
        unset( $left_begin );
        unset( $i );
        unset( $left );
        unset( $angle );
        unset( $centerlabels );
        unset( $font_path );
        unset( $text_color );
        unset( $width_font );
        unset( $global_max_x );
        unset( $global_min_x );
    } // /gd_draw_values_x()



    /**
     * Draw Axis Y Values
     * 
     */
    private function gd_draw_values_y( ){
        $font_path = $this->cfg['fontdir']. '/' . $this->cfg['fontfamilypath']. '/' . $this->cfg['font'];
		
        $global_min_y = ( isset($this->cfg['global_force_min_y'])?$this->cfg['global_force_min_y']:$this->cfg['global_min_y']);
        $global_max_y = ( isset($this->cfg['global_force_max_y'])?$this->cfg['global_force_max_y']:$this->cfg['global_max_y']);
		
        $arr_short_values = $this->long_2_short_arrays( $this->transform_x_values([$global_min_y, $global_max_y ]) );
        rsort( $arr_short_values );
        $count_short_values = count( $arr_short_values );
        $pixels_available = $this->cfg['pix_height'] - $this->cfg['pix_paddingtop'] - 1 - $this->cfg['pix_paddingbottom'] - 1 - $this->cfg['pix_paddinginsidetop'] - $this->cfg['pix_paddinginsidebottom'];
        $pixels_size_step   = $pixels_available / ($count_short_values - 1);

        $text_color = imagecolorallocate( $this->gd, 0, 0, 0); // Black

        $top_begin   = $this->cfg['pix_paddingtop'] + $this->cfg['pix_paddinginsidetop'] + 2;

        $angle = 0;

        $right    = $this->cfg['pix_paddingleft'] - $this->cfg['ymarginlabelsticks'];

        for( $i = 0; $i < $count_short_values; $i++ ){
            $font_measures = imagettfbbox( $this->cfg['ytickfontsize'], $angle,  $font_path, $arr_short_values[ $i ] );
            $width_font     = abs($font_measures[4] - $font_measures[0]);
            $height_font    = abs($font_measures[5] - $font_measures[1]);

            $top_center = $top_begin + ($pixels_size_step * $i);
            $top = $top_center + $height_font / 2;

            $left = $right - $width_font;
            imagettftext($this->gd,  $this->cfg['ytickfontsize'], $angle, $left, $top, $text_color, $font_path, $arr_short_values[ $i ] );
        }

        unset( $arr_short_values );
        unset( $count_short_values );
        unset( $pixels_available );
        unset( $pixels_size_step );
        unset( $line_color );
        unset( $top );
        unset( $left_begin );
        unset( $i );
        unset( $left );
        unset( $angle );
        unset( $font_path );  
        unset( $global_min_y );  
        unset( $global_max_y ); 
        unset( $text_color );  
        unset( $top_begin );   
        unset( $right );      
        unset( $font_measures ); 
        unset( $width_font );     
        unset( $height_font );    
        unset( $top_center );        
    } // /gd_draw_values_y()



    /**
     * Draw Axis Xticks
     * 
     */
    private function gd_draw_xticks( $cfg = null ){
		$y_drawguidelines = ((isset($cfg['y_drawguidelines']))?$cfg['y_drawguidelines']:$this->cfg['y_drawguidelines']);
		$centerlabels = ((isset($cfg['centerlabels']))?$cfg['centerlabels']:$this->cfg['centerlabels']); // Used for Bar graphs or Category bar graphs

        $global_min_x = ( isset($this->cfg['global_force_min_x'])?$this->cfg['global_force_min_x']:$this->cfg['global_min_x']);
        $global_max_x = ( isset($this->cfg['global_force_max_x'])?$this->cfg['global_force_max_x']:$this->cfg['global_max_x']);
		
        $arr_short_values = $this->long_2_short_arrays( $this->transform_x_values([$global_min_x, $global_max_x ]) );
        $count_short_values = count( $arr_short_values );
        $pixels_available = $this->cfg['pix_width'] - $this->cfg['pix_paddingleft'] - 1 - $this->cfg['pix_paddinginsideleft'] - $this->cfg['pix_paddingright'] - 1 - $this->cfg['pix_paddinginsideright'];
		if( isset($this->cfg['global_inside_margin_x_axis']) ){
			$pixels_available -= $this->cfg['global_inside_margin_x_axis'] * 2; // left & right
		}
		if( $centerlabels ){
			$pixels_size_step   = $pixels_available / ($count_short_values);
		} else {
			$pixels_size_step   = $pixels_available / ($count_short_values - 1);
		}

        $line_color = imagecolorallocate( $this->gd, 0, 0, 0); // Black
		$guideline_color = imagecolorallocate( $this->gd, 227, 227, 227); // gray

        $pixel_gray = imagecolorallocate( $this->gd, 127, 127, 127); // Gray
        $outside_layer1 = imagecolorallocate( $this->gd, 241, 241, 241); // outside Layer 1
        $outside_layer2 = imagecolorallocate( $this->gd, 227, 227, 227); // outside Layer 2
        $outside_layer3 = imagecolorallocate( $this->gd, 253, 253, 253); // outside Layer 3

        $top    = $this->cfg['pix_height'] - $this->cfg['pix_paddingbottom'];
        $bottom = $top + 3;
        $left_begin   = $this->cfg['pix_paddingleft'] + 1 + $this->cfg['pix_paddinginsideleft'];
		if( isset($this->cfg['global_inside_margin_x_axis']) ){
			$left_begin += $this->cfg['global_inside_margin_x_axis'];
		}

        for( $i = 0; $i < $count_short_values; $i++ ){
            $left = $left_begin + ($pixels_size_step * $i);
			if( $centerlabels ){
				$left += $pixels_size_step/2;
			}
            $right = $left;

            
            // Smooth
            imagerectangle( $this->gd, $left-1, $top, $left+1, $bottom, $outside_layer1);
            imagesetpixel($this->gd, $left-1, $bottom+1, $outside_layer3);
            imagesetpixel($this->gd, $left+1, $bottom+1, $outside_layer3);
            imagesetpixel($this->gd, $left-1, $top, $outside_layer2);
            imagesetpixel($this->gd, $left+1, $top, $outside_layer2);

            imageline( $this->gd, $left, $top, $right, $bottom, $line_color );
            imagesetpixel($this->gd, $left, $bottom + 1, $pixel_gray);
			
			if( $y_drawguidelines ){
				imageline( $this->gd, $left, $top-2, $left, $this->cfg['pix_paddingtop'] + 2, $guideline_color );
			}
        }

        unset( $arr_short_values );
        unset( $count_short_values );
        unset( $pixels_available );
        unset( $pixels_size_step );
        unset( $line_color );
        unset( $top );
        unset( $bottom );
        unset( $left_begin );
        unset( $i );
        unset( $left );
        unset( $right );
        unset( $y_drawguidelines );
        unset( $centerlabels );
        unset( $pixel_gray );
        unset( $outside_layer1 );
        unset( $outside_layer2 );
        unset( $outside_layer3 );
        unset( $guideline_color );
        unset( $global_max_x );
        unset( $global_min_x );
    } // /gd_draw_xticks()



    /**
     * Draw Axis Yticks
     * 
	 * @param array $cfg
     */
    private function gd_draw_yticks( $cfg ){
		$x_drawguidelines = ((isset($cfg['x_drawguidelines']))?$cfg['x_drawguidelines']:$this->cfg['x_drawguidelines']);
		
        $global_min_y = ( isset($this->cfg['global_force_min_y'])?$this->cfg['global_force_min_y']:$this->cfg['global_min_y']);
        $global_max_y = ( isset($this->cfg['global_force_max_y'])?$this->cfg['global_force_max_y']:$this->cfg['global_max_y']);
		
        $arr_short_values = $this->long_2_short_arrays( $this->transform_x_values([$global_min_y, $global_max_y ]) );
        
        $count_short_values = count( $arr_short_values );
        $pixels_available = $this->cfg['pix_height'] - $this->cfg['pix_paddingtop'] - 1 - $this->cfg['pix_paddingbottom'] - 1 - $this->cfg['pix_paddinginsidetop'] - $this->cfg['pix_paddinginsidebottom'];
        $pixels_size_step   = $pixels_available / ($count_short_values - 1);

        $line_color = imagecolorallocate( $this->gd, 0, 0, 0); // Black
		$guideline_color = imagecolorallocate( $this->gd, 227, 227, 227); // gray

        $pixel_gray = imagecolorallocate( $this->gd, 127, 127, 127); // Gray
        $outside_layer1 = imagecolorallocate( $this->gd, 241, 241, 241); // outside Layer 1
        $outside_layer2 = imagecolorallocate( $this->gd, 227, 227, 227); // outside Layer 2
        $outside_layer3 = imagecolorallocate( $this->gd, 253, 253, 253); // outside Layer 3

        $right    = $this->cfg['pix_paddingleft'];
        $left = $right - 3;
        $top_begin   = $this->cfg['pix_paddingtop'] + 1 + $this->cfg['pix_paddinginsidetop'];

        for( $i = 0; $i < $count_short_values; $i++ ){
            $top = $top_begin + ($pixels_size_step * $i);
            $bottom = $top;

            // Smooth
            imagerectangle( $this->gd, $left, $top-1, $right-1, $top+1, $outside_layer1);
            imagesetpixel($this->gd, $left-1, $top-1, $outside_layer3);
            imagesetpixel($this->gd, $left-1, $top+1, $outside_layer3);
            imagesetpixel($this->gd, $right, $top-1, $outside_layer2);
            imagesetpixel($this->gd, $right, $top+1, $outside_layer2);

            imageline( $this->gd, $left, $top, $right, $bottom, $line_color );
            imagesetpixel($this->gd, $left-1, $top, $pixel_gray);
			
			if( $x_drawguidelines ){
				imageline( $this->gd, $left+5, $top, $this->cfg['pix_width'] - $this->cfg['pix_paddingright'] - 2, $top, $guideline_color );
			}
        }

        unset( $arr_short_values );
        unset( $count_short_values );
        unset( $pixels_available );
        unset( $pixels_size_step );
        unset( $line_color );
        unset( $guideline_color );
        unset( $pixel_gray );
        unset( $outside_layer1 );
        unset( $outside_layer2 );
        unset( $outside_layer3 );
        unset( $top );
        unset( $bottom );
        unset( $left_begin );
        unset( $top_begin );
        unset( $i );
        unset( $left );
        unset( $right );
        unset( $x_drawguidelines );
        unset( $global_min_y );
        unset( $global_max_y );
    } // /gd_draw_yticks()



    /**
     * Draw inside graph border
     * 
     */
    private function gd_draw_inside_border( ){
        $border_color   = imagecolorallocate( $this->gd, 0, 0, 0); // Black
        $outside_layer1 = imagecolorallocate( $this->gd, 241, 241, 241); // outside Layer 1
        $outside_layer2 = imagecolorallocate( $this->gd, 227, 227, 227); // outside Layer 2
        $outside_layer3 = imagecolorallocate( $this->gd, 253, 253, 253); // outside Layer 3

        $left   = $this->cfg['pix_paddingleft'] + 1;
        $right  = $this->cfg['pix_width'] - $this->cfg['pix_paddingright'] - 1;
        $top    = $this->cfg['pix_paddingtop'] + 1;
        $bottom = $this->cfg['pix_height'] - $this->cfg['pix_paddingbottom'] - 1;

        if( $this->cfg['bordertype'] == 'square'){
            // Outside layer 1
            imagerectangle( $this->gd, $left-1, $top-1, $right+1, $bottom+1, $outside_layer1);
            imagerectangle( $this->gd, $left+1, $top+1, $right-1, $bottom-1, $outside_layer1);

            // 4 round internal borders outside_layer2
            imagesetpixel($this->gd, $left-1, $top, $outside_layer2);
            imagesetpixel($this->gd, $right+1, $top, $outside_layer2);
            imagesetpixel($this->gd, $left, $bottom+1, $outside_layer2);
            imagesetpixel($this->gd, $right, $bottom+1, $outside_layer2);
            imagesetpixel($this->gd, $left, $top-1, $outside_layer2);
            imagesetpixel($this->gd, $right, $top-1, $outside_layer2);
            imagesetpixel($this->gd, $left-1, $bottom, $outside_layer2);
            imagesetpixel($this->gd, $right+1, $bottom, $outside_layer2);

            // 4 round external borders outside_layer2
            imagesetpixel($this->gd, $left+1, $top+1, $outside_layer2);
            imagesetpixel($this->gd, $right-1, $top+1, $outside_layer2);
            imagesetpixel($this->gd, $left+1, $bottom-1, $outside_layer2);
            imagesetpixel($this->gd, $right-1, $bottom-1, $outside_layer2);

            // 4 external borders
            imagesetpixel($this->gd, $left-1, $top-1, $outside_layer3);
            imagesetpixel($this->gd, $right+1, $top-1, $outside_layer3);
            imagesetpixel($this->gd, $left-1, $bottom+1, $outside_layer3);
            imagesetpixel($this->gd, $right+1, $bottom+1, $outside_layer3);

            // Black border
            imagerectangle( $this->gd, $left, $top, $right, $bottom, $border_color);
        } else if( $this->cfg['bordertype'] == 'halfsquare'){
            imageline( $this->gd, $left, $bottom, $right, $bottom, $border_color ); // Underline
            imageline( $this->gd, $left, $bottom, $left, $top, $border_color ); // Left Line
        }

        unset( $border_color );
        unset( $outside_layer1 );
        unset( $outside_layer2 );
        unset( $outside_layer3 );
        unset( $left );
        unset( $right );
        unset( $top );
        unset( $bottom );
    } // /gd_draw_inside_border()



    /**
     * free gd image
     * 
     */
    private function free_gd( ){
        imagedestroy($this->gd);
		$this->gd = null;
    } // /free_gd()



    /**
     * Output GD graph in png
     * 
     */
    private function output_gd_png( ){
        header("Content-type: image/png");
        imagepng($this->gd);
    } // /output_gd_png()



    /**
     * Converts a long values array to shortest values array
     * 
     * @param array $long_array
     * @return array $short_array
     */
    private function long_2_short_arrays( $long_array ){
        return $long_array;
    } // /long_2_short_arrays()



    /**
     * Set configuration values in pixels
     * 
     */
    private function set_cfg_inch_2_pixels( ){
        $this->cfg['pix_width']                 = $this->math->inch_2_pixels( $this->cfg['width'],                  $this->cfg['dpi'] );
        $this->cfg['pix_height']                = $this->math->inch_2_pixels( $this->cfg['height'],                 $this->cfg['dpi'] );
        $this->cfg['pix_paddingleft']           = $this->math->inch_2_pixels( $this->cfg['paddingleft'],            $this->cfg['dpi'] );
        $this->cfg['pix_paddingright']          = $this->math->inch_2_pixels( $this->cfg['paddingright'],           $this->cfg['dpi'] );
        $this->cfg['pix_paddingtop']            = $this->math->inch_2_pixels( $this->cfg['paddingtop'],             $this->cfg['dpi'] );
        $this->cfg['pix_paddingbottom']         = $this->math->inch_2_pixels( $this->cfg['paddingbottom'],          $this->cfg['dpi'] );
        $this->cfg['pix_paddinginsideleft']     = $this->math->inch_2_pixels( $this->cfg['paddinginsideleft'],      $this->cfg['dpi'] );
        $this->cfg['pix_paddinginsideright']    = $this->math->inch_2_pixels( $this->cfg['paddinginsideright'],     $this->cfg['dpi'] );
        $this->cfg['pix_paddinginsidetop']      = $this->math->inch_2_pixels( $this->cfg['paddinginsidetop'],       $this->cfg['dpi'] );
        $this->cfg['pix_paddinginsidebottom']   = $this->math->inch_2_pixels( $this->cfg['paddinginsidebottom'],    $this->cfg['dpi'] );
    } // /set_cfg_inch_2_pixels()



    /**
     * Generate Blank Background
     * 
     */
    private function gd_blank_backgr( ){
        $this->gd = @imagecreatetruecolor( $this->cfg['pix_width'], $this->cfg['pix_height']  ) or die("Cannot Initialize new GD image stream");
		imagesavealpha($this->gd, true);
		imagefill($this->gd,0,0,0x7fff0000); // alpha Channel
		
		imageantialias($this->gd, true);

        $backgr_color_rgb = $this->math->hex2rgb( $this->cfg['backgroundcolor'] );
        $backgr_color = imagecolorallocate( $this->gd, $backgr_color_rgb[0], $backgr_color_rgb[1], $backgr_color_rgb[2]);

        imagefill($this->gd, 0, 0, $backgr_color);

        unset( $backgr_color_rgb );
        unset( $backgr_color );
    }// /gd_blank_backgr()



    /**
     * Compute Offset. Search middel & top values for axis
     * 
     * $tableval will be array as:
     * [  'classes' => ['from' => 0, 'to' => 0],
     *    'avg'     => 0,
     *    'f'       => 0,
     *    'fr'      => 0,
     *    'F'       => 0 
     * ]
     * 
     * @param array $arrval
     * @param integer $accommodate_to_x_samples // Set to the number of ticks that you want. If not set, the system will do calcs itself
     * @return array $tableval
     */
    public function compute_offset( $arrval, $accommodate_to_x_samples = 0 ){
        $max = max( $arrval );
        $min = min( $arrval );
        $range = $max - $min;
        $arrcount = count( $arrval );

        if( $accommodate_to_x_samples > 0 ){
            $K = $accommodate_to_x_samples;
        } else {
            // $K = step by Sturge Rule
            $K = 1 + 3.322 * log($arrcount);

            // Round the step
            $K = round($K);

            // Better even. Not odd. Later we add one
            if( ( $K%2 ) ){
                --$K;
            }
        }

       // Calc Amplitude
        $A = ( $range / $K );

        if( $range>1 ){
            // TODO: ROUND WITH LOWER NUMBERS WITH DECIMALS
            // Round the Amplitude to up
            $A = ceil($A);
        }

        // Create table values
        $tableval = [];
        $tableval['classes']    = [];
        $tableval['avg']        = []; // Average
        $tableval['f']          = []; // Frequency
        $tableval['fr']         = []; // Relative Frequency
        $tableval['F']          = []; // Absolute Frequency

        for( $i=0; $i<$K; $i++ ){
            $classfrom = (($i>0)?$tableval['classes'][$i-1]['to']:$min);
            $classto = $classfrom + $A;
            $tableval['classes'][] = ['from' => $classfrom, 'to' => $classto];

            // Avg
            $tableval['avg'][] = $this->math->avg( [$classfrom, $classto] );

            // Frequency
            $f =  $this->math->freq( $arrval, $classfrom, $classto ); // if $i is the last, include $classto values too
            $tableval['f'][] = $f;

            // Relative Frequency
            $tableval['fr'][] = ( $f / $arrcount );

            // Absolute Frequency
            $tableval['F'][] = ( ( $i>0 ) ? $tableval['F'][$i-1] + $f : $f );
        }


        // For graphs we need to represent visually last value '$classto'. Then add it to the values
        $tableval['classes'][] = ['from' => $classto, 'to' => $classto];

        // Avg
        $tableval['avg'][] = $this->math->avg( [$classto, $classto] );

        // Frequency
        $f =  $this->math->freq( $arrval, $classto, $classto, true ); // if $i is the last, include $classto values too
        $tableval['f'][] = $f;

        // Relative Frequency
        $tableval['fr'][] = ( $f / $arrcount );

        // Absolute Frequency
        $tableval['F'][] = ( $tableval['F'][$i-1] + $f );

        unset( $max );
        unset( $min );
        unset( $range );
        unset( $arrcount );
        unset( $A );
        unset( $K );
        unset( $i );
        unset( $classfrom );
        unset( $classto );
        unset( $f );

        return $tableval;
    } // /compute_offset()
}// /graph
 ?>