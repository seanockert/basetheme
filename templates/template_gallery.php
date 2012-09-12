<?php 
	/* Template Name: Gallery */
?>

<?php get_header(); ?>
<section id="main-content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

		<header>
			<h2><?php the_title(); ?></h2>
			<div class="breadcrumbs small"><?php if(function_exists('bcn_display')) {bcn_display();} ?></div>
		</header>
	

	
		<?php the_content(''); ?>
		<?php echo do_shortcode('[gallery_custom link="file" size="thumbnail"]'); ?>
		<div class="clear"></div>
		
		<?php if (get_option('constellation_show_subpages')=='yes') {
			$subpages = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0&sort_column=menu_order&depth=1');
			if ($subpages) echo '<nav id="subpages"><ul>' . str_replace('</a>',' &rarr;</a>',$subpages) . '</ul></nav>';
		} ?>	

<p class="small"><time datetime="<?php the_time('Y-m-d')?>">Posted <?php the_time('F jS, Y') ?></time></p>		
		
	</article>

<?php endwhile; endif; ?>

</section>

</section>

</div><!-- END Main -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>