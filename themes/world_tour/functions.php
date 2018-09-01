<?php 


// **************** CSS INCLUDE
//************************************************
function world_tour_enqueue_style() {
	wp_enqueue_style( 'world_tour-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/assets/css/main.css' );
}
add_action( 'wp_enqueue_scripts', 'world_tour_enqueue_style' );


// **************** JS INCLUDE
//************************************************
function  world_tour_enqueue_script() {
	wp_deregister_script('jquery');
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.js' );
	wp_enqueue_script( 'popper', get_template_directory_uri() . '/assets/js/popper.js' );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery', 'popper') );
	wp_enqueue_script( 'world_tour-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery') );
}
add_action( 'wp_enqueue_scripts', 'world_tour_enqueue_script' );



// **************** MENUS
//************************************************
function register_my_menu() {
  register_nav_menu('main-menu',__( 'Menu pricipal' ));
}
add_action( 'init', 'register_my_menu' );

//custom menu
function my_main_menu() {
	$menu_name = 'main-menu'; // specify custom menu slug
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		$menu_list = '<nav class="navbar navbar-dark bg-dark navbar-expand-lg">' ."\n";
		$menu_list .= "\t\t\t\t". '<a class="navbar-brand" href="#">Navbar</a>' ."\n";
		$menu_list .= "\t\t\t\t". '<button 
										class="navbar-toggler" 
										type="button" 
										data-toggle="collapse" 
										data-target="#navbarSupportedContent" 
										aria-controls="navbarSupportedContent" 
										aria-expanded="false" 
										aria-label="Toggle navigation"
									>
										<span class="navbar-toggler-icon"></span>
									</button>'
								 ."\n";

		$menu_list .= "\t\t\t\t". '<div class="collapse navbar-collapse" id="navbarSupportedContent">' ."\n";
		$menu_list .= "\t\t\t\t\t\t". '<ul class="navbar-nav mr-auto">' ."\n";
		foreach ((array) $menu_items as $key => $menu_item) {
			$title = $menu_item->title;
			$url = $menu_item->url;
			$menu_list .= "\t\t\t\t\t". '<li class="nav-item active">
											<a class="nav-link" href="'. $url .'">'.$title.' <span class="sr-only">(current)</span></a>
										</li>' ."\n";
		}		
		$menu_list .= "\t\t\t\t". '</ul>' ."\n";
		$menu_list .= "\t\t\t\t". '<form class="form-inline my-2 my-lg-0">
										<input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search">
										<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
									</form>' ."\n";
		$menu_list .= "\t\t\t\t\t". '</div>' ."\n";
		$menu_list .= "\t\t\t". '</nav>' ."\n";
	} else {
		// $menu_list = '<!-- no list defined -->';
	}
	echo $menu_list;
}
 ?>