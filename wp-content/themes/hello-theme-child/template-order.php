<?php
//Template Name:Order Page
get_header();
?>

<form method='post' action="" id="order_page" name="order_page">
    <div class="container-new" style="margin-left:20px">
        <div id="content" class="site-main post-2 page type-page status-publish hentry contact_us_wrapper">
            <div class="page-content">
                <div class="form_outer" style="border:2px solid #003893;">
                    <?php
                    if (mentoring()->Errors->get_errors()) 
                    {
                        mentoring()->Errors->print_errors();
                    }
                    ?>
                    <input type="hidden" name="mentoring_action" value="user_order">
                    <div class="form-row">
                        <div class="col-12 mt-2">
                            <div class="field-group check-box">
                                <label class="field-label">Hiermit bestätige ich, die</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 mt-2">
                            <div class="field-group check-box">
                                <label class="field-label"><input type="checkbox" name="privacy_policy" <?php echo (isset($_REQUEST['privacy_policy']) && $_REQUEST['privacy_policy'] == 'on') ? "checked" : "" ?> /> 
                                AGB gelesen und akzeptiert zu haben.  
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="field-group check-box">
                                <label class="field-label"><input type="checkbox" name="terms_conditions" <?php echo (isset($_REQUEST['terms_conditions']) && $_REQUEST['terms_conditions'] == 'on') ? "checked" : "" ?> /> 
                                Datenschutzbestimmungen gelesen und akzeptiert zu haben. 
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="field-group check-box">
                                <label class="field-label"><input type="checkbox" name="free_strategy_newsletter" <?php echo (isset($_REQUEST['free_strategy_newsletter']) && $_REQUEST['free_strategy_newsletter'] == 'on') ? "checked" : "" ?> />
                                Konditionen zur 30-Tage-Geld-zurück-Garantie gelesen und akzeptiert zu haben.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 mt-2">
                            <div class="field-group">
                                <label class="field-label">Bitte wähle Dein gewünschtes Mentoring-Paket: </label>
                                <label class="field-label">Regular Rate</label>
                                <p>
                                    Meetings in Berlin, München, Wien oder Zürich
                                    iMessage, FaceTime
                                    minutengenaue Abrechnung
                                </p>
                            </div>
                            <div class="field-group check-box">
                                <label class="field-label">
                                <input type="radio" name="package_rate" value="regular1_485" <?php echo (isset($_REQUEST['package_rate']) && $_REQUEST['package_rate'] == 'on') ? "checked" : "" ?> />
                                1 Stunde - Regular Rate - 485 Euro
                                </label> 
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 mt-2">
                            <div class="field-group">
                                <label class="field-label">Chilled Rate: </label>
                                <p>
                                Google Meet
                                Email
                                minutengenaue Abrechnung
                                </p>
                            </div>
                            <div class="field-group check-box">
                                <label class="field-label">
                                    <input type="radio" name="package_rate" value="chilled1_185" <?php echo (isset($_REQUEST['package_rate']) && $_REQUEST['package_rate'] == 'on') ? "checked" : "" ?> />
                                    1 Stunde - Chilled Rate - 185 Euro (meist gebucht)
                                </label>
                            </div>
                            <div class="field-group check-box">
                                <label class="field-label">
                                    <input type="radio" name="package_rate" value="chilled3_485" <?php echo (isset($_REQUEST['package_rate']) && $_REQUEST['package_rate'] == 'on') ? "checked" : "" ?> />
                                    3 Stunden - Chilled Rate - 485 Euro
                                </label>
                            </div>
                            <div class="field-group check-box">
                                <label class="field-label">
                                    <input type="radio" name="package_rate"  value="chilled7_985" <?php echo (isset($_REQUEST['package_rate']) && $_REQUEST['package_rate'] == 'on') ? "checked" : "" ?> />
                                    7 Stunden - Chilled Rate - 985 Euro
                                </label>
                            </div>
                        </div>
                    </div>
                     <div class="form-group text-center" style="margin:0px !important;">
                        <button type="submit" id="submitbtn" name='submitbtn' value="submit" class="btn btn-primary btn-submit">JETZT BUCHEN UND PER KREDITKARTE ZAHLEN</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</form>
<?php
get_footer();
?>