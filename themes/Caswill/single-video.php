<?php get_header(); ?>

<div id="videoPlayer">
<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
<?php the_content(''); ?>
<?php endwhile; endif; ?>
</div>
<div id="playerControl">
	<a href="<?php echo(types_render_field("video-url", array('raw'=>true))); ?>"><?php the_title(); ?>
		<span class="details"><?php echo(types_render_field("video-details")); ?></span>
	</a>
</div>


<?php get_footer(); ?>