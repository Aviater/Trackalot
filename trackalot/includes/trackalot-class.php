<?php
/**
 * Adds trackalot widget.
 */
class trackalot_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'trackalot_widget', // Base ID
			esc_html__( 'Ip Tracker', 'ta_domain' ), // Name
			array( 'description' => esc_html__( 'Widget to display IP', 'ta_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		$trackalot_disp_id = $instance[ 'trackalot_disp_id' ] ? 'true' : 'false';
		$trackalot_disp_location = $instance[ 'trackalot_disp_location' ] ? 'true' : 'false';
		$trackalot_disp_coords = $instance[ 'trackalot_disp_coords' ] ? 'true' : 'false';
		$trackalot_disp_phone = $instance[ 'trackalot_disp_phone' ] ? 'true' : 'false';
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		// Track User Info.
		$varOne = $_SERVER["HTTP_CLIENT_IP"];
		$varTwo = $_SERVER["HTTP_X_FORWARDED_FOR"];
		$varThree = $_SERVER["REMOTE_ADDR"];
		$phoneNumber = $details->phone;

		if (!empty($varOne)) {
			$ip = $varOne;
		} else if (!empty($varTwo)) {
			$ip = $varTwo;
		} else {
			$ip = $varThree;
		}
		
		//output ip address, city, region, country and Geo-location.
		$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
		if ('on' == $instance['trackalot_disp_ip']) {
		echo 'Your IP address is ' . $details->ip . '.' . '<br>';
		}
		if ('on' == $instance['trackalot_disp_location']) {
		echo 'Visiting us from ' . $details->city . ', ' . $details->region . ' in ' . $details->country . '.' . '<br>';
		}
		if ('on' == $instance['trackalot_disp_coords']) {
		echo 'With GeoCoordinates: ' . $details->loc . '.' . '<br>';
		}
		if ('on' == $instance['trackalot_disp_phone']) {
			// Check if user has a registered telephone number.
			if ($phoneNumber == NULL || undefined) {
				echo 'No registered telephone number.';
			} else {
				echo 'Registered telephone number is ' . $phoneNumber . '.';
			}
		}
		echo $args['after_widget'];

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Trackalot', 'ta_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'ta_domain' ); ?></label>
		<!-- Title Field --> 
		<input 
			class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $title ); ?>">
		<!-- IP Address Checkbox -->
		<input 
			class="checkbox" 
			type="checkbox" <?php checked( $instance[ 'trackalot_disp_ip' ], 'on' ); ?> 
			id="<?php echo $this->get_field_id( 'trackalot_disp_ip' ); ?>" 
			name="<?php echo $this->get_field_name( 'trackalot_disp_ip' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'your_checkbox_var' ); ?>">Display IP Address</label>
		<br>
		<!-- Location Checkbox -->
		<input 
			class="checkbox" 
			type="checkbox" <?php checked( $instance[ 'trackalot_disp_location' ], 'on' ); ?> 
			id="<?php echo $this->get_field_id( 'trackalot_disp_location' ); ?>" 
			name="<?php echo $this->get_field_name( 'trackalot_disp_location' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'your_checkbox_var' ); ?>">Display Physical Location</label>
		<br>
		<!-- GeoCoords Checkbox -->
		<input 
			class="checkbox" 
			type="checkbox" <?php checked( $instance[ 'trackalot_disp_coords' ], 'on' ); ?> 
			id="<?php echo $this->get_field_id( 'trackalot_disp_coords' ); ?>" 
			name="<?php echo $this->get_field_name( 'trackalot_disp_coords' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'your_checkbox_var' ); ?>">Display GeoCoordinates</label>
		<br>
		<!-- Telephone Checkbox -->
		<input 
			class="checkbox" 
			type="checkbox" <?php checked( $instance[ 'trackalot_disp_phone' ], 'on' ); ?> 
			id="<?php echo $this->get_field_id( 'trackalot_disp_phone' ); ?>" 
			name="<?php echo $this->get_field_name( 'trackalot_disp_phone' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'your_checkbox_var' ); ?>">Display Telephone Number</label>
		<br>
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
		$instance[ 'trackalot_disp_ip' ] = $new_instance[ 'trackalot_disp_ip' ];
		$instance[ 'trackalot_disp_location' ] = $new_instance[ 'trackalot_disp_location' ];
		$instance[ 'trackalot_disp_coords' ] = $new_instance[ 'trackalot_disp_coords' ];
		$instance[ 'trackalot_disp_phone' ] = $new_instance[ 'trackalot_disp_phone' ];

		return $instance;
	}

} // class Foo_Widget