<?php
/**
*
*/
class WPBA_Settings_Fields extends WP_Better_Attachments
{
	protected $hide_link;


	function __construct( $config = array() )
	{
		parent::__construct();
		$this->hide_link = ' <a href="#" class="wpba-settings-hide">hide</a>';
	} // __construct


	/**
	* Media Page Settings
	*
	* @since 1.3.5
	* @return array
	*/
	public function get_media_table_settings()
	{
		// Media Page Settings
		return array(
			'name'			=> 'wpba-media-table-settings',
			'label'			=> __( 'Media Table Settings' . $this->hide_link, 'wpba' ),
			'desc'			=> __( '', 'wpba' ),
			'type'			=> 'multicheck',
			'options'		=> array(
											'unattach_link'	=> 'Disable Un-attach Link',
											'reattach_link'	=> 'Disable Re-attach Link'
										)
		);
	} // get_media_table_settings()


	/**
	* Meta Box Settings
	*
	* @since 1.3.5
	* @return array
	*/
	public function get_metabox_settings()
	{
		// Media Page Settings
		return array(
			'name'			=> 'wpba-meta-box-settings',
			'label'			=> __( 'Global Meta Box Settings' . $this->hide_link, 'wpba' ),
			'desc'			=> __( '', 'wpba' ),
			'type'			=> 'multicheck',
			'options'		=> array(
											'gmb_title' 							=> 'Disable Title Editor',
											'gmb_caption'							=> 'Disable Caption Editor',
											'gmb_show_attachment_id'	=> 'Disable Attachment ID',
											'gmb_unattach_link'				=> 'Disable Un-attach Link',
											'gmb_edit_link'						=> 'Disable Edit Link',
											'gmb_delete_link'					=> 'Disable Delete Link',
										)
		);
	} // get_metabox_settings()


	/**
	* Edit Modal Page Settings
	*
	* @since 1.3.5
	* @return array
	*/
	public function get_edit_modal_settings()
	{
		// Media Page Settings
		return array(
			'name'			=> 'wpba-edit-modal-settings',
			'label'			=> __( 'Global Edit Modal Settings' . $this->hide_link, 'wpba' ),
			'desc'			=> __( '', 'wpba' ),
			'type'			=> 'multicheck',
			'options'		=> array(
											'gem_caption'						=> 'Disable Caption',
											'gem_alternative_text'	=> 'Disable Alternative Text',
											'gem_description'				=> 'Disable Description',
										)
		);
	} // get_edit_modal_settings()


	/**
	* Post Type Disable Settings
	*
	* @return array
	* @since 1.3.5
	*/
	function get_post_type_disable_settings()
	{
		$post_types = $this->get_post_types();

		// Cleanup post types
		foreach ( $post_types as $key => $post_type ) {
			// Setup Post Type Disables
			$post_type_obj = get_post_type_object( $post_type );
			$post_types[$key] = "Disable {$post_type_obj->labels->name}";
		} // foreach()

		// Post Type Disable Settings
		return array(
			'name'			=> 'wpba-disable-post-types',
			'label'			=> __( 'Post Types' . $this->hide_link, 'wpba' ),
			'desc'			=> __( '', 'wpba' ),
			'type'			=> 'multicheck',
			'options'		=> $post_types
		);
	} // get_post_type_disable_settings()


	/**
	* Get Post Types
	*
	* @return array
	* @since 1.3.5
	*/
	function get_post_types()
	{
		$post_types = get_post_types();
		unset( $post_types["attachment"] );
		unset( $post_types["revision"] );
		unset( $post_types["nav_menu_item"] );
		unset( $post_types["deprecated_log"] );

		return $post_types;
	} // get_post_types()


	/**
	* Global Settings
	*
	* @return array
	* @since 1.3.5
	*/
	function get_global_settings()
	{
		// Global Settings
		return array(
			'name'			=> 'wpba-global-settings',
			'label'			=> __( 'Global Settings' . $this->hide_link, 'wpba' ),
			'desc'			=> __( '', 'wpba' ),
			'type'			=> 'multicheck',
			'options'		=> array(
												'thumbnail'				=> 'Do Not Include Thumbnails',
												'no_shortcodes'		=> 'Disable Shortcodes',
												'no_crop_editor'	=> 'Disable WPBA Image Crop Editor',
												'all_crop_sizes'	=> 'Show All Image Sizes WPBA Image Crop Editor',
												'thumbnail'				=> 'Do Not Include Thumbnail'
											)
		);
	} // get_global_settings()


	/**
	* Post Type Options
	*
	* @since 1.3.5
	* @return array
	*/
	public function get_post_type_settings()
	{
		$post_types = $this->get_post_types();
		$post_type_settings = array();

		// Cleanup post types
		foreach ( $post_types as $key => $post_type ) {
			// Setup Post Type Settings
			$post_type_settings[] = $this->get_meta_box_title_fields( $post_type );
			$post_type_settings[] = $this->get_post_type_options( $post_type );
			$post_type_settings[] = $this->get_post_type_attachment_types( $post_type );
		} // foreach()

		return $post_type_settings;
	} // get_post_type_settings()


	/**
	* Post Type Options
	*
	* @since 1.3.5
	* @return array
	*/
	public function get_post_type_options( $post_type )
	{
		$post_type_obj = get_post_type_object( $post_type );
		$post_type_options = array(
			'title' 								=> 'Disable Title Editor (meta box)',
			'caption'								=> 'Disable Caption Editor (meta box)',
			'mb_show_attachment_id'	=> 'Disable Attachment ID (meta box)',
			'mb_unattach_link'			=> 'Disable Un-attach Link (meta box)',
			'mb_edit_link'					=> 'Disable Edit Link (meta box)',
			'mb_delete_link'				=> 'Disable Delete Link (meta box)',
			'em_caption'						=> 'Disable Caption (edit modal)',
			'em_alternative_text'		=> 'Disable Alternative Text (edit modal)',
			'em_description'				=> 'Disable Description (edit modal)',
			'mb_thumbnail'					=> 'Do Not Include Thumbnail'
		);

		return array(
			'name'      => "wpba-{$post_type_obj->name}-settings",
			'label'     => __( "{$post_type_obj->labels->name} Settings{$this->hide_link}", 'wpba' ),
			'desc'      => __( '', 'wpba' ),
			'type'      => 'multicheck',
			'options'   => $post_type_options
		);
	} // get_post_type_options()


	/**
	* Get Current Post Type Attachment Types
	*
	* @since 1.3.5
	* @return array
	*/
	public function get_post_type_attachment_types( $post_type )
	{
		$post_type_obj = get_post_type_object( $post_type );
		$atttachment_types = array(
		'pt_disable_image'			=> 'Disable Image Files',
		'pt_disable_video'			=> 'Disable Video Files',
		'pt_disable_audio'			=> 'Disable Audio Files',
		'pt_disable_document'		=> 'Disable Documents'
		);

		return array(
			'name'      => "wpba-{$post_type_obj->name}-disable-attachment-types",
			'label'     => __( "{$post_type_obj->labels->name} File Types{$this->hide_link}", 'wpba' ),
			'desc'      => __( '', 'wpba' ),
			'type'      => 'multicheck',
			'options'   => $atttachment_types
		);
	} // get_post_type_attachment_types()


	/**
	* Post Type Attachment Types
	*
	* @since 1.3.5
	* @return array
	*/
	public function get_attachment_types()
	{
		$atttachment_types = array(
		'disable_image'			=> 'Disable Image Files',
		'disable_video'			=> 'Disable Video Files',
		'disable_audio'			=> 'Disable Audio Files',
		'disable_document'	=> 'Disable Documents'
		);

		return array(
			'name'      => "wpba-disable-attachment-types",
			'label'     => __( "File Types{$this->hide_link}", 'wpba' ),
			'desc'      => __( '', 'wpba' ),
			'type'      => 'multicheck',
			'options'   => $atttachment_types
		);
	} // get_attachment_types()


	/**
	* Meta Box Titles
	*
	* @since 1.3.6
	* @return array
	*/
	public function get_meta_box_title_fields( $post_type )
	{
		$post_type_obj = get_post_type_object( $post_type );
		return array(
			'name'		=> "wpba-{$post_type_obj->name}-meta-box-title",
			'label'		=> __( "{$post_type_obj->labels->name} Meta Box Title", 'wpba' ),
			'desc'		=> __( '', 'wpba' ),
			'type'		=> 'text',
			'default'	=> 'WP Better Attachments'
		);
	} // get_meta_box_title_fields()
} // class

// initiate the class
global $wpba_settings_fields;
$wpba_settings_fields = new WPBA_Settings_Fields();