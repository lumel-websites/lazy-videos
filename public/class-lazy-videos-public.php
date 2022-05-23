<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://lumel.com
 * @since      1.0.0
 *
 * @package    Lazy_Videos
 * @subpackage Lazy_Videos/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Lazy_Videos
 * @subpackage Lazy_Videos/public
 * @author     KG <kg@lumel.com>
 */
class Lazy_Videos_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lazy_Videos_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lazy_Videos_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lazy-videos-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lazy_Videos_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lazy_Videos_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lazy-videos-public.js', array( 'jquery' ), $this->version, true );

	}

	/**
	 * Lazy videos shortcode defination
	 *
	 * @since    1.0.0
	 */
	public function add_lazy_videos_shortcode() { 

		add_shortcode( 'lazy_videos' , array( $this , 'lazy_videos_shortcode_callback' ) );

	}

	/**
	 * Lazy videos shortcode callback
	 *
	 * @since    1.0.0
	 */
	public function lazy_videos_shortcode_callback( $atts ) { 

		$atts = shortcode_atts(
			array(
				'mode' => 'inline',
				'provider' => 'youtube',
				'url' => '',
				'poster' => '',
				'lazy_loading' => 'true'
	        ) , 
	     	$atts , 
	     	'lazy_videos' 
	    );

		$mode 		= $atts[ 'mode' ];	
		$provider 	= $atts[ 'provider' ];
		$url 		= $atts[ 'url' ];
		$poster 	= $atts[ 'poster' ];
		$loading	= $atts[ 'lazy_loading' ];

		if( $url == "" ) {

			$output = '<p style="color:red;">[url] - Video URL is a required parameter';
			return $output;

		}

		if( $provider == "youtube" && $poster == "" ) {

			$video_code = explode( "=", $url )[1];
			$poster = "https://i.ytimg.com/vi/$video_code/maxresdefault.jpg";

		}

		if( $provider == "wistia" && $poster == "" ) {

			$response = wp_remote_get( "https://fast.wistia.net/oembed?url=$url&&embedType=async" );
			$response = json_decode( $response[ 'body' ], true );

			$poster = $response[ 'thumbnail_url' ];

		}

		if( $provider == "vimeo" && $poster == "" ) {

			$video_url = explode( "/", $url );
			$video_code =  end($video_url);
			$poster = "https://vumbnail.com/$video_code.jpg";

		}
		ob_start();

		?>

		<div class="lazy-video-container" data-mode="<?php echo $mode; ?>" data-provider="<?php echo $provider; ?>" data-url="<?php echo $url; ?>">
			<div class="lazy-video-box">
				<div class="lazy-video-wrapper" style="padding-top:56.2963%"></div>
			</div>
			<div class="lazy-overlay">
				<img class="lazy-overlay-image" src="<?php echo $poster; ?>" width="100%" <?php echo ( $loading == "true" ) ? 'loading="lazy"' : '';  ?> />
				<div class="lazy-overlay-hover"></div>	
				<div class="lazy-play-icon"></div>
			</div>	
		</div>

		<?php

		$output = ob_get_clean();
		return $output;

	}

}
