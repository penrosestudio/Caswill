<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content" class="grid8col right">

	<?php global $wp_query;
	query_posts('post_type=video');
	if(have_posts()) : ?>
	<div id="videoPlayer">
		<div id="playerBox"></div>
		<?php while(have_posts()) : the_post(); ?>
		<pre class="hidden">
			<?php echo htmlentities(apply_filters('the_content', $wp_query->posts[0]->post_content)); ?>
		</pre>
		<?php $content = get_the_content();
			$title = get_the_title(); ?>
		<?php $thumbnail_url = get_thumbnail_url_from_video_url(get_url_from_content($content), 'large'); ?>
		<img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $title; ?>" />
		<?php ?>
		<?php endwhile; ?>
	</div>
	<?php endif;
	wp_reset_query(); ?>
	<?php if(have_posts()) : ?>
	<div id="playerControl">
		<?php $i=0;
		while(have_posts()) : the_post(); ?>
		<?php if($i==0) : $aClass="active"; endif; ?>
		<a href="<?php the_permalink(); ?>" class="<?php echo $aClass; ?>"><?php the_title(); ?>
			<span class="details"><?php echo(types_render_field("video-details")); ?></span>
		</a>
		<?php $i++;
		endwhile; ?>
	</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>