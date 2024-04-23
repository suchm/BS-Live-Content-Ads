<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://michaelsuch.co.uk/
 * @since      1.0.0
 *
 * @package    Blueshift_Live_Content
 * @subpackage Blueshift_Live_Content/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Blueshift_Live_Content
 * @subpackage Blueshift_Live_Content/public
 * @author     Mike Such <mikesuchyo@yahoo.com>
 */
class Blueshift_Live_Content_Public {

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
		 * defined in Blueshift_Live_Content_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blueshift_Live_Content_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/blueshift-live-content-public.css', array(), $this->version, 'all' );
		wp_register_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', array(), '5.5.0', 'all' );
		wp_enqueue_style( 'font-awesome' );

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
		 * defined in Blueshift_Live_Content_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blueshift_Live_Content_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/blueshift-live-content-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'lc_ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}

	/**
	 * Add the live content scripts
	 *
	 * @since    1.0.0
	 */
	public function live_content_scripts() {
	?>
		<script>
			var prefix = "<?php echo BSFT_PREFIX; ?>";
			var id = "<?php echo get_the_ID(); ?>";
			window._blueshiftid = "<?php echo BSFT_EVENT_API_KEY; ?>";
			window.blueshift = window.blueshift || [];
			if (blueshift.constructor === Array) {
				blueshift.load = function() {
					var d = function(a) {
							return function() {
								blueshift.push([a].concat(Array.prototype.slice.call(arguments, 0)))
							}
						},
						e = ["identify", "track", "click", "pageload", "capture", "retarget", "live"];
					for (var f = 0; f < e.length; f++) blueshift[e[f]] = d(e[f])
				};
			}
			blueshift.load();
			blueshift.pageload();
			blueshift.track("view", {
				product_id: prefix + id,
			});
			if (blueshift.constructor === Array) {
				(function() {
					var b = document.createElement("script");
					b.type = "text/javascript", b.async = !0,
						b.src = ("https:" === document.location.protocol ? "https:" : "http:") + "//cdn.getblueshift.com/blueshift.js";
					var c = document.getElementsByTagName("script")[0];
					c.parentNode.insertBefore(b, c);
				})()
			}
		</script>
	<?php
	}

	public function ajax_live_content() 
    {
    	$content = '';
        $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
        $type    = isset($_POST['type']) ? $_POST['type'] : '';

        if (!empty($post_id) && !empty($type)) {

        	if($type === 'preview'){
        		$lc_post = get_post($post_id);
				$content = $lc_post->post_content;
				$content = apply_filters('the_content', $content);

        	} else {

	            $slot     = get_post_meta( $post_id, 'live_content_slot', true );
				$template = get_post_meta( $post_id, 'live_content_template', true ); 

				if(isset($_COOKIE['_bs'])) {
					$cookie = $_COOKIE['_bs'];
				} else {
					$cookie = NULL;
				}

				$response = $this->bsft_lc_api_call($cookie, $slot);
				$repsonse_template = $response->content->template;
				$this->impressions = $response->tracking->impression_url;
				$this->unique_click = $response->tracking->click_url;

				if ( isset($repsonse_template) && $repsonse_template === $template ) {
					$expiry_date   = get_post_meta( $post_id, 'live_content_expiry', true );
					$lc_cookie_key = 'bsft_lc_' . $post_id;
					if ( $expiry_date && ! empty( $expiry_date ) ) {
						$expiry_date = strtotime( str_replace( '/', '-', $expiry_date ) );
					} else {
						$expiry_date = time()+(3600*90); // Expire in 6 months
					}
					// set cookie if popup
					if ( isset($_POST['position']) && $_POST['position'] === 'popup' ) {
						setcookie($lc_cookie_key, '1', $expiry_date, '/'); // empty value and old timestamp
					}

					$lc_post = get_post($post_id);
					$this->get_url_data($this->impressions);
					$content = $lc_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = $this->add_blueshift_link_tracking($content);
				}
			}
        }
        echo $content;
        die();
    }

	public function live_content_slot() {

		$args = [
            'post_type' => 'bsft_live_content',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) : $query->the_post();
				$post_id       = get_the_ID();
				$lc_post       = get_post($post_id);
				$expiry_date   = get_post_meta( $post_id, 'live_content_expiry', true );
				$position      = get_post_meta( $post_id, 'live_content_position', true );
				$lc_cookie_key = 'bsft_lc_' . $post_id;

				if ( $expiry_date && ! empty( $expiry_date ) ) {
					$current_date = time();
					$expiry_date = strtotime( str_replace( '/', '-', $expiry_date ) );
					// If past expiry date skip to next post
					if ( $expiry_date <= $current_date ) {
						if ( isset($_COOKIE[$lc_cookie_key])) {
							unset($_COOKIE[$lc_cookie_key]);
    						setcookie($lc_cookie_key, '', time() - 3600, '/'); // empty value and old timestamp
						}
					 	continue;
					}
				}

				// If cookie is set skip to the next post
				if ( isset($_COOKIE[$lc_cookie_key]) && strpos($position, 'Popup') !== false ) {
					continue;
				}

				$show_live_content = true;
				$show_live_content = apply_filters( 'display_live_content_check', $show_live_content, $lc_post );

				// Skip if live content criteria is not met
				if ( $show_live_content === false ) {
					continue;
				}

				$lc_post = get_post($post_id);
				$this->apply_position($lc_post, $position);

			endwhile;
		}
		wp_reset_query();
	}

	public function live_content_preview() {
		$post_id = isset($_GET['live_content_preview']) ? $_GET['live_content_preview'] : false;
		if ( $post_id === false ) {
			return;
		}
		$lc_post = get_post($post_id);
		if ( $lc_post->post_status !== 'draft' ) {
			return;
		}
		$postion = get_post_meta( $post_id, 'live_content_position', true );  
		$this->apply_position($lc_post, $postion);
	}

	private function apply_position($lc_post, $postion) {
		switch ($postion) {
				case 'Popup - Fade in':
				$this->add_live_content_popup($lc_post, 'fade-in');
				break;

			case 'Popup - Slide down':
				$this->add_live_content_popup($lc_post, 'slide-down');
				break;

			case 'Popup - Slide up':
				$this->add_live_content_popup($lc_post, 'slide-up');
				break;

			case 'Sidebar - Top':
				$this->add_live_content_sidebar_action($lc_post, 'blueshift_live_content_sidebar_top');
				break;

			case 'Sidebar - Bottom':
				$this->add_live_content_sidebar_action($lc_post, 'blueshift_live_content_sidebar_bottom');
				break;
			
			default:
				# code...
				break;
		}
	}

	private function add_live_content_popup($lc_post, $action) {
		$preview = isset( $_GET['live_content_preview'] ) && $_GET['live_content_preview'] == $lc_post->ID && $lc_post->post_status === 'draft' ? '-preview' : '';
		?>
		<div id="lc-<?php echo $lc_post->ID; ?>" class="lc-popup<?php echo $preview; ?> lc-popup-<?php echo $action; ?>" data-position="popup" data-action="<?php echo $action; ?>" data-postid="<?php echo $lc_post->ID; ?>">
			<div class="lc-inner">
				<div class="lc-content-wrap lc-display">
					<div class="exit"><i class="far fa-times-circle"></i></div>
				</div>
			</div>
		</div>
		<?php 
	}

	private function add_live_content_sidebar_action($lc_post, $action) {
		add_action( $action, function() use ($lc_post){
			$preview = isset( $_GET['live_content_preview'] ) && $_GET['live_content_preview'] == $lc_post->ID && $lc_post->post_status === 'draft' ? '-preview' : '';
			?>
			<div id="lc-<?php echo $lc_post->ID ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 lc-sidebar<?php echo $preview; ?> lc-display" data-position="sidebar" data-action="fade-in" data-postid="<?php echo $lc_post->ID; ?>"></div>
			<?php
		});
	}

	/*** Add Blueshift Tracking code to links ***/
	private function add_blueshift_link_tracking($content) {
		// Go through each link and add single sign-on functionality
		if ( isset( $this->unique_click ) && ! empty( $this->unique_click ) && $this->unique_click !== false ) {
        	preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $content, $results);
	        if (!empty($results)) {
	            foreach ($results['href'] as $result) {
	        		$tracked_url = $this->unique_click . '&redir=' . $result;
	                $content = str_replace('href="' . $result . '"', 'href="' . $tracked_url . '"', $content);
	            }
	        }
	    }
	    return $content;
	}

	/*** Ask Blueshift for user ***/
	private function bsft_lc_api_call($cookie, $slot) {

		$key = base64_encode(BSFT_USER_API_KEY);
		$url = 'https://api.getblueshift.com/live';

		$body = array(
			'user' => array(
				'cookie' => $cookie,
			),
			'slot' => $slot,
			'api_key' => BSFT_EVENT_API_KEY
		);

		$body = apply_filters('live_content_api_call_body', $body); 
		
		$headers = array(
			'Authorization' => 'Basic '.$key,
			'Content-type' => 'application/json',
			'Accept' => 'application/json'
		);

		$args = array(
			'headers' => $headers,
			'body' => json_encode($body),
			'method' => 'POST',
		);
		
		$remote_response = wp_remote_post($url, $args);
		if (is_wp_error($remote_response)) {
			return false;
		}
		$response = json_decode($remote_response['body']);

		return $response;
	}

	private function get_url_data($url) {
	    $ch = curl_init();
	    $timeout = 5;
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
	    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	    $data = curl_exec($ch);
	    curl_close($ch);
	    return $data;
	}

}
