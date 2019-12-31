<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Business Roy
 */

?>

</div><!-- #content -->

<?php if (is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ): ?>
    
    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="row">
                <?php
                    $widget_count = 0;

                    for ($i = 1; $i <= 4; $i++) {

                        if (is_active_sidebar('footer-' . $i)) {
                            $widget_count++;
                        }
                    }

                    $widget_count = 12 / $widget_count;
                    $widget_class = 'col-lg-' . absint($widget_count);

                    for ($i = 1; $i <= 4; $i++) {

                        if (is_active_sidebar('footer-' . $i)) {
                ?>
                    <div class="<?php echo esc_attr($widget_class); ?> col-md-6 col-sm-6 col-xs-12">
                        <?php dynamic_sidebar('footer-' . $i); ?>
                    </div>
                <?php } } ?>
            </div>

        </div>
    </footer><!-- #colophon -->
<?php endif; ?>

    <div class="sub_footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="businessroycopyright">
                        <?php apply_filters( 'businessroy_copyright', 5 ); ?> <?php the_privacy_policy_link(); ?>
                    </div><!-- Copyright -->
                </div>
            </div>
        </div>
    </div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
