<?php
//Template Name:Login Page
get_header(); 
?>

<style>
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
        margin-bottom: 20px;
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
<form method='post' action="" id="login_page" name="user_login">
    <header class="page-header text-center">
            <h2 class="entry-title">User Login</h2>
    </header>
    <div class="container" style=" max-width: 70%;">
        <div id="content" class="site-main post-2 page type-page status-publish hentry contact_us_wrapper">
            <div class="page-content">
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
                    <input type="hidden" name="mentoring_action" value="user_login">
                    <div class="form-row">
                        <div class="form-col col-12">
                            <div class="field-group">
                                <label class="field-label">Email Address <sup>*</sup></label>
                                <input class="field-control" type="text" placeholder="Email Address" name="email" id="email" value="<?= (isset($_REQUEST['email'])) ? $_REQUEST['email'] : '' ?>" />
                                <small style="color: red;"></small>
                            </div>
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-col col-12">
                            <div class="field-group">
                                <label class="field-label" for="password">Password<sup>*</sup></label>
                                <input class="field-control" type="password" placeholder="Password" name="password" id="password" value="<?= (isset($_REQUEST['password'])) ? $_REQUEST['password'] : '' ?>" />
                                <small style="color: red;"></small>
                            </div>
                        </div>
                    </div>

                     <div class="form-group text-center" style="margin:0px !important;">
                        <button type="submit" id="submitbtn" name='submitbtn' value="submit" class="btn btn-primary btn-submit">Login</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</form>
<?php
get_footer();
?>