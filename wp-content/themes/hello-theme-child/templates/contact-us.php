<?php 
/**
* Template Name: Contact Us
*
*/

get_header();
?>
<style>
    .page-header .entry-title{ margin:0; max-width: 100%;font-weight:600;color:#003893;margin-top: 30px;margin-left: 225px;}
    .booking_form{ padding:40px 0;}
    .form-row{ display:flex; flex-wrap:wrap; margin-left:-15px; margin-right:-15px;}
    .form-col{ padding-left:15px; padding-right:15px;}
    .col-6{ flex:0 0 50%; max-width:50%; }
    .col-4{ flex:0 0 33.33%; max-width:33.33%; }   
    .field-label{ margin-bottom:8px; font-weight:700;}
    .field-group{ margin-bottom:20px;}
    textarea.field-control{ height:100px; resize:none;}
</style>
<header class="page-header">
    <h1 class="entry-title"><?php wp_title(''); ?></h1>		
</header>
<div id="content" class="site-main post-2 page type-page status-publish hentry contact_us_wrapper">    
    <div class="page-content">
 <div class="form_outer">		
        <form class="contact_us_form">
            <div class="form-row">
                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">First Name<sup>*</sup></label>
                        <input class="field-control" type="text" placeholder="Full Name" />
                    </div>
                </div>
				 <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">Last Name<sup>*</sup></label>
                        <input class="field-control" type="text" placeholder="Last Name" />
                    </div>
                </div>

            </div><!-- row1 ends here -->
			 <div class="form-row">
			 
                <div class="form-col col-12">
                    <div class="field-group">
                        <label class="field-label">Email Address <sup>*</sup></label>
                        <input class="field-control" type="email" placeholder="Email Address" />
                    </div>
                </div>
			 </div><!-- row2 ends here -->
			 
			 <div class="form-row">
			 
                <div class="form-col col-12">
                   <div class="field-group">
                        <label class="field-label">Message</label>
                        <textarea class="field-control" rows="3" ></textarea>
                    </div>
                </div>
			 </div><!-- row3 ends here -->
           
           
            <div class="field-group radio-box">
                <label class="field-label"><input type="radio" name="payby"/> I have read and accepted the privacy policy. </label>                
            </div>
            <div class="field-group radio-box">
                <label class="field-label"><input type="radio" name="payby"/> I have read and accept the terms and conditions.  </label>                
            </div>
			<div class="field-group radio-box">
                <label class="field-label"><input type="radio" name="payby"/> I would like to be added to the free strategy newsletter. </label>                
            </div>
			<div class="field-group">
			<button type="button" class="btn btn-primary btn-submit">SUBMIT</button>
			</div>

        </form>
  </div>  
</div>

<?php get_footer(); ?>