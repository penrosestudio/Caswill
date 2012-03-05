<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content" class="grid8col right">
	<div id="videoPlayer">
	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
	<?php the_content(''); ?>
	<?php endwhile; endif; ?>
	</div>	
	<span class="details"><?php echo(types_render_field("video-details")); ?></span>
</div>

<?php get_footer(); ?>