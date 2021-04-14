<?php
class WHMenu
{

    public function __construct()
    {
        add_action('wp_footer', array(
            $this,
            'addMenu'
        ));
        add_action('wp_footer', array(
            $this,
            'addStyle'
        ));
        add_action('init', array(
            $this,
            'registerHamburgerMenu'
        ));
		add_action('wp_enqueue_scripts', array(
            $this,
            'load_dashicons_front_end'
        ));

    }
	
	function load_dashicons_front_end() {
	  wp_enqueue_style( 'dashicons' );
	}

    function registerHamburgerMenu()
    {
        register_nav_menu('hamburger-menu', __('Hamburger Menu'));
    }

    function addMenu()
    {

        $html = '';
        $menu_name = 'hamburger-menu';
        $menuLocations = get_nav_menu_locations();
        $menuID = $menuLocations[$menu_name];
        $hamburgerNav = wp_get_nav_menu_items($menuID);
        $nav = '<ul class="hamburgerNavItem">';
        foreach ($hamburgerNav as $hamburgerNavItem)
        {
            $nav .= '<li><a href="' . $hamburgerNavItem->url . '" title="' . $hamburgerNavItem->title . '">' . $hamburgerNavItem->title . '</a></li>';
        }
        $nav .= '</ul>';
		
		$nav = $this->clean_custom_menu('hamburger-menu');

        $html .= '
				<div class="hamburger hamburgerMenu" id="hamburgerMenu">
				  <span class="top"></span>
				  <span class="middle"></span>
				  <span class="bottom"></span>
				</div>

				<div class="menuOverlay" id="menuOverlay">				
				  <nav class="menuOverlay-menu">
				  ' . $nav . '					
				</div>
				
				
				<script> 
					jQuery(".hamburger").click(function() {
					   jQuery(".hamburgerMenu").toggleClass("active");
					   jQuery("#menuOverlay").toggleClass("show");
					  });
					jQuery("li.item.has-sub-menu").click(function(){
						  jQuery("li.item.has-sub-menu").removeClass("open");
						  jQuery("li.item.has-sub-menu .sub-menu").addClass("hide-sub-menu");
						  jQuery(this).children("ul").removeClass("hide-sub-menu");
						  jQuery(this).addClass("open");          
					});
					jQuery("li.item.has-sub-menu.open").click(function(){
						  jQuery(this).children("ul").addClass("hide-sub-menu");
						  jQuery(this).removeClass("open");          
					});
				</script>';

        echo $html;

    }

    function addStyle()
    {
        $mainColor = '#FF6600';
        $html = '<style>
				 .hamburgerMenu{position:fixed;top:5%;right:2%;height:27px;width:35px;cursor:pointer;z-index:100;transition:opacity .25s ease}.hamburgerMenu:hover{opacity:.7}.hamburgerMenu.active .top{transform:translateY(10px) translateX(0) rotate(45deg);background:#fff}.hamburgerMenu.active .middle{opacity:0;background:#fff}.hamburgerMenu.active .bottom{transform:translateY(-10px) translateX(0) rotate(-45deg);background:#fff}.hamburgerMenu span{background:' . $mainColor . ';border:none;height:5px;width:100%;position:absolute;top:0;left:0;transition:all .35s ease;cursor:pointer}.hamburgerMenu span:nth-of-type(2){top:10px}.hamburgerMenu span:nth-of-type(3){top:20px}.menuOverlay{position:fixed;top:0;left:0;width:100%;height:100%;opacity:1;visibility:hidden;transition:opacity .35s,visibility .35s,width .35s;z-index:50}.menuOverlay:before{content:"";background:' . $mainColor . ';left:-55%;top:0;width:50%;height:100%;position:absolute;transition:left .35s ease}.menuOverlay:after{content:"";background:' . $mainColor . ';right:-55%;top:0;width:50%;height:100%;position:absolute;transition:all .35s ease}.menuOverlay.show{opacity:.9;visibility:visible;height:100%}.menuOverlay.show:before{left:0}.menuOverlay.show:after{right:0}.menuOverlay.show li{animation:fadeInRight .5s ease forwards;animation-delay:.35s}.menuOverlay.show li:nth-of-type(2){animation-delay:.45s}.menuOverlay.show li:nth-of-type(3){animation-delay:.55s}.menuOverlay.show li:nth-of-type(4){animation-delay:.65s}.menuOverlay nav{position:relative;height:70%;top:40%;transform:translateY(-50%);font-size:50px;font-weight:400;text-align:center;z-index:100}.menuOverlay ul{list-style:none;padding:0;margin:0 auto;display:inline-block;position:relative;}.menuOverlay ul li{display:block;height:25%;height:calc(100% / 4);min-height:50px;position:relative;opacity:0}.menuOverlay ul li a{display:block;position:relative;color:#fff;text-decoration:none;overflow:hidden}.menuOverlay ul li a:active:after,.menuOverlay ul li a:focus:after,.menuOverlay ul li a:hover:after{width:100%}.menuOverlay ul li a:after{content:"";position:absolute;bottom:0;left:50%;width:0%;transform:translateX(-50%);height:3px;background:#fff;transition:.35s}div#menuOverlay{z-index:999998}div#hamburgerMenu{z-index:999999}div#hamburgerMenu{opacity:0}div#hamburgerMenu.active{opacity:1}@keyframes fadeInRight{0%{opacity:0;left:20%}100%{opacity:1;left:0}}
				 
				 ul.main-nav::after{content:"";background:#f60;top:0;width:50%;height:100%;position:absolute;transition:all .35s ease;right:-200%;z-index:99}.show ul.main-nav::after{right:0}ul.main-nav::before{content:"";background:#f60;left:-200%;top:0;width:50%;height:100%;position:absolute;transition:left .35s ease}.show ul.main-nav::before{left:0}.menuOverlay ul{display:block!important}ul.main-nav{padding-top:28px!important;opacity:1;max-width:400px;padding-bottom:15px!important}.menuOverlay.show{opacity:.97!important}.menuOverlay ul li{display:block;height:auto!important;min-height:42px!important;position:relative;opacity:0;z-index:9999}ul.sub-menu{padding-top:12px!important;width:100%;margin:10px auto!important;background-color:#575757!important;padding-bottom:8px!important}ul.sub-menu li.item{min-height:auto!important;padding-bottom:7px}.menuOverlay ul li a{font-size:22px!important;font-family:"QuorumStd Black",Sans-serif!important;line-height:30px;font-weight:600}.menuOverlay:after{background:#000!important}.menuOverlay:before{background:#000!important}.menuOverlay ul li a:after{content:"";position:absolute;bottom:0;left:50%;width:auto;transform:translateX(-50%);transition:.35s;border-bottom:0 solid;background:0 0!important}li.item.has-sub-menu::after{font-family:dashicons;content:"\f347";position:absolute;top:0;font-size:18px;right:10%;color:#fff;cursor:pointer;transition:.5s}li.item.has-sub-menu.open::after{transform:rotate(180deg)}li.item.has-sub-menu .hide-sub-menu{display:none!important}li.item.has-sub-menu .show-sub-menu{display:block!important}.menuOverlay ul.sub-menu a{font-size:16px!important;line-height:22px;text-transform:uppercase}.menuOverlay ul li a{text-transform:uppercase}

		</style>';

        echo $html;
    }
	
	function checkParentItem($menu_items, $itemId){		
		foreach($menu_items as $item){
			if($itemId == $item->menu_item_parent){
				return true;
			}	
		}
		return false;
	}
	
	function clean_custom_menu( $theme_location ) {
		if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
			$menu = get_term( $locations[$theme_location], 'nav_menu' );
			$menu_items = wp_get_nav_menu_items($menu->term_id);
	 
			$menu_list  = '<nav>' ."\n";
			$menu_list .= '<ul class="main-nav">' ."\n";
	 
			$count = 0;
			$submenu = false;
			 
			foreach( $menu_items as $menu_item ) {
				 
				$link = $menu_item->url;
				$title = $menu_item->title;
				$class ='';
				 
				if ( !$menu_item->menu_item_parent ) {
					$parent_id = $menu_item->ID;
					
					if ( $this->checkParentItem($menu_items, $menu_item->ID) == true ) {
						$class = 'has-sub-menu';
					}
					 
					$menu_list .= '<li class="item '.$class.'">' ."\n";
					$menu_list .= '<a href="'.$link.'" class="title">'.$title.'</a>' ."\n";
				}
	 
				if ( $parent_id == $menu_item->menu_item_parent ) {
	 
					if ( !$submenu ) {
						$submenu = true;
						$menu_list .= '<ul class="sub-menu hide-sub-menu">' ."\n";
					}
	 
					$menu_list .= '<li class="item">' ."\n";
					$menu_list .= '<a href="'.$link.'" class="title">'.$title.'</a>' ."\n";
					$menu_list .= '</li>' ."\n";
						 
	 
					if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ){
						$menu_list .= '</ul>' ."\n";
						$submenu = false;
					}
	 
				}
	 
				if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id ) { 
					$menu_list .= '</li>' ."\n";      
					$submenu = false;
				}
	 
				$count++;
			}
			 
			$menu_list .= '</ul>' ."\n";
			$menu_list .= '</nav>' ."\n";
	 
		} else {
			$menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
		}
		return $menu_list;
	}

}

new WHMenu();

