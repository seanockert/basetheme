
</div><!-- END Container -->

<div class="container">	
	<footer id="footer" class="sixteen columns">
		<nav>
			<?php wp_nav_menu( array( 'container_class' => '', 'menu' => 'footer nav' ) ); ?>
		</nav>
		<div class="clear"></div>
		&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
	</footer>		
	<?php wp_footer(); ?>
</body>
</html>
