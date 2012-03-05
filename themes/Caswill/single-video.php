<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content" class="grid8col right">
	<div id="videoPlayer">
	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
	<h2><?php the_title(); ?></h2>
	<span class="details"><?php echo(types_render_field("video-details")); ?></span>
	<?php the_content(''); ?>
	<?php endwhile; endif; ?>
	</div>	
</div>

<?php get_footer(); ?>