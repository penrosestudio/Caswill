<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content" class="grid8col right">
	<h2>Film Index</h2>
	<?php global $wp_query;
	$cat = $wp_query->query_vars['category_name'];
	$query = query_posts('category_name='.$cat.'&post_type=video'); ?>
	<?php if(have_posts()) : ?>
	<ul id="filmIndex">
		<?php while (have_posts()) : the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>">
				<img>
				<?php the_title(); ?>
				<span class="details"><?php echo(types_render_field("video-details")); ?></span>
			</a>
		</li>
			<?php the_content(''); ?>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>
</div>

<?php get_footer(); ?>