				<br class="clearboth" />
			</div> <!-- close .jbasewrap -->
			<div class="push"></div>
		</div> <!-- close #wrapper -->
		<div class="footer">
			<div class="jbasewrap">
				<!-- TO-DO: make the footer widgetised -->
	            <?php wp_nav_menu( array(
					'theme_location' => 'footer_menu', 
					'container_id' => 'footer_menu',
					'menu_class' => 'noMargin noBullets ' 
					)
				); ?>
			</div>			
        </div>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery-1.4.1.js"></script>
		<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/app.js"></script>
		<?php wp_foot(); ?>
	</body>
</html>