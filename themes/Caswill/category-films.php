<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content" class="grid8col right">
	<h2>Film Index</h2>
	<?php global $wp_query;
	$cat = $wp_query->query_vars['category_name'];
	$query = query_posts('category_name='.$cat.'&post_type=video');
	if(have_posts()) : ?>
	<ul id="filmIndex">
		<?php while (have_posts()) : the_post();
			$content = get_the_content($post->ID);
			$title = get_the_title($post->ID);
			$post_url = get_url_from_content($content);
			if(isset($post_url)) {
				$thumbnail_url = get_thumbnail_url_from_video_url($matches[0]);
			}
		?>
		<li>
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $title; ?>" />
				<?php echo $title; ?>
				<span class="details"><?php echo(types_render_field("video-details")); ?></span>
			</a>
		</li>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>
</div>

<?php get_footer(); ?>