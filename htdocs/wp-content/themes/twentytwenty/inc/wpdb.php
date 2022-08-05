<?php
$user_count = $wpdb->get_row( "SELECT post_titl` FROM wpba_posts WHERE post_status = 'publish'" );
var_dump( $user_count);
