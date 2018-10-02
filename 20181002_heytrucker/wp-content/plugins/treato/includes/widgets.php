<?php
/**
 * Security check
 * Prevent direct access to the file.
 *
 * @since 1.0.9
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Treato Widget
 * Register and display medical information in widget area.
 *
 * @since 1.0.0
 */
class Treato extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'treato',
			__( 'Treato', 'treato' ),
			array(
				'description' => __( 'Seek medical information and share personal experiences and insights.', 'treato' ),
				'classname'   => 'treato',
			)
		);

	}

	public function widget( $args, $instance ) {

		// Retrieve an existing value from the database
		$treato_title = !empty( $instance['treato_title'] ) ? $instance['treato_title'] : '';
		$treato_content = !empty( $instance['treato_content'] ) ? $instance['treato_content'] : '';
		$treato_search = !empty( $instance['treato_search'] ) ? $instance['treato_search'] : '';
		$treato_poweredby = !empty( $instance['treato_poweredby'] ) ? $instance['treato_poweredby'] : '';

		// Before Widget
		echo $args['before_widget'];

		// Start Div
		echo '<div class="treato">';

		// Widget Title
		$title = apply_filters( 'widget_title', $instance['treato_title'] );
		if ( $title ) {
			echo $args['before_title'];
			echo $title;
			echo $args['after_title'];
		}

		// What to show in the widget
		if ( $treato_content == 'treato_default' ):
			$concept = $treato_search;
		elseif ( $treato_content == 'treato_title' ):
			$concept = the_title_attribute( array( 'echo' => '0' ) );
		else:
			$concept = ' ';
		endif;

		// Widget Content
		echo '<iframe src="http://treato.com/widgets/general/widget.html?concept=' . $concept . '" scrolling="no" style="width:300px; height:350px;" class="treato_iframe"></iframe>';

		// Powered by
		if ( $treato_poweredby == true ) {
			echo '<br />';
			_e( 'Powered by <a href="http://treato.com/">Treato.com</a>', 'treato' );
		}

		// End Div
		echo '</div>';

		// After Widget
		echo $args['after_widget'];

	}

	public function form( $instance ) {

		// Set default values
		$instance = wp_parse_args( (array) $instance, array( 
			'treato_title' => 'Treato',
			'treato_content' => '',
			'treato_search' => '',
			'treato_poweredby' => '',
		) );

		// Retrieve an existing value from the database
		$treato_title = !empty( $instance['treato_title'] ) ? $instance['treato_title'] : '';
		$treato_content = !empty( $instance['treato_content'] ) ? $instance['treato_content'] : '';
		$treato_search = !empty( $instance['treato_search'] ) ? $instance['treato_search'] : '';
		$treato_poweredby = !empty( $instance['treato_poweredby'] ) ? $instance['treato_poweredby'] : '';

		// Form fields
		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'treato_title' ) . '" class="treato_title_label">' . __( 'Title', 'treato' ) . '</label>';
		echo '	<input type="text" id="' . $this->get_field_id( 'treato_title' ) . '" name="' . $this->get_field_name( 'treato_title' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'treato' ) . '" value="' . esc_attr( $treato_title ) . '">';
		echo '</p>';

		echo '<p>';
		echo '	<label class="treato_content_label">' . __( 'Content', 'treato' ) . '</label><br>';
		echo '	<label>';
		echo '		<input type="radio" name="' . $this->get_field_name( 'treato_content' ) . '" value="treato_search" ' . checked( $treato_content, 'treato_search', false ) . '> ' . __( 'Simple Search box', 'treato' );
		echo '	</label><br>';
		echo '	<label>';
		echo '		<input type="radio" name="' . $this->get_field_name( 'treato_content' ) . '" value="treato_default" ' . checked( $treato_content, 'treato_default', false ) . '> ' . __( 'Custom Search Result', 'treato' );
		echo '	</label><br>';
		echo '	<label>';
		echo '		<input type="radio" name="' . $this->get_field_name( 'treato_content' ) . '" value="treato_title" ' . checked( $treato_content, 'treato_title', false ) . '> ' . __( 'Post Title', 'treato' );
		echo '	</label><br>';
		echo '	<span class="description">' . __( 'Select the content to be shown by treato widget.', 'treato' ) . '</span>';
		echo '</p>';

		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'treato_search' ) . '" class="treato_search_label">' . __( 'Custom Search Result', 'treato' ) . '</label>';
		echo '	<input type="text" id="' . $this->get_field_id( 'treato_search' ) . '" name="' . $this->get_field_name( 'treato_search' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'treato' ) . '" value="' . esc_attr( $treato_search ) . '">';
		echo '	<span class="description">' . __( 'If custom search result selected, show this result.', 'treato' ) . '</span>';
		echo '</p>';

		echo '<p>';
		echo '	<label>';
		echo '		<input type="checkbox" id="' . $this->get_field_id( 'treato_poweredby' ) . '" name="' . $this->get_field_name( 'treato_poweredby' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'treato' ) . '" value="1" ' . checked( $treato_poweredby, true, false ) . '>'  . __( 'Powered by <a href="http://treato.com/">Treato.com</a>', 'treato' );
		echo '	</label>';
		echo '</p>';

	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['treato_title'] = !empty( $new_instance['treato_title'] ) ? strip_tags( $new_instance['treato_title'] ) : '';
		$instance['treato_content'] = !empty( $new_instance['treato_content'] ) ? $new_instance['treato_content'] : '';
		$instance['treato_search'] = !empty( $new_instance['treato_search'] ) ? strip_tags( $new_instance['treato_search'] ) : '';
		$instance['treato_poweredby'] = !empty( $new_instance['treato_poweredby'] ) ? true : false;

		return $instance;

	}

}
add_action( 'widgets_init', create_function( '', 'register_widget("Treato");' ) );
