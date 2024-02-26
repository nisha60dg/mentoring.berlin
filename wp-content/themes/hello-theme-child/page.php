<?php 
/**
* Template Name: Default Custom Whitepaper
*
*/

get_header();
?>
<div id="content" class="site-main post-2 page type-page status-publish hentry contact_us_wrapper">    
    <div class="page-content">
        <header class="page-header">
            <h2 class="entry-title"><?php wp_title(''); ?></h2>		
        </header> 
        <div class="form_outer">		
            <?php
            // Start the Loop.
            while ( have_posts() ) :
                the_post();

                the_content();

            endwhile;
            ?>
        </div>  
    </div>  
</div>

<?php get_footer(); ?>