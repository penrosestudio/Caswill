<?php
// Register Main and Footer Menu
if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menu( 'main_menu', 'Main Menu' );
	register_nav_menu( 'footer_menu', 'Footer Menu' );
}
?>