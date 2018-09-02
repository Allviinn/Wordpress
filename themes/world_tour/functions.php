<?php 

//************************************************
// **************** CSS INCLUDE
//************************************************
function world_tour_enqueue_style() {
	wp_enqueue_style( 'world_tour-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/assets/css/main.css' );
}
add_action( 'wp_enqueue_scripts', 'world_tour_enqueue_style' );

//************************************************
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


//************************************************
// **************** DÉCLARATION MENUS
//************************************************
function register_my_menu() {
  register_nav_menu('main-menu',__( 'Menu pricipal' ));
}
add_action( 'init', 'register_my_menu' );

//************************************************
// **************** MENU MAISON
//************************************************
function my_main_menu() {
	$menu_name = 'main-menu'; // specify custom menu slug

	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		$menu_list = '<nav class="navbar navbar-dark bg-dark navbar-expand-lg">';
		$menu_list .= '<a class="navbar-brand" href="#">Navbar</a>';
		$menu_list .= '
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>' ;

		$menu_list .= '<div class="collapse navbar-collapse" id="navbarSupportedContent">' ;
		$menu_list .= '<ul class="navbar-nav mr-auto">' ;
		$items = array();
		foreach ((array) $menu_items as $key => $menu_item) {
			//création d'un tableau multidimensionnel : niveau 1 parents, niveau 2 enfants
			if ($menu_item->menu_item_parent == '0') {
				$items[$menu_item->ID]['title'] = $menu_item->title;
				$items[$menu_item->ID]['url'] = $menu_item->url;
				$items[$menu_item->ID]['attr_title'] = $menu_item->attr_title;
				$items[$menu_item->ID]['target'] = $menu_item->target;
			}			
			if ($menu_item->menu_item_parent != '0') {
				$items[$menu_item->menu_item_parent]['child'] = true;
				$items[$menu_item->menu_item_parent]['child_list'][] = array(
					'title' => $menu_item->title,
					'url' => $menu_item->url,
					'attr_title' => $menu_item->attr_title,
					'target' => $menu_item->target,
				);
			}
		}

		//boucle sur les parents
		foreach ($items as $parent) {
			$current_page = '';
			if (is_page($parent['title'])) {
				$current_page = 'active';
			} 
			if ($parent['child'] == true) {
				foreach ($parent['child_list'] as $child) {
					if (is_page($child['title'])) {
						$current_page = 'active';
					}
				}
			}
			$menu_list .=  '<li class="nav-item '.(($parent['child'] == true) ? 'dropdown' : '' ).' '.$current_page.'">
								<a 
									class="nav-link '.(($parent['child'] == true) ? 'dropdown-toggle' : '' ).' " 
									'.(($parent['child'] == true) ?  'id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"'  : '' ).'
									href="'. (($parent['child'] == true) ? '#' : $parent['url'] ).'" 
									title="'.$parent['attr_title'].'"
									target="'.$parent['target'].'"
								>
									'.$parent['title'].' 												
								</a>';
			//si il y a des pages enfants, boucle sur les pages enfants
			if ($parent['child'] == true ) {
				$menu_list .= '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">' ;
				foreach ($parent['child_list'] as $child) {
					$current_page = ((is_page($child['title'])) ? 'active' : '' );
					$menu_list .=  '<a 
										class="dropdown-item '.$current_page.'" 
										href="'. $child['url'].'"
										title="'.$child['attr_title'].'"
										target="'.$child['target'].'"
									>
										'.$child['title'].'
									</a>' ;
				}
				$menu_list .= '</div>' ;
			}			
			$menu_list .= '</li>' ;
		}
		$menu_list .=  '</ul>' ;
		$menu_list .=  '<form class="form-inline my-2 my-lg-0">
							<input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search">
							<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
						</form>' ;
		$menu_list .=  '</div>' ;
		$menu_list .=  '</nav>' ;
	} else {
		// $menu_list = '<!-- no list defined -->';
	}
	echo $menu_list;
}

// **************** FIN MENU MAISON
//************************************************
 ?>