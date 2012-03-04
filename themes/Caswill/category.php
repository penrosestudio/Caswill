<?php get_header(); ?>

<?php get_sidebar(); ?>	


<div id="content" class="grid8col right">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="article">
		<h2 id="<?php echo $post->post_name; ?>"><?php the_title(); ?></h2>
		<span class="date"><?php the_time('jS F Y') ?></span>
		<?php // the_category(); ?>
		<?php // the_tags(); ?>
		<?php the_content(); ?>
	</div>
	<?php 
	endwhile;
	endif; ?>
</div>
<?php get_footer(); ?>