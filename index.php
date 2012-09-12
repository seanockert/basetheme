<?php get_header(); ?>

<section id="main-content">
	
	<?php if (is_search()) { ?>		
	<header>
		<h1>Search Results for &ldquo;<?php the_search_query(); ?>&rdquo; <?php if (get_query_var('paged')) echo ' &mdash; Page '.get_query_var('paged'); ?></h1>
		<?php get_template_part('loop_search'); ?>
	</header>
	<?php } else { ?>
		<header>
			<h1>Latest News Articles</h1>
			<div class="breadcrumbs small"><?php if(function_exists('bcn_display')) {bcn_display();} ?></div>
		</header>		
		<?php get_template_part('loop'); ?>
	<?php } ?>

</section>


</div><!-- END Main -->
<?php get_sidebar_blog(); ?>

<?php get_footer(); ?>