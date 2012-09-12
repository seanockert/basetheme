<?php 
	/* Template Name: Product */
?>
<?php get_header(); ?>
<section id="main-content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<header>
			<h1><?php the_title(); ?></h1>
		</header>
		
		<?php the_content(''); ?>

	</article>

<?php endwhile; endif; ?>

</section>

</div><!-- END Main -->

<?php get_footer(); ?>