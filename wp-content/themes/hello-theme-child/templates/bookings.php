<?php 
/**
* Template Name: Bookings
*
*/

get_header();
?>
<style>
    .page-header{background: #003893; color: #fff; text-align: center; padding: 15px 0;}
    .page-header .entry-title{ margin:0; max-width: 100%;}
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
<div id="content" class="site-main post-2 page type-page status-publish hentry bookings_wrapper">    
    <div class="page-content">		
        <form class="booking_form">
            <div class="form-row">
                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">Full Name<sup>*</sup></label>
                        <input class="field-control" type="text" placeholder="Full Name" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">Email ID<sup>*</sup></label>
                        <input class="field-control" type="email" placeholder="Full Name" />
                    </div>
                </div>
            </div><!-- row1 ends here -->

            <div class="form-row">
                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">My project in one sentence</label>
                        <textarea class="field-control"></textarea>
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">My goals for this mentoring</label>
                        <textarea class="field-control" ></textarea>
                    </div>
                </div>
            </div><!-- row2 ends here -->

            <h4>My billing details:</h4>
            <div class="form-row">
                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">Company name</label>
                        <input class="field-control" type="text" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">UID</label>
                        <input class="field-control" type="text" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">First name</label>
                        <input class="field-control" type="text" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">Last name</label>
                        <input class="field-control" type="text" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">Street address (line 1)</label>
                        <input class="field-control" type="text" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">Street address (line 2)</label>
                        <input class="field-control" type="text" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">City</label>
                        <input class="field-control" type="text" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">State or Province</label>
                        <input class="field-control" type="text" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">Postal Code</label>
                        <input class="field-control" type="text" />
                    </div>
                </div>

                <div class="form-col col-6">
                    <div class="field-group">
                        <label class="field-label">Country</label>
                        <select class="field-control">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div><!-- row3 ends here -->

            <div class="field-group">
                <label class="field-label"><input type="checkbox"/> I have read and accept the terms and conditions.</label>                
            </div>
            <div class="field-group">
                <label class="field-label"><input type="checkbox"/> I have read and accept the privacy policy.</label>                
            </div>

            <div class="field-group">
                <label class="field-label"><input type="radio" name="payby"/> I'd like to pay the 25 Euros by debit or credit card. </label>                
            </div>
            <div class="field-group">
                <label class="field-label"><input type="radio" name="payby"/> I'd like to pay the 25 Euros by Ethereum or Shiba Inu. </label>                
            </div>

        </form>
    </div>
</div>

<?php get_footer(); ?>