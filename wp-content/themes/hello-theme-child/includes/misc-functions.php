<?php

/**
 * Outputs navigation tabs markup in core screens.
 *
 * @since 1.0
 *
 * @param array  $tabs       Navigation tabs.
 * @param string $active_tab Active tab slug.
 * @param array  $query_args Optional. Query arguments used to build the tab URLs. Default empty array.
 */
function mentoring_navigation_tabs( $tabs, $active_tab, $query_args = array() ) {
	$tabs = (array) $tabs;

	if ( empty( $tabs ) ) {
		return;
	}

	/**
	 * Filters the navigation tabs immediately prior to output.
	 *
	 * @since 1.0
	 *
	 * @param array  $tabs Tabs array.
	 * @param string $active_tab Active tab slug.
	 * @param array  $query_args Query arguments used to build the tab URLs.
	 */
	$tabs = apply_filters( 'mentoring_navigation_tabs', $tabs, $active_tab, $query_args );

	foreach ( $tabs as $tab_id => $tab_name ) {
		$query_args = array_merge( $query_args, array( 'tab' => $tab_id ) );
		$tab_url    = add_query_arg( $query_args );

		printf( '<a href="%1$s" alt="%2$s" class="%3$s">%4$s</a>',
			esc_url( $tab_url ),
			esc_attr( $tab_name ),
			$active_tab == $tab_id ? 'nav-tab nav-tab-active' : 'nav-tab',
			esc_html( $tab_name )
		);
	}

	/**
	 * Fires immediately after the navigation tabs output.
	 *
	 * @since 1.0
	 *
	 * @param array  $tabs Tabs array.
	 * @param string $active_tab Active tab slug.
	 * @param array  $query_args Query arguments used to build the tab URLs.
	 */
	do_action( 'mentoring_after_navigation_tabs', $tabs, $active_tab, $query_args );
}


/**
 * Print R any Object or Array value to read the values inside the variable
 * 
 * @since 1.0
 * 
 * @return array|object|null The value of Array/Object, default null
 */
function pr($data_array = '', $die_script = false){
	if(!empty($data_array)){
		echo '<pre>';
		print_r($data_array);
		echo '</pre>';
		if($die_script)
			die;
	}else{
		return null;
	}
}