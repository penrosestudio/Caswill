<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content" class="grid8col right">

	<?php global $wp_query;
	global $post;
	$videos = array();
	query_posts('post_type=video&order=ASC'); // 'category_name='.$cat.'&post_type=video&orderby=menu_order&order=ASC'
	if(have_posts()) : ?>
	<div id="videoPlayer">
		<?php $i=0; ?>
		<div id="playerBox"></div>
		<div class="thumbnails">
			<ul>
			<?php while(have_posts()) : the_post(); ?>
				<?php $content = get_the_content();
					$title = get_the_title(); ?>
				<?php $thumbnail_url = get_thumbnail_url_from_video_url(get_url_from_content($content), 'large'); ?>
				<?php if($i==0) : $liClass = "first"; else: $liClass=""; endif; ?>
				<li class="<?php echo $liClass; ?>">
					<pre class="hidden">
						<?php echo htmlentities(apply_filters('the_content', $content)); ?>
					</pre>
					<img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $title; ?>" />
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
		<?php if($i==0) : $aClass="active"; else : $aClass=""; endif; ?>
		<a href="<?php the_permalink(); ?>" class="<?php echo $aClass; ?>"><?php the_title(); ?>
			<span class="details"><?php echo(types_render_field("video-details")); ?></span>
		</a>
		<?php $i++;
		endforeach; ?>
	</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>