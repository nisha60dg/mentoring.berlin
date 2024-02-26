<form method='post' action="" id="application_page" name="application_page">
    <div class="container-new" style=" max-width: 60%;margin-left:20px">
        <div id="content" class="site-main post-2 page type-page status-publish hentry contact_us_wrapper">
            <div class="page-content">
                <div class="form_outer" style="border:2px solid #003893;">
                    <?php
                    if (mentoring()->Errors->get_errors()) 
                    {
                        mentoring()->Errors->print_errors();
                    }
                    $user_name = do_shortcode("[read_user_cookie var='only_name']");
                    $user_email = do_shortcode("[read_user_cookie var='email']");
                    if(!empty($user_email))
                    $readonly = 'readonly';
                    else
                    $readonly = '';
                    ?>
                    <input type="hidden" name="mentoring_action" value="user_application">
                    <div class="form-row">
                        <div class="form-col col-12">
                            <div class="field-group">
                                <label class="field-label">Vorname <sup>*</sup></label>
                                <input class="field-control" type="text"  name="name" id="name" value="<?= (isset($_REQUEST['name'])) ? $_REQUEST['name'] : $user_name ?>" />
                                <small style="color: red;"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col col-12">
                            <div class="field-group">
                                <label class="field-label">Email <sup>*</sup></label>
                                <input class="field-control" type="text" name="email" id="email" <?= $readonly ?> value="<?= (isset($_REQUEST['email'])) ? $_REQUEST['email'] : $user_email ?>" />
                                <small style="color: red;"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col col-12">
                            <div class="field-group">
                                <label class="field-label" for="project_dec">Beschreibe Dein Projekt in 100 bis 200 Worten.<sup>*</sup></label>
                                <textarea class="field-control" name="project_dec" id="project_dec"><?= (isset($_REQUEST['project_dec'])) ? $_REQUEST['project_dec'] : '' ?></textarea>
                                <small style="color: red;"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col col-12">
                            <div class="field-group">
                                <label class="field-label" for="mentoring_dec">Was erwartest Du Dir von unserem Mentoring?</label>
                                <textarea class="field-control" name="mentoring_dec" id="mentoring_dec"><?= (isset($_REQUEST['mentoring_dec'])) ? $_REQUEST['mentoring_dec'] : '' ?></textarea>
                                <small style="color: red;"></small>
                            </div>
                        </div>
                    </div>
                     <div class="form-group text-center" style="margin:0px !important;">
                        <button type="submit" id="submitbtn" name='submitbtn' value="submit" class="btn btn-primary btn-submit">Bewerbung absenden</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</form>