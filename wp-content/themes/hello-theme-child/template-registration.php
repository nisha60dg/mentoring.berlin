<?php
// pr(get_permalink(1237));die;
if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])) {
    $response = mentoring()->RESTAPI->Products->get($_REQUEST['product_id']);
    if ($response->status != 1) {
        $errors = array();
        $errors['product_service'] = "Something went wrong please select valid product";
    }
}
//Template Name:Registration
get_header();
?>

<style>
    .container{
        margin-top:10px !important;
    }
    .page-header .entry-title {
        margin: 0;
        /* max-width: 100%; */
        font-weight: 600;
        color: #003893;
        margin-top: 30px;
        /* margin-left: 150px; */
    }

    .entry-title {
        color: #003893;
    }

    .page-content .form_outer {
        margin-top: 20px !important;
        margin-bottom: -50px !important;
    }

    .whitepaper_form {
        padding-bottom: 40px 0;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -15px;
        margin-right: -15px;
    }

    .form-col {
        padding-left: 15px;
        padding-right: 15px;
    }

    .col-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .col-4 {
        flex: 0 0 33.33%;
        max-width: 33.33%;
    }

    .field-label {
        margin-bottom: 8px;
        font-weight: 700;
    }

    .field-group {
        margin-bottom: 15px;
    }

    textarea.field-control {
        height: 100px;
        resize: none;
    }

    /*
    .button {
        position: absolute;
        top: 42%;
        left: 20px;
        display: inline-block;
        background: #ddd;
        border: 1px solid #ccc;
        padding: 5px 10px;
        text-decoration: none;
        color: #003893;
        cursor: pointer;
        margin: 5px;
        border-radius: 10px;
        
    }
 
    
    .myCheckbox {
        position: absolute;
        left: 5px;
        bottom: 50%;
        top: 20%
    }
    */
    .btn-label {
        background-color: #ddd;
        border-color: #ccc;
        color: #003893;
        width: 120%;
        /* padding-left: 36px; */
    }

    .btn-box {
        position: relative;
    }

    .myCheckbox {
        position: absolute;
        left: 25px;
        bottom: 20px;
        /* top: -3; */
    }
</style>
<form method='post' action="" id="register_page" name="user_register">
   <!-- <header class="page-header text-center">
        <?php
        if (isset($response->data->product_title) && !empty($response->data->product_title) && isset($response->data->excerpt) && !empty($response->data->excerpt)) {
        ?>
            <h2 class="entry-title"><?php wp_title(''); ?> | <?= $response->data->product_title ?> | <?= $response->data->excerpt ?></h2>
            <h4 class="entry-title" style="color:#ff9100; margin-top: 20px;"><?= $response->data->short_description ?> | <strong style="color:#003893 !important;"><?= $response->data->product_price ?> EUR</strong></h4>
        <?php } else {
        ?>
            <h2 class="entry-title">Registration</h2>
        <?php } ?>
    </header> -->
    <div class="container" style=" max-width: 70%;">
        <div id="content" class="site-main post-2 page type-page status-publish hentry contact_us_wrapper">
            <div class="page-content">
                <h3>Register yourself</h3>
                <?php if (!empty($errors)) {
                ?>
                    <h3 class="text-center text-danger"><?= $errors['product_service'] ?></h3>
                <?php } ?>

                <div class="form_outer" style="border:2px solid #003893;">
                    <?php
                    if (mentoring()->Errors->get_errors()) {
                        mentoring()->Errors->print_errors();
                    }
                    ?>
                    <input type="hidden" name="mentoring_action" value="user_registration">
                    <div class="form-row">
                        <div class="form-col col-3">
                            <div class="field-group">
                                <label class="field-label" for="first_name">First Name<sup>*</sup></label>
                                <input class="field-control" type="text" placeholder="Full Name" name="first_name" id="first_name" value="<?= (isset($_REQUEST['first_name'])) ? $_REQUEST['first_name'] : '' ?>" />
                                <small style="color: red;"></small>
                            </div>
                        </div>
                        <div class="form-col col-3">
                            <div class="field-group">
                                <label class="field-label" for="last_name">Last Name<sup>*</sup></label>
                                <input class="field-control" type="text" placeholder="Last Name" name="last_name" id="last_name" value="<?= (isset($_REQUEST['last_name'])) ? $_REQUEST['last_name'] : '' ?>" />
                                <small style="color: red;"></small>
                            </div>
                        </div>
                        <div class="form-col col-6">
                            <div class="field-group">
                                <label class="field-label">Email Address <sup>*</sup></label>
                                <input class="field-control" type="text" placeholder="Email Address" name="user_email" id="user_email" value="<?= (isset($_REQUEST['user_email'])) ? $_REQUEST['user_email'] : '' ?>" />
                                <small style="color: red;"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <?php if (isset($_REQUEST['product_id'])) { ?>
                            <input type='hidden' name='product_service' id='product_service' value="<?= $_REQUEST['product_id'] ?>">
                        <?php } ?>
                    </div>

                     <div class="form-row">
                        <div class="form-col col-6">
                            <div class="field-group">
                                <label class="field-label" for="password">Password<sup>*</sup></label>
                                <input class="field-control" type="password" placeholder="Password" name="user_password" id="password" value="<?= (isset($_REQUEST['password'])) ? $_REQUEST['password'] : '' ?>" />
                                <small style="color: red;"></small>
                            </div>
                        </div>
                        <div class="form-col col-6">
                            <div class="field-group">
                                <label class="field-label" for="last_name">Confirm Password<sup>*</sup></label>
                                <input class="field-control" type="password" placeholder="Confirm Password" name="user_confirm_password" id="last_name" value="<?= (isset($_REQUEST['confirm_password'])) ? $_REQUEST['confirm_password'] : '' ?>" />
                                <small style="color: red;"></small>
                            </div>
                        </div>
                    </div>

                     <div class="form-row">
                        <div class="col-12 mt-1">
                            <div class="field-group check-box">
                                <label class="field-label"><input type="checkbox" name="privacy_policy" <?php echo (isset($_REQUEST['privacy_policy']) && $_REQUEST['privacy_policy'] == 'on') ? "checked" : "" ?> /> I have read and accepted the privacy policy. </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="field-group check-box">
                                <label class="field-label"><input type="checkbox" name="terms_conditions" <?php echo (isset($_REQUEST['terms_conditions']) && $_REQUEST['terms_conditions'] == 'on') ? "checked" : "" ?> /> I have read and accept the terms and conditions. </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="field-group check-box">
                                <label class="field-label"><input type="checkbox" name="free_strategy_newsletter" <?php echo (isset($_REQUEST['free_strategy_newsletter']) && $_REQUEST['free_strategy_newsletter'] == 'on') ? "checked" : "" ?> /> I would like to be added to the free strategy newsletter. </label>
                            </div>
                        </div>
                    </div>

                     <div class="form-group text-center" style="margin:0px !important;">
                        <button type="submit" id="submitbtn" name='submitbtn' value="submit" class="btn btn-primary btn-submit">SIGN UP</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</form>
<?php

get_footer();
?>