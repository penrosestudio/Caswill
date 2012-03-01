<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<h2 id="<?php echo $post->post_name; ?>"><?php the_title(); ?></h2>
<?php // the_category(); ?>
<?php // the_tags(); ?>
<?php the_content(); ?>

<?php 
endwhile;
endif; ?>