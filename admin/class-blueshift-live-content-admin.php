<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://michaelsuch.co.uk/
 * @since      1.0.0
 *
 * @package    Blueshift_Live_Content
 * @subpackage Blueshift_Live_Content/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Blueshift_Live_Content
 * @subpackage Blueshift_Live_Content/admin
 * @author     Mike Such <mikesuchyo@yahoo.com>
 */
class Blueshift_Live_Content_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/blueshift-live-content-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-ui-datepicker', plugin_dir_url( __FILE__ ) . 'admin/lib/jquery-ui-datepicker/jquery-ui.min.css', false, '1.12.1', false );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/blueshift-live-content-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-datepicker', plugin_dir_url( __FILE__ ) . 'admin/lib/jquery-ui-datepicker/jquery-ui.min.js', array('jquery'), '1.12.1', false );

	}

	public function register_custom_post_types(){
		// Set other options for Custom Post Type

		$labels = array(
			'name'                  => _x( 'Live Content', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Live Content', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Live Content', 'text_domain' ),
			'name_admin_bar'        => __( 'Live Content', 'text_domain' ),
			'archives'              => __( 'Live Content Archives', 'text_domain' ),
			'attributes'            => __( 'Live Content Attributes', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Live Content:', 'text_domain' ),
			'all_items'             => __( 'All Live Content', 'text_domain' ),
			'add_new_item'          => __( 'Add New Live Content', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Live Content', 'text_domain' ),
			'edit_item'             => __( 'Edit Live Content', 'text_domain' ),
			'update_item'           => __( 'Update Live Content', 'text_domain' ),
			'view_item'             => __( 'View Live Content', 'text_domain' ),
			'view_items'            => __( 'View Live Content', 'text_domain' ),
			'search_items'          => __( 'Search Live Content', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Featured Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Live Content', 'text_domain' ),
			'items_list'            => __( 'Live Content list', 'text_domain' ),
			'items_list_navigation' => __( 'Live Content list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter Live Content list', 'text_domain' ),
		);
		$args   = array(
			'label'               => __( 'Live Content', 'text_domain' ),
			'description'         => __( 'Content display using Live Content', 'text_domain' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
			'taxonomies'          => array( 'segment', 'location' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => false,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'show_in_rest'        => true,
		);

		register_post_type( 'bsft_live_content', $args );

	}

	public function save_live_content( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		if ( empty( $_POST['bsft_live_content'] ) || ! wp_verify_nonce( $_POST['bsft_live_content'], 'save_bsft_live_content' ) ) {
			return false;
		}

		$live_content_expiry   = isset( $_POST['live_content_expiry'] ) ? $_POST['live_content_expiry'] : '';
		$live_content_slot     = isset( $_POST['live_content_slot'] ) ? $_POST['live_content_slot'] : '';
		$live_content_template = isset( $_POST['live_content_template'] ) ? $_POST['live_content_template'] : '';
		$live_content_position = isset( $_POST['live_content_position'] ) ? $_POST['live_content_position'] : '';

		update_post_meta( $post_id, 'live_content_expiry', $live_content_expiry );
		update_post_meta( $post_id, 'live_content_slot', $live_content_slot );
		update_post_meta( $post_id, 'live_content_template', $live_content_template );
		update_post_meta( $post_id, 'live_content_position', $live_content_position );

		do_action( 'save_live_content_meta', $post_id );
	}

	public function add_metabox( $post_type ) {
		if ( "bsft_live_content" === $post_type ) {

			add_meta_box( 
				'bsft-live-content-meta-box', 
				__( 'Live Content', 'textdomain' ), 
				array( $this, 'render_metabox' ),
				$post_type, 
				'normal', 
				'high' 
			);
		}
	}

	public function render_metabox( $meta_id ) {

		$live_content_expiry   = get_post_meta( $meta_id->ID, 'live_content_expiry', true );
		$live_content_slot     = get_post_meta( $meta_id->ID, 'live_content_slot', true );
		$live_content_template = get_post_meta( $meta_id->ID, 'live_content_template', true );
		$live_content_position = get_post_meta( $meta_id->ID, 'live_content_position', true );
		?>
			<div id="live-content">
				<p><label for="live_content_expiry">Expiry Date (DD/MM/YYYY):</label><br>
				<input class="liveContentExpiry" type="text" name="live_content_expiry" value="<?php echo $live_content_expiry; ?>" autocomplete="off"></p>

				<p><label for="live_content_slot">Slot: </label><br>
				<input type="text" name="live_content_slot" value="<?php echo $live_content_slot; ?>"></p>

				<p><label for="live_content_template">Template: </label><br>
				<input type="text" name="live_content_template" value="<?php echo $live_content_template; ?>"></p>

				<p><label for="live_content_position">Position: </label><br>
				<select name="live_content_position">
					<?php
					$positions = array('Popup - Fade in','Popup - Slide down','Popup - Slide up','Sidebar - Top','Sidebar - Bottom');
					foreach($positions as $position){
						if(isset($live_content_position) && $position == $live_content_position) {
							$selected = "selected";
						}else{
							$selected = "";
						}
						printf('<option value="%s" %s>%s</option>', $position, $selected, $position);
					}
					?>
				</select></p>
				<?php 
				do_action( 'add_live_content_meta_fields', $meta_id->ID );
				$preview_url = get_site_url(); 
				$preview_url = apply_filters( 'live_content_preview_link', $preview_url, $meta_id->ID );
				?>
				<p><label for="live_content_preview">Preview link ( Save post as a draft to view the preview link ):</label><br>
				<input type="text" name="live_content_preview" value="<?php echo $preview_url . "?live_content_preview=" . $meta_id->ID; ?>" readonly></p>
			</div>
		<?php

		wp_nonce_field( 'save_bsft_live_content', 'bsft_live_content' );
	}

	/**
	 * @param $post_id
	 */
	private function set_post_object_from_id( $post_id ) {
		$this->post = get_post( $post_id );
	}

	/**
	 * @return array|null|WP_Post
	 */
	private function get_post_object() {
		if ( ! isset ( $this->post ) ) {
			$this->post = get_post();
		}

		return $this->post;
	}

}
