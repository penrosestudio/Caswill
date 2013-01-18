<?php get_header(); ?>
<div id="tree"></div>
<?php get_sidebar(); ?>
<div id="content" class="grid8col right">

	<?php global $wp_query;
	global $post;
	$videos = array();
	query_posts('post_type=video&order=ASC&category_name=Featured'); 
	if(have_posts()) : ?>
	<div id="carouselPlayer">
		<?php $i=0; ?>
		<div id="playerBox"></div>
		<div class="thumbnails">
			<ul>
			<?php while(have_posts()) : the_post(); ?>
				<?php $content = get_the_content();
					$title = get_the_title(); ?>
				<?php if($i==0) : $liClass = "first"; else: $liClass=""; endif; ?>
				<li class="<?php echo $liClass; ?>">
					<pre class="hidden">
						<?php echo htmlentities(apply_filters('the_content', $content)); ?>
					</pre>
					<?php echo create_video_thumbnail(get_url_from_content($content)); ?>
				</li>
				<?php $i++;
				$videos[] = $post; ?>
			<?php endwhile; ?>
			</ul>
		</div>
	</div>
	<?php endif; ?>
	<?php if(!empty($videos)): ?>
	<div id="playerControl">
		<?php $i=0;
		foreach($videos as $post) : ?>
		<?php $numberClass = $i; ?>
		<?php if($i==0) : $aClass="active "; else : $aClass=""; endif; ?>
		<a href="<?php the_permalink(); ?>" class="<?php echo $aClass; echo "number"; echo $i; ?>"><?php the_title(); ?>
			<!-- <span class="details"><?php echo(types_render_field("video-details")); ?></span> -->
			<span class="details"><?php 
			$parentcat = get_category_id('Films');
			foreach((get_the_category()) as $childcat) {
				if (cat_is_ancestor_of($parentcat, $childcat)) {
					echo $childcat->cat_name;
			}} ?></span>
			
			
		</a>
		<?php $i++;
		endforeach; ?>
	</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>