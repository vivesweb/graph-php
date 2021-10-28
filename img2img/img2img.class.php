<?php


/**
 * img2img.class.php
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
 * - Support for instagram filters https://github.com/zaachi/PHP-Instagram-effects
 * 
 * @author Rafael Martin Soto
 * @author {@link https://www.inatica.com/ Inatica}
 * @link https://rafamartin10.blogspot.com/
 * @since October 2021
 * @version 1.0.3
 * @license GNU General Public License v3.0
 * 
 * 
 */


 use Zaachi\Image\Filter;

 include __DIR__ . '/mime_types.php';  // Used in Mime types functions. See notes at  file_extension(()
 include __DIR__ . '/PHP-Instagram-effects-master/src/Image/Filter.php';  // For instagram filters

 define( 'IMG_FILTER_SEPIA', 				'IMG_FILTER_SEPIA');
 define( 'IMG_FILTER_BLACK_WHITE', 			'IMG_FILTER_BLACK_WHITE'); // Note that is different black & white that gray scale
 define( 'IMG_FILTER_VIGNETTE', 			'IMG_FILTER_VIGNETTE');

 define( 'IMG_FILTER_INSTGR_BUBBLES', 		'IMG_FILTER_INSTGR_BUBBLES');
 define( 'IMG_FILTER_INSTGR_COLORISE', 		'IMG_FILTER_INSTGR_COLORISE');
 define( 'IMG_FILTER_INSTGR_SEPIA', 		'IMG_FILTER_INSTGR_SEPIA');
 define( 'IMG_FILTER_INSTGR_SEPIA2', 		'IMG_FILTER_INSTGR_SEPIA2');
 define( 'IMG_FILTER_INSTGR_SHARPEN', 		'IMG_FILTER_INSTGR_SHARPEN');
 define( 'IMG_FILTER_INSTGR_EMBOSS', 		'IMG_FILTER_INSTGR_EMBOSS');
 define( 'IMG_FILTER_INSTGR_COOL', 			'IMG_FILTER_INSTGR_COOL');
 define( 'IMG_FILTER_INSTGR_OLD', 			'IMG_FILTER_INSTGR_OLD');
 define( 'IMG_FILTER_INSTGR_OLD2', 			'IMG_FILTER_INSTGR_OLD2');
 define( 'IMG_FILTER_INSTGR_OLD3', 			'IMG_FILTER_INSTGR_OLD3');
 define( 'IMG_FILTER_INSTGR_LIGHT', 		'IMG_FILTER_INSTGR_LIGHT');
 define( 'IMG_FILTER_INSTGR_AQUA', 			'IMG_FILTER_INSTGR_AQUA');
 define( 'IMG_FILTER_INSTGR_FUZZY',	 		'IMG_FILTER_INSTGR_FUZZY');
 define( 'IMG_FILTER_INSTGR_BOOST', 		'IMG_FILTER_INSTGR_BOOST');
 define( 'IMG_FILTER_INSTGR_BOOST2', 		'IMG_FILTER_INSTGR_BOOST2');
 define( 'IMG_FILTER_INSTGR_GRAY',		 	'IMG_FILTER_INSTGR_GRAY');
 define( 'IMG_FILTER_INSTGR_ANTIQUE', 		'IMG_FILTER_INSTGR_ANTIQUE');
 define( 'IMG_FILTER_INSTGR_BLACKWHITE', 	'IMG_FILTER_INSTGR_BLACKWHITE');
 define( 'IMG_FILTER_INSTGR_BLUR', 			'IMG_FILTER_INSTGR_BLUR');
 define( 'IMG_FILTER_INSTGR_VINTAGE', 		'IMG_FILTER_INSTGR_VINTAGE');
 define( 'IMG_FILTER_INSTGR_CONCENTRATE', 	'IMG_FILTER_INSTGR_CONCENTRATE');
 define( 'IMG_FILTER_INSTGR_HERMAJESTY', 	'IMG_FILTER_INSTGR_HERMAJESTY');
 define( 'IMG_FILTER_INSTGR_FRESHBLUE', 	'IMG_FILTER_INSTGR_FRESHBLUE');
 define( 'IMG_FILTER_INSTGR_TENDER', 		'IMG_FILTER_INSTGR_TENDER');
 define( 'IMG_FILTER_INSTGR_DREAM', 		'IMG_FILTER_INSTGR_DREAM');
 define( 'IMG_FILTER_INSTGR_FROZEN', 		'IMG_FILTER_INSTGR_FROZEN');
 define( 'IMG_FILTER_INSTGR_FOREST', 		'IMG_FILTER_INSTGR_FOREST');
 define( 'IMG_FILTER_INSTGR_RAIN', 			'IMG_FILTER_INSTGR_RAIN');
 define( 'IMG_FILTER_INSTGR_ORANGEPEEL', 	'IMG_FILTER_INSTGR_ORANGEPEEL');
 define( 'IMG_FILTER_INSTGR_DARKEN',	 	'IMG_FILTER_INSTGR_DARKEN');
 define( 'IMG_FILTER_INSTGR_SUMMER', 		'IMG_FILTER_INSTGR_SUMMER');
 define( 'IMG_FILTER_INSTGR_RETRO', 		'IMG_FILTER_INSTGR_RETRO');
 define( 'IMG_FILTER_INSTGR_COUNTRY', 		'IMG_FILTER_INSTGR_COUNTRY');
 define( 'IMG_FILTER_INSTGR_WASHED', 		'IMG_FILTER_INSTGR_WASHED');


class img2img
{

	/**
	 * GD
	 *
	 * @var    image
	 * @access private
	 *
	 **/
	private $gd = null;


	/**
	 * original_file_name
	 *
	 * @var    original_file_name
	 * @access private
	 *
	 **/
	private $original_file_name = null;


	/**
	 * filetype
	 *
	 * @var    filetype
	 * @access private
	 *
	 **/
	private $filetype = null;


	/**
	 * cfg_default
	 *
	 * @var    cfg_default
	 * @access private
	 *
	 **/
	private $cfg_default = [
		'arr_thb_default_sizes' => [ '2048x1152' => [2048, 1152],  '1920x1080' => [1920, 1080], '1366x768' => [1366, 768], '640x480' => [640, 480], '512x384' => [512, 384], '320x240' => [320, 240], '200x150' => [200, 150] ],
		'quality' => 100, // 100 = best (more file size), 0 = poor (less file size)
		'tmpdir' => '/tmp',
		'pdfresolution' => 300, // When open pdf file for capture page as image
		'autodetect_mimetypes' => false, // See notes at file_extension()
		'debug' => true // Set to true to see errors
	];



	public function __construct( $original_file, $pdf_page = 0 ) {
		if( is_string($original_file) ){
			$this->original_file_name = $original_file;
			$this->filetype = $this->file_extension( $original_file );

			$this->load_image_from_file( $original_file, $pdf_page );
		} else {
			$this->set_gd( $original_file );
		}
	} // / __construct



	/**
	 * Load image from GD
	 * 
	 * @param resource $gd
	 */
	public function set_gd( $gd ){
		$this->gd = $gd;
	} // /set_gd()
	
	



	/**
	 *  return GD
	 * 
	 * @RETURN resource $gd
	 */
	public function gd(  ){
		return $this->gd ;
	} // /gd()




	/**
	 * INTERPOLATE IMAGE
	 * 
	 * @param constant $method
	 */
	public function imagesetinterpolation( $method ){
		imagesetinterpolation( $this->gd, $method );
	} // /imagesetinterpolation()





	/**
	 * SCALE IMAGE. USE INTERPOLATION
	 * 
	 * @param int $new_width
	 * @param int $new_height
	 * @param int $mode
	 */
	public function imagescale( $new_width, $new_height, $mode = IMG_BILINEAR_FIXED ){
		$new_img =  imagescale( $this->gd,  $new_width, $new_height, $mode );
		if( $new_img ){
			$this->gd = $new_img;
		}
	} // /imagescale()


	/**
	 * Load image from file
	 * 
	 * @param string $filename
	 */
	private function load_image_from_file( $filename, $pdf_page = 0 ){
		$this->gd = null;

		// try to load with standard method
		if( $this->filetype != 'pdf' ){
			$this->load_image_from_file_not_pdf( $filename );
		}

		// if error, try with extension
		if( !$this->gd ){ 
			switch( $this->filetype ){
				case 'xpm': 	if( function_exists( 'imagecreatefromxpm' ) ) 	$this->gd = @imagecreatefromxpm( $filename );
								break;

				case 'xbm': 	if( function_exists( 'imagecreatefromxbm' ) ) 	$this->gd = @imagecreatefromxbm( $filename );
								break;

				case 'webp': 	if( function_exists( 'imagecreatefromwebp' ) ) 	$this->gd = @imagecreatefromwebp( $filename );
								break;

				case 'gd': 		if( function_exists( 'imagecreatefromgd' ) ) 	$this->gd = @imagecreatefromgd( $filename );
								break;

				case 'gd2': 	if( function_exists( 'imagecreatefromgd2' ) )	$this->gd = @imagecreatefromgd2( $filename );
								break;

				case 'bmp': 	if( function_exists( 'imagecreatefrombmp' ) )	$this->gd = @imagecreatefrombmp( $filename );
								break;

				case 'png': 	if( function_exists( 'imagecreatefrompng' ) )	$this->gd = @imagecreatefrompng( $filename );
								break;

				case 'gif': 	if( function_exists( 'imagecreatefromgif' ) )	$this->gd = @imagecreatefromgif( $filename );
								break;

				case 'jpeg':
				case 'jpg': 	if( function_exists( 'imagecreatefromjpeg' ) )	$this->gd = @imagecreatefromjpeg( $filename );
								break;
								
				case 'pdf':		if( class_exists( 'Imagick' ) ){
									try {
										$pathnewfile = $this->cfg_default['tmpdir'].'/img2img_'.$this->filetype.'_'.time().'.jpg';

										$myurl = $filename.'['.$pdf_page.']'; // For first page, $pdf_page will be 0
										$imagepdf = new Imagick();
										$imagepdf->setResolution( $this->cfg_default[ 'pdfresolution' ] , $this->cfg_default[ 'pdfresolution' ] );
										$imagepdf->readImage($myurl);
										$imagepdf->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH); //Declare the units for resolution.
    									$imagepdf->setImageFormat( "jpeg" );
										$imagepdf->setImageColorspace(255);
										$imagepdf->setCompression(Imagick::COMPRESSION_JPEG);
										$imagepdf->setImageCompressionQuality(100);
										$imagepdf->writeImage( $pathnewfile );
				
										$imagepdf->clear();
										$imagepdf->destroy();
										unset( $imagepdf );
				
										if( function_exists( 'imagecreatefromjpeg' ) ){
											$this->gd = @imagecreatefromjpeg( $pathnewfile );
										}

										unlink( $pathnewfile );
										unset( $pathnewfile );
									} catch (ImagickException $e) {
										if( $this->cfg_default[ 'debug' ] ){
											var_dump($e); // Do nothing
										}
									} // /try catch
								} // /if exists Imagick
								break;

				default:		// For other types as tiff, psd, icon, ... Use standard Imagick method
								if( class_exists( 'Imagick' ) ){
									try {
										$pathnewfile = $this->cfg_default['tmpdir'].'/img2img_'.$this->filetype.'_'.time().'.jpg';
										
										$imageImagick = new Imagick( $filename );
										$imageImagick->setImageFormat( 'jpg' );
										$imageImagick->writeImage( $pathnewfile );
				
										$imageImagick->clear( );
										$imageImagick->destroy();
										unset( $imageImagick );
										
										if( function_exists( 'imagecreatefromjpeg' ) ){
											$this->gd = @imagecreatefromjpeg( $pathnewfile );
										}

										unlink( $pathnewfile );
										unset( $pathnewfile );
									} catch ( ImagickException $e ) {
										if( $this->cfg_default[ 'debug' ] ){
											var_dump($e); // Do nothing
										}
									} // /try catch
								} // /if exists Imagick
								break;
				} // /switch $this->filetype
		} // if !gd
		
		imagesavealpha($this->gd, true); // set flag alpha to true
	}// /load_image_from_file()



	/**
	 * Load image that NOT IS PDF from file
	 * 
	 * @param string $filename
	 */
	private function load_image_from_file_not_pdf( $filename ){
		$imageString 	= file_get_contents($filename, true);
		$this->gd 		= @imagecreatefromstring($imageString); // see https://www.php.net/manual/en/function.imagecreatefromstring.php
		imagesavealpha($this->gd, true);
		unset( $imageString );
	}// /load_image_from_file_not_pdf()


	/**
	 * Resample image with thumbnail sizes
	 * ex.:  thumb( '640x480' ); | thumb( 3 );
	 * 
	 * @param string $thumb
	 * @return resource $gd_resample
	 */
	public function thumb( $thumb, $preserve_aspect_ratio= true ){
		if( is_integer($thumb) ){
			$i = 0;
			foreach( $this->cfg_default['arr_thb_default_sizes'] as $key => $sizes ){
				if($i++ == $thumb ){
					$this->thumb( $key );
					break;
				}
			}
			unset( $i );
		} else {
			$sizes = explode('x', $thumb );

			$this->resample( $sizes[0], $sizes[1] );
		}
	} // /thumb()



	/**
	 * Resample image
	 * 
	 * @param integer $x
	 * @param integer $y
	 * @return resource $gd_resampled
	 */
	public function resample( $x, $y, $preserve_aspect_ratio= true ){
		if($preserve_aspect_ratio){
			$ratio_orig = imagesx($this->gd)/imagesy($this->gd);

			if ($x/$y > $ratio_orig) {
			$x = $y*$ratio_orig;
			} else {
			$y = $x/$ratio_orig;
			}
		} // /preserve aspect ratio

		$gd_resample = imagecreatetruecolor( $x, $y );

		imagecopyresampled($gd_resample, $this->gd, 0, 0, 0, 0, $x, $y, imagesx($this->gd), imagesy($this->gd));
		
		$this->gd = $gd_resample;
	} // /_resample()



	/**
	 * Get file type
	 * 
	 * @param string $filename
	 * @return string $filetype
	 */
	private function file_extension( $filename ){
		$filetype = '';


		// USE MIME_TYPES AT YOUR RISK IF YOU WANT TO 'AUTODISCOVER' FILE TYPE.
		
		
		if( $this->cfg_default['autodetect_mimetypes'] ){

			// Methods 1 through 5 use the file structure to resolve the extension using the mime_type.
			// There are extension problems, such as application / msword, which can give us the extension .doc or .dot


			// mime_types LISTS
			// http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
			// http://www.iana.org/assignments/media-types/media-types.xhtml


			global $mime_types;  // Defined at mime_types.php

			// IMAGE file type extensions with the PHP constants used by the function exif_imagetype:

			$extensions = array(
				IMAGETYPE_GIF => 'gif',
				IMAGETYPE_JPEG => 'jpg',
				IMAGETYPE_PNG => 'png',
				IMAGETYPE_SWF => 'swf',
				IMAGETYPE_PSD => 'psd',
				IMAGETYPE_BMP => 'bmp',
				IMAGETYPE_TIFF_II => 'tiff',
				IMAGETYPE_TIFF_MM => 'tiff',
				IMAGETYPE_JPC => 'jpc',
				IMAGETYPE_JP2 => 'jp2',
				IMAGETYPE_JPX => 'jpx',
				IMAGETYPE_JB2 => 'jb2',
				IMAGETYPE_SWC => 'swc',
				IMAGETYPE_IFF => 'iff',
				IMAGETYPE_WBMP => 'wbmp',
				IMAGETYPE_XBM => 'xbm',
				IMAGETYPE_ICO => 'ico'
				//,IMAGETYPE_WEBP => 'webp'  // ONLY PHP VERSION >= PHP7.1.0
				);



			// METHOD 1: Through the mime_content_type function
			$mime = mime_content_type( $filename ); // This is where we collect the MIME information from the file

			// We look for the string in the mime_types array

			$found = array_search( $mime, array_map( 'strval', array_keys( $mime_types ) ) );

			if($found !== false){
				$filetype = $mime_types[ $mime ];
			}
			

			unset( $mime );
			unset( $found );
			// /METHOD 1







			// METHOD 2: Through the getimagesize function that can return the MIME information
			
			if($filetype == ""){
				
				$size = getimagesize( $filename );
				$mime = $size[ 'mime' ]; // This is where we collect the MIME information from the file

				// We look for the string in the mime_types array

				$found = array_search( $mime, array_map( 'strval', array_keys( $mime_types ) ) );

				if($found !== false){
					$filetype = $mime_types[$mime];
				}

				unset( $size );
				unset( $mime );
				unset( $found );
			} // /METHOD 2






			// METHOD 3: Through the finfo_file function

			if($filetype == ""){  

				$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type to mimetype extension

				$mime = @finfo_file( $finfo, $filename );
				if ( ($mime !== FALSE ) && is_string( $mime ) && ( strlen( $mime ) > 0 ) ) {
					$filetype = $mime_types[$mime];
				}

				@finfo_close($finfo);

				unset( $finfo );
				unset( $mime );
			} // /METHOD 3







			// METHOD 4: Through the EXIF information contained within the images

			if($filetype == ""){  

				$ExifImageType = exif_imagetype($filename);

				if($ExifImageType != 0){
					$filetype = $extensions[$ExifImageType];
				} else {
					$filetype = "";
				}
			} // /METHOD 4
		} // /if use mime_types


		// If we do not have the extension, as a last resort, we will return the same extension that we have in the original file
		if( $filetype == '' ){
			$parts 		= pathinfo( $filename );
			$filetype 	= strtolower( $parts['extension'] );

			unset( $parts );
		}

		return $filetype;
	}// /file_extension()



	/**
	 *  Method to know from a file extension, if it belongs to an image or not
	 *  Returns TRUE if the extension belongs to an image, otherwise it will return false
	 * 
	 * @param string $extension
	 */
	private function is_image_from_extension( $extension ){
		switch($extension){
			case 'jpg':
			case 'jpe':
			case 'jpeg':
			case 'bmp':
			case 'gif':
			case 'png':
			case 'tif':
			case 'tiff':
			case 'gd':
			case 'gd2':
			case 'wbmp':
			case 'psd':
			case 'webp':
			case 'xbm':
			case 'psd':
			case 'ico':
			case 'icon':
			case 'xpm':		return ( true );
							break;

			default:		return ( false );
							break;
			}
	} // /is_image_from_extension()



	/**
	 * Return if file can have a preview
	 * 
	 * With is_image_from_extension() method you can to know if a file is image,
	 * but sometimes is not a image but you can to load id and do a preview, as .pdf files
	 * For now this method only supports 'pdf'
	 * 
	 * @param string $extension
	 */
	private function preview_available( $extension ){
		return ( $extension == 'pdf' );
	} // /preview_available()
	
	

    /**
     * Transform Hex to rgb
     * 
     * @param array $hex_color
     * @return array [$r, $g, $b]
     */
    private function hex2rgb( $hex_color ){
        list($r, $g, $b) = array_map(
            function ($c) {
            return hexdec(str_pad($c, 2, $c));
            },
            str_split(ltrim($hex_color, '#'), strlen($hex_color) > 4 ? 2 : 1)
        );

        return [$r, $g, $b];
    } // /hex2rgb()



	/**
	 * Save to format file file
	 * @param string $filename
	 */
	public function save( $filename, $cfg = null ){
		$type = '';
		if( !is_null( $cfg) ){
			if( isset( $cfg['type']) )
			$type = $cfg['type'];
		}

		if( $type == '' ){
			// Try to extrat file type from file extension
			$type = $this->file_extension( $filename );
		}

		if( $type == '' ){
			echo 'Error. Cannot detect file type for save(). Exiting';
			exit(1);
		}

		$quality = '';
		if( !is_null( $cfg) ){
			if( isset( $cfg['quality']) )
			$quality = $cfg['quality'];
		}

		if( $quality == '' ){
			$quality = 80; // default quality
		}

		$compressed = '';
		if( !is_null( $cfg) ){
			if( isset( $cfg['compressed']) )
			$compressed = $cfg['compressed'];
		}

		if( $compressed == '' ){
			$compressed = true;
		}

		$chunk_size = '';
		if( !is_null( $cfg) ){
			if( isset( $cfg['chunk_size']) )
			$chunk_size = $cfg['chunk_size'];
		}

		if( $chunk_size == '' ){
			$chunk_size = 128;
		}

		// IMG_GD2_RAW or IMG_GD2_COMPRESSED
		$gd2_type = '';
		if( !is_null( $cfg) ){
			if( isset( $cfg['gd2_type']) )
			$gd2_type = $cfg['gd2_type'];
		}

		if( $gd2_type == '' ){
			$gd2_type = IMG_GD2_RAW;
		}

		$foreground = '';
		if( !is_null( $cfg) ){
			if( isset( $cfg['foreground']) )
			$foreground = $cfg['foreground'];
		}

		if( $foreground == '' ){
			$foreground = '#000000'; 
		}
		$foreground = $this->hex2rgb('foreground');

		switch( $type ){
			case 'png':		imagepng( $this->gd, $filename );
							break;

			case 'webp':	imagewebp( $this->gd, $filename, $quality );
							break;

			case 'avif':	imageavif( $this->gd, $filename, $quality );
							break;

			case 'bmp':		imagebmp( $this->gd, $filename, $compressed );
							break;

			case 'gd2':		imagegd2( $this->gd, $filename, $chunk_size, $gd2_type );
							break;

			case 'gd':		imagegd( $this->gd, $filename ); // look at http://www.libgd.org/GdFileFormats
							break;

			case 'gif':		imagegif( $this->gd, $filename );
							break;

			case 'jpg':	
			case 'jpeg':	imagejpeg( $this->gd, $filename, $quality );
							break;
							
			case 'wbmp':	imagewbmp( $this->gd, $filename, $foreground );
							break;
							
			case 'xbm':		imagexbm( $this->gd, $filename, $foreground );
							break;

			default:		// Try to save with Imagick
							if( class_exists( 'Imagick' ) ){
								try {
									$filenametmp = '/tmp/img2img.class.'.time().'.jpg';
		
									imagejpeg( $this->gd, $filenametmp, 100 );

									$imageImagick = new Imagick( $filenametmp );

									unlink( $filenametmp );
        							unset( $filenametmp );

									$imageImagick->setImageFormat( $type );
									$imageImagick->writeImage( $filename );

									$imageImagick->clear( );
									$imageImagick->destroy();
									unset( $imageImagick );
								} catch ( ImagickException $e ) {
									if( $this->cfg_default[ 'debug' ] ){
										var_dump($e); // Do nothing
									}
								} // /try catch
							}
		}
		
		unset( $type );
		unset( $quality );
		unset( $compressed );
		unset( $chunk_size );
		unset( $gd2_type );
		unset( $foreground );
		unset( $type );
	} // /save()

	

    /**
     * return a $format stream of image base64
	 * 
	 * See method save for available formats
     * 
     * @param string $format
     * @return string $base64_stream
     */
	public function base64( $format ){
		return  base64_encode( $this->raw( $format ) );
	} // /base64()
	


    /**
     * return a stream of image raw
     * 
     * @param string $format
     * @return string $jpg_stream
     */
	public function raw( $format ){
		$filename = '/tmp/img2img.class.'.time().'.'.$format;

		$this->save( $filename );
		
		$fp = fopen($filename, "rb");
		$content = fread($fp, filesize($filename));
		fclose($fp);
		
		unlink( $filename );
        
        unset( $fp );
        unset( $filename );
		
		return $content;
	} // /raw()

	

    /**
     * 
	 * Flip GD image
	 * 
	 * IMG_FLIP_HORIZONTAL | IMG_FLIP_VERTICAL | IMG_FLIP_BOTH
     * 
     * @param integer $type
     */
	public function flip( $type = IMG_FLIP_HORIZONTAL ){
		imageflip( $this->gd, $type );
	} // /gd_base64()

	

    /**
     * 
	 * Mirror GD image
	 * 
     */
	public function mirror( ){
		$this->flip( );
	} // /mirror()

	

    /**
     * 
	 * Apply filter to GD image
	 * 
	 * See https://www.php.net/manual/en/function.imagefilter.php
	 * 
	 * filter can be one of the following:
	 * 
	 * IMG_FILTER_NEGATE: Reverses all colors of the image.
	 * IMG_FILTER_GRAYSCALE: Converts the image into grayscale by changing the red, green and blue components to their weighted sum using the same coefficients as the REC.601 luma (Y') calculation. The alpha components are retained. For palette images the result may differ due to palette limitations.
	 * IMG_FILTER_BRIGHTNESS: Changes the brightness of the image. Use args to set the level of brightness. The range for the brightness is -255 to 255.
	 * IMG_FILTER_CONTRAST: Changes the contrast of the image. Use args to set the level of contrast. -100 = max contrast, 0 = no change, +100 = min contrast (note the direction!)
	 * IMG_FILTER_COLORIZE: Like IMG_FILTER_GRAYSCALE, except you can specify the color. Use args, arg2 and arg3 in the form of red, green, blue and arg4 for the alpha channel. The range for each color is 0 to 255.
	 * IMG_FILTER_EDGEDETECT: Uses edge detection to highlight the edges in the image.
	 * IMG_FILTER_EMBOSS: Embosses the image.
	 * IMG_FILTER_GAUSSIAN_BLUR: Blurs the image using the Gaussian method.
	 * IMG_FILTER_SELECTIVE_BLUR: Blurs the image.
	 * IMG_FILTER_MEAN_REMOVAL: Uses mean removal to achieve a "sketchy" effect.
	 * IMG_FILTER_SMOOTH: Makes the image smoother. Use args to set the level of smoothness.
	 * IMG_FILTER_PIXELATE: Applies pixelation effect to the image, use args to set the block size and arg2 to set the pixelation effect mode.
	 * IMG_FILTER_SCATTER: Applies scatter effect to the image, use args and arg2 to define the effect strength and additionally arg3 to only apply the on select pixel colors.
	 * IMG_FILTER_SEPIA: Use arg1 to use between different types of sepia and arg2 & arg3 to define de effect
	 * IMG_FILTER_BLACK_WHITE: Use to create a black & white image
	 * IMG_FILTER_VIGNETTE: arg1: blackPoint, arg2: $whitePoint, arg3: $x, arg4: $y
	 * args
	 * IMG_FILTER_BRIGHTNESS: Brightness level.
	 * IMG_FILTER_CONTRAST: Contrast level.
	 * IMG_FILTER_COLORIZE: Value of red component.
	 * IMG_FILTER_SMOOTH: Smoothness level.
	 * IMG_FILTER_PIXELATE: Block size in pixels.
	 * IMG_FILTER_SCATTER: Effect substraction level. This must not be higher or equal to the addition level set with arg2. NOTE: PHP >= PHP7.4.0
	 * IMG_FILTER_SEPIA:	Define type of sepia
	 * arg2
	 * IMG_FILTER_COLORIZE: Value of green component.
	 * IMG_FILTER_PIXELATE: Whether to use advanced pixelation effect or not (defaults to false).
	 * IMG_FILTER_SCATTER: Effect addition level. NOTE: PHP >= PHP7.4.0
	 * IMG_FILTER_SEPIA: if (arg1 == 2) Defines % of sepia. if(arg1 == 4): Define tone of sepia in Imagick sepiaToneImage()
	 * arg3
	 * IMG_FILTER_COLORIZE: Value of blue component.
	 * IMG_FILTER_SCATTER: Optional array indexed color values to apply effect at. NOTE: PHP >= PHP7.4.0
	 * arg4
	 * IMG_FILTER_COLORIZE: Alpha channel, A value between 0 and 127. 0 indicates completely opaque while 127 indicates completely transparent.
     * 
     * @param integer $filtertype
     * @param integer $arg1
     * @param integer $arg2
     * @param integer $arg3
     * @param integer $arg4
     */
	public function filter( $filtertype, $arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null ){
		switch( $filtertype ){
			case IMG_FILTER_BLACK_WHITE:	imagefilter($this->gd, IMG_FILTER_GRAYSCALE);
											imagefilter($this->gd, IMG_FILTER_CONTRAST, -100);
											break;

			case IMG_FILTER_VIGNETTE:		// With Imagick
												
											$filenametmp = '/tmp/img2img.class.'.time().'.jpg';

											imagejpeg( $this->gd, $filenametmp, 100 );

											$imageImagick = new Imagick( $filenametmp );

											unlink( $filenametmp );

											$imageImagick->vignetteImage($arg1, $arg2, $arg3, $arg4); // arg1: blackPoint, arg2: $whitePoint, arg3: $x, arg4: $y
											$imageImagick->setImageFormat( 'jpg' );
											$imageImagick->writeImage( $filenametmp );

											$imageImagick->clear( );
											$imageImagick->destroy();
											unset( $imageImagick );
											
											if( function_exists( 'imagecreatefromjpeg' ) ){
												$this->gd = @imagecreatefromjpeg( $filenametmp );
											}
					
											unlink( $filenametmp );

											unset( $filenametmp );
											break;

			case IMG_FILTER_SEPIA:	switch( $arg1 ){
											case 1:		imagefilter($this->gd, IMG_FILTER_GRAYSCALE); imagefilter($yourimage, IMG_FILTER_COLORIZE, 90, 60, 40);
														break;

											case 2:		$percent = $arg2;
														$sx=imagesx($this->gd);
														$sy=imagesy($this->gd);
														$filter=imagecreatetruecolor($sx,$sy);
														$c=imagecolorallocate($filter,100,50,50);
														imagefilledrectangle($filter,0,0,$sx,$sy,$c);
														imagecopymerge($this->gd,$filter,0,0,0,0,$sx,$sy,$percent);
														break;

											case 3:		imagefilter($this->gd,IMG_FILTER_GRAYSCALE);
														imagefilter($this->gd,IMG_FILTER_BRIGHTNESS,-30);
														imagefilter($this->gd,IMG_FILTER_COLORIZE, 90, 55, 30); 

											case 4:		// With Imagick
												
														$filenametmp = '/tmp/img2img.class.'.time().'.jpg';
		
														imagejpeg( $this->gd, $filenametmp, 100 );
					
														$imageImagick = new Imagick( $filenametmp );
					
														unlink( $filenametmp );
					
														$imageImagick->sepiaToneImage( $arg2 );
														$imageImagick->setImageFormat( 'jpg' );
														$imageImagick->writeImage( $filenametmp );
								
														$imageImagick->clear( );
														$imageImagick->destroy();
														unset( $imageImagick );
														
														if( function_exists( 'imagecreatefromjpeg' ) ){
															$this->gd = @imagecreatefromjpeg( $filenametmp );
														}

														unlink(  $filenametmp );

														unset( $filenametmp );
										}
										break;
			case  IMG_FILTER_INSTGR_BUBBLES:			$filter = (new Filter($this->gd))->bubbles();
 														$this->gd = $filter->getImage();
														unset( $filter );
														break;

			case  IMG_FILTER_INSTGR_COLORISE:			$filter = (new Filter($this->gd))->colorise();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;

			case  IMG_FILTER_INSTGR_SEPIA:				$filter = (new Filter($this->gd))->sepia();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
																	
			case  IMG_FILTER_INSTGR_SEPIA2:				$filter = (new Filter($this->gd))->sepia2();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;

			case  IMG_FILTER_INSTGR_SHARPEN:			$filter = (new Filter($this->gd))->sharpen();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
		
			case  IMG_FILTER_INSTGR_EMBOSS:				$filter = (new Filter($this->gd))->emboss();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_COOL:				$filter = (new Filter($this->gd))->cool();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_OLD:				$filter = (new Filter($this->gd))->old();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_OLD2:				$filter = (new Filter($this->gd))->old2();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_OLD3:				$filter = (new Filter($this->gd))->old3();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_LIGHT:				$filter = (new Filter($this->gd))->light();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case IMG_FILTER_INSTGR_AQUA:				$filter = (new Filter($this->gd))->aqua();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;

			case  IMG_FILTER_INSTGR_FUZZY:				$filter = (new Filter($this->gd))->fuzzy();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_BOOST:				$filter = (new Filter($this->gd))->boost();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_BOOST2:				$filter = (new Filter($this->gd))->boost2();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_GRAY:				$filter = (new Filter($this->gd))->gray();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_ANTIQUE:			$filter = (new Filter($this->gd))->antique();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_BLACKWHITE:			$filter = (new Filter($this->gd))->blackwhite();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;			

			case  IMG_FILTER_INSTGR_BLUR:				$filter = (new Filter($this->gd))->blur();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;			

			case  IMG_FILTER_INSTGR_VINTAGE:			$filter = (new Filter($this->gd))->vintage();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;			

			case  IMG_FILTER_INSTGR_CONCENTRATE:		$filter = (new Filter($this->gd))->concentrate();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;			

			case  IMG_FILTER_INSTGR_HERMAJESTY:			$filter = (new Filter($this->gd))->hemajesty();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
														
			case  IMG_FILTER_INSTGR_FRESHBLUE:			$filter = (new Filter($this->gd))->freshblue();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_TENDER:				$filter = (new Filter($this->gd))->tender();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_DREAM:				$filter = (new Filter($this->gd))->dream();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_FROZEN:				$filter = (new Filter($this->gd))->frozen();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_FOREST:				$filter = (new Filter($this->gd))->forest();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_RAIN:				$filter = (new Filter($this->gd))->rain();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_ORANGEPEEL:			$filter = (new Filter($this->gd))->orangepeel();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_DARKEN:				$filter = (new Filter($this->gd))->darken();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_SUMMER:				$filter = (new Filter($this->gd))->summer();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_RETRO:				$filter = (new Filter($this->gd))->retro();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_COUNTRY:			$filter = (new Filter($this->gd))->country();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			
			case  IMG_FILTER_INSTGR_WASHED:				$filter = (new Filter($this->gd))->washed();
														$this->gd = $filter->getImage();
														unset( $filter );
														break;
			

			default:				if( $filtertype == IMG_FILTER_COLORIZE ){
										imagefilter( $this->gd, $filtertype, $arg1, $arg2, $arg3, $arg4 );
									} else if( version_compare(PHP_VERSION, '7.4.0', '>=') && $filtertype == IMG_FILTER_SCATTER ){
										imagefilter( $this->gd, $filtertype, $arg1, $arg2, $arg3 );
									} else if( $filtertype == IMG_FILTER_PIXELATE ){
										imagefilter( $this->gd, $filtertype, $arg1, $arg2 );
									} else if( in_array( $filtertype, [ IMG_FILTER_BRIGHTNESS, IMG_FILTER_CONTRAST, IMG_FILTER_COLORIZE, IMG_FILTER_SMOOTH ] ) ){
										imagefilter( $this->gd, $filtertype, $arg1 );									
									} else{
										imagefilter( $this->gd, $filtertype );									
									}
									break;
		} // /Switch / Case $type
	} // /filter()	

} // /img2img class
?>