<?php
/**
 * Template Name: Account Verification Response
 * 
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
            // Manage API Errors Response
            if (mentoring()->Errors->get_errors()) {
                mentoring()->Errors->print_errors();
            }else if(isset($_REQUEST['notice']) ){
                if($_REQUEST['notice'] == "verified")
                {
                    ?>
                    <div class="alert alert-success">
                        <p>Your account has been verified successfully. </p>
                        <p><a href="https://mentoring.berlin/login/">Login Here</a> to access more information related to strategic mentoring.</p>
                    </div>
                    <?php 
                }else if($_REQUEST['notice'] == "registered"){ ?>
                    <div class="alert alert-success">
                    You have successfully subscribed for email course. We will contact with you soon for further details.

                    </div>
                <?php }else if($_REQUEST['notice'] == "app_submit"){ ?>
                    <div class="alert alert-success">
                    Sie haben Ihre Bewerbung erfolgreich eingereicht. Wir werden Sie zeitnah über den Status Ihrer Bewerbung informieren.
                    </div>
                <?php }
             }else{ 
            
                // Start the Loop.
                while ( have_posts() ) :
                    the_post();

                    the_content();

                endwhile;
            }
            ?>
        </div>  
    </div>  
</div>

<?php get_footer(); ?>
