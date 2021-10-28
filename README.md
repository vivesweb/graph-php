# Graph-PHP
graph bars, histograms, graph lines, scratter, marks

# V 1.0.0

## CREATE GRAPHS IN PHP:
You can create graphs with bars, graphs lines with marks, graphs with background images, histograms, ....

# SCREENSHOTS:
![Screenshot graph lines created in Pure PHP](https://github.com/vivesweb/graph/blob/main/sample%201.png?raw=true)

Nice line graph display with markers

![Screenshot graph bar & lines created in Pure PHP](https://github.com/vivesweb/graph/blob/main/sample2.png?raw=true)

Graph Bars & lines

![Screenshot graph lines created in Pure PHP](https://github.com/vivesweb/graph/blob/main/sample4.png?raw=true)

Nice line graph


 # REQUERIMENTS:
 
 Requires packages:
  
  img2img (https://github.com/vivesweb/img2img)
  
  ext-op-ml-php (https://github.com/vivesweb/ext_op_ml)
  
 Requires DeJaVu Fonts: (https://travis-ci.org/dejavu-fonts/dejavu-fonts)
 
 - A minimum (minimum, minimum, minimum requeriments is needed). Tested on:
 		
    - Simple Raspberry pi (B +	512MB	700 MHz ARM11) with Raspbian Lite PHP7.3 (i love this gadgets)  :heart_eyes:
 		
    - VirtualBox Ubuntu Server 20.04.2 LTS (Focal Fossa) with PHP7.4.3

    - Red Hat Enterprise Linux Server release 6.10 (Santiago) PHP Version 7.3.25 (Production Server) 512Mb Memory Limit

    - Red Hat Enterprise Linux release 8.4 (Ootpa). PHP Version 8.0.11 (Production Server) 512Mb Memory Limit


 
# FILES:
 *graph-php.class.php* -> **Main File**.
 
 *example.php* -> **Example File**.
 
 
 # INSTALLATION:
 A lot of easy :smiley:. It is written in PURE PHP. Only need to include the files. Tested on basic PHP installation
 
         require_once( 'graph-php.class.php' );
         

 # NOTES:
 Before draw the Graph, first we need to prepare values inside (as type bar, lines, etc....)
 
# RESUME OF METHODS:

- **CREATE GRAPH OBJECT:**
 
*$graph = new graph( $cfg=null );*

default $cfg:

      [
        'width'     => 6.4, // 6.4 inches
        'height'    => 4.8, // 4.8 inches 
        'dpi'       => 100, // 100 dpis
        'padding'   => .6, // 0.6 inches
        'fontdir'   => __DIR__.'/fonts',
        'fontfamilypath' => 'dejavu-fonts-ttf-2.37/ttf',
        'font'      => 'DejaVuSans.ttf',    
        'fontsize'  => 10.5,
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
        'paddingleft'           => .79,
        'paddingright'          => .63,
        'paddingtop'            => .58,
        'paddingbottom'         => .515,
        'paddinginsideleft'     => .2,
        'paddinginsideright'    => .2,
        'paddinginsidetop'      => .15,
        'paddinginsidebottom'   => .15,
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

Example:

      $graph = new graph();
 
 - **PREPARE BAR GRAPH:**
 
*$graph->bar( $array_values, $arr_values_y_param = null, $cfg = null );*

This method prepare a serie of values in BAR format. Do not echo the graph

$array_values: Values of Axis X

$arr_values_y_param: Values of Axis Y. If not given, each $array_values will be the Axys Y values and each value will be an index position in Axis X automatically

$cfg: *see CFG_GRAPH_TYPES

Example:

      $graph = new graph();
      $graph->bar( [1, 2, 3, 4] );
      echo '<img src="'.$graph->output_gd_png_base64( ).'" >'; // Echo img raw data in html page
      
Whith this simple code you will generate the most simplest graph:

![Simple graph bar](https://github.com/vivesweb/graph-php/blob/main/samplesimple.png?raw=true)

Example with x & y values:

      $graph = new graph();
      $graph->bar( [10, 20, 30, 40], [1, 4, 9, 16] );
      $graph->title("With X & Y Values"); // Set the title of the bar. See title() method
      echo '<img src="'.$graph->output_gd_png_base64( ).'" >'; // Echo img raw data in html page
      
Whith this simple code you will generate the most simplest graph:

![Simple graph bar with X & Y values](https://github.com/vivesweb/graph-php/blob/main/samplexyvalues.png?raw=true)


 
 - **SET GRAPH TITLE:**
 
*$graph->title( $title );*

*$graph->set_title( $title ); // synonymous of title()*

This method set the graph TITLE

$title: String with the title

Example:

      $graph = new graph();
      $graph->bar( [1, 2, 3, 4] );
      $graph->title("Here your graph TITLE");
      echo '<img src="'.$graph->output_gd_png_base64( ).'" >'; // Echo img raw data in html page
      
Whith this simple code you will generate Simple Bar graph with title:

![Simple graph bar with title](https://github.com/vivesweb/graph-php/blob/main/sampletitle.png?raw=true)
 
 - **SET GRAPH X LABEL:**
 
*$graph->xlabel( $xlabel );*

*$graph->set_xlabel( $xlabel ); // synonymous of xlabel()*

This method set the graph X LABEL

$xlabel: String with the X LABEL

Example:

      $graph = new graph();
      $graph->bar( [1, 2, 3, 4] );
      $graph->xlabel( 'Here your graph X LABEL' );
      echo '<img src="'.$graph->output_gd_png_base64( ).'" >'; // Echo img raw data in html page
      
Whith this simple code you will generate Simple Bar graph with X label:

![Simple graph bar with X LABEL](https://github.com/vivesweb/graph-php/blob/main/samplexlabel.png?raw=true)
 
 - **SET GRAPH Y LABEL:**
 
*$graph->ylabel( $ylabel );*

*$graph->set_ylabel( $ylabel ); // synonymous of ylabel()*

This method set the graph Y LABEL

$ylabel: String with the Y LABEL

Example:

      $graph = new graph();
      $graph->bar( [1, 2, 3, 4] );
      $graph->ylabel( 'Here your graph Y LABEL' );
      echo '<img src="'.$graph->output_gd_png_base64( ).'" >'; // Echo img raw data in html page
      
Whith this simple code you will generate Simple Bar graph with Y label:

![Simple graph bar with Y LABEL](https://github.com/vivesweb/graph-php/blob/main/sampleylabel.png?raw=true)





 
 **Of course. You can use it freely :vulcan_salute::alien:**
 
 By Rafa.
 
 
 @author Rafael Martin Soto
 
 @author {@link http://www.inatica.com/ Inatica}
 
 @blog {@link https://rafamartin10.blogspot.com/ Rafael Martin's Blog}
 
 @since October 2021
 
 @version 1.0.0
 
 @license GNU General Public License v3.0
