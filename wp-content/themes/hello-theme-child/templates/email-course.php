<?php 
/**
* Template Name: Email Course
*
*/

get_header();
?>
<style>
    .page-header .entry-title{ margin:0; max-width: 100%;font-weight:600;color:#003893;margin-top: 30px;margin-left: 150px;}
	.page-content .form_outer{margin-top:20px !important;}
    .whitepaper_form{ padding-bottom:40px 0;}
    .form-row{ display:flex; flex-wrap:wrap; margin-left:-15px; margin-right:-15px;}
    .form-col{ padding-left:15px; padding-right:15px;}
    .col-6{ flex:0 0 50%; max-width:50%; }
    .col-4{ flex:0 0 33.33%; max-width:33.33%; }   
    .field-label{ margin-bottom:8px; font-weight:700;}
    .field-group{ margin-bottom:20px;}
    textarea.field-control{ height:100px; resize:none;}
</style>
<div id="content" class="site-main post-2 page type-page status-publish hentry contact_us_wrapper">    
<div class="page-content">
<header class="page-header">
    <h2 class="entry-title"><?php wp_title(''); ?></h2>		
</header> 
 <div class="form_outer">		
        <form class="whitepaper_form">
			
			<div class="field-group radio-box">
				<label class="field-label"><input type="radio" name="payby" value="team-leader" /> <strong>Team Leader Edition</strong> </label>                
			</div>
			
			<div class="field-group radio-box">
				<label class="field-label"><input type="radio" name="payby"/ value="entrepreneur"> <strong>Entrepreneur </strong>  </label>                
			</div>
			<br />
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
			</div>
			<div class="form-row">
				 <div class="form-col col-12">
                    <div class="field-group">
                        <label class="field-label">Email Address <sup>*</sup></label>
                        <input class="field-control" type="email" placeholder="Email Address" />
                    </div>
                </div>
            </div><!-- row1 ends here -->
			
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
			<button type="button" class="btn btn-primary btn-submit">SIGN UP</button>
			</div>

        </form>
  </div>  
</div>
</div>
<?php get_footer(); ?>