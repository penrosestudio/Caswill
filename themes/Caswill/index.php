<?php get_header(); ?>

<?php get_sidebar(); ?>	


<div id="content" class="grid8col right">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="article">
		<h2 id="<?php echo $post->post_name; ?>">
		<?php if(is_singular()) : ?>
			<?php the_title(); ?>
		<?php else: ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		<?php endif; ?>
		</h2>
		<?php if(!is_page()) : ?><span class="date"><?php the_time('jS F Y') ?></span><?php endif; ?>
		<?php // the_category(); ?>
		<?php // the_tags(); ?>
		<?php the_content(); ?>
	</div>
	<?php 
	endwhile;
	endif; ?>
</div>
<?php get_footer(); ?>