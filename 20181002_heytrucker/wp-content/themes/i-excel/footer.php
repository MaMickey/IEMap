<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package i-excel
 * @since i-excel 1.0
 */
$default_copyright = 'Copyright &copy; '.get_bloginfo( 'name' ) ; 
$no_footer = "";
if ( function_exists( 'rwmb_meta' ) ) {
	$no_footer = rwmb_meta('iexcel_no_footer');
}   
?>

		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
        	<?php if( $no_footer != 1 ) : ?>
        	<div class="footer-bg clearfix">
                <div class="widget-wrap">
                    <?php get_sidebar( 'main' ); ?>
                </div>
			</div>
            <?php endif; ?> 
			<div class="site-info">
                <div class="copyright">
                	<?php //esc_attr_e( 'Copyright &copy;', 'i-excel' ); ?>  <?php //bloginfo( 'name' ); ?>
                    <?php esc_attr_e(get_theme_mod('copyright_text', $default_copyright )); ?>                    
                </div>            
            	<div class="credit-info">
					<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'i-excel' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'i-excel' ); ?>">
						<?php printf( __( 'Powered by %s', 'i-excel' ), 'WordPress' ); ?>
                    </a>
                    <?php printf( __( ', Designed and Developed by', 'i-excel' )); ?> 
                    <a href="<?php echo esc_url( __( 'http://www.templatesnext.org/', 'i-excel' ) ); ?>">
                   		<?php printf( __( 'templatesnext', 'i-excel' ) ); ?>
                    </a>
                </div>

			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>