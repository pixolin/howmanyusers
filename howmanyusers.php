<?php
/*
Plugin Name: How many Users
Description: Widget shows amount of registerd users.
Author: Bego Mario Garde
Author URI: https://pixolin.de
Version: 0.1
License: GPL2
Text Domain: wievieluser
Domain Path: languages
*/

/*

    Copyright (C) 2017  Bego Mario Garde  <pixolin@pixolin.de>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
add_action( 'plugins_loaded', 'wievieluser_plugin_textdomain' );

function wievieluser_plugin_textdomain() {
	load_plugin_textdomain( 'wievieluser', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

class Wievieluser_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'wievielbenutzer',
			'description' => __( 'Show count of registered users', 'wievieleuser' ),
		);
		parent::__construct( 'wievielbenutzer', __( 'How many users?', 'wievieluser' ), $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
	  	echo $args['before_widget'];
	  	if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		$result = count_users();

		echo '<p>';
		printf( __( 'There are total %s users.', 'wievieluser' ), $result['total_users'] );
		echo '</p>';

		echo $args['before_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Registered Users', 'wievieluser' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'wievieluser' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
		/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}


add_action( 'widgets_init', function(){
	register_widget( 'Wievieluser_Widget' );
} );
