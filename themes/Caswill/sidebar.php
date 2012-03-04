				<?php // TO-DO: make these dynamic ?>
				<div id="sidebar" class="grid4col left">
					<h1><a href="<?php home_url(); ?>"><?php bloginfo( 'name' ); ?> <small><?php bloginfo( 'description' ); ?></small></a></h1>
					
					<?php wp_nav_menu( array(
						'theme_location' => 'films_menu', 
						'menu_id' => 'films' 
						)
					); ?>
					<?php wp_nav_menu( array(
						'theme_location' => 'information_menu', 
						'menu_id' => 'information'
						)
					); ?>
				</div>