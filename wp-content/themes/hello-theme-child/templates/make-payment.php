<?php
if (isset($_REQUEST['package']) && !empty($_REQUEST['package'])) {
    $package = $_REQUEST['package'];
    
    if($package=='regular1_485'){
        $package_name = '1 Stunde - Regular Rate';
        $package_price = 485;
        $package_hour = 60;
    }elseif($package=='chilled1_185'){
        $package_name = '1 Stunde - Chilled Rate';
        $package_price = 185;
        $package_hour = 60;
    }elseif($package=='chilled3_485'){
        $package_name = '3 Stunden - Chilled Rate';
        $package_price = 485;
        $package_hour = 180;
    }elseif($package=='chilled7_985'){
        $package_name = '7 Stunden - Chilled Rate';
        $package_price = 985;
        $package_hour = 420;
    }
    
}
/*if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])) {
    $responseProduct = mentoring()->RESTAPI->Products->get($_REQUEST['product_id']);
    if ($responseProduct->status != 1) {
        wp_redirect(get_permalink(1207) . "?product_id=" . $_REQUEST['product_id']);
        exit();
    }
}
if (!isset($_COOKIE['user_id']) || empty($_COOKIE['user_id'])) {
    wp_redirect(get_permalink(1207) . "?" . $_SERVER['QUERY_STRING']);
}*/
//Template Name:Make Payment

get_header();
?>

<div id="content" class="site-main post-2 page type-page status-publish hentry contact_us_wrapper">
    <div class="page-content">
       <!-- <header class="page-header text-center">
            <h2 class="entry-title"><?php wp_title(''); ?></h2>
        </header> -->
        <?php
        if (isset($_SESSION["message"]) && $_SESSION["message"] && $_SESSION["message"] == 'failed') {
        ?>
            <div class="alert alert-danger">
                <?php
                echo "Error : Payment failed!";
                $_SESSION["message"] = '';
                ?>
            </div>
        <?php
        } elseif (isset($_SESSION["message"]) && $_SESSION["message"]) {
        ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION["message"];
                $_SESSION["message"] = '';
                ?>
            </div>
        <?php } ?>
        <div class="container" width="70%">
            
            <div class="row">
               
                <div class="col-4">
                <h4 align="center">Order Details</h4>
                    <div class="table-responsive" id="order_table">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Package</th>
                                    <th><strong><?= $package_name ?></strong> - <strong><?= $package_price ?> EUR</strong></th>
                                </tr>
                                <tr>
                                    <td>Amount</td>
                                    <td>EUR <?= $package_price ?></td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-8">
                <form action="" method="POST" id="paymentForm">
              
                    <div class="form">
                        <h4 align="center">Payment Details</h4>
                        <div class="form-group">
                            <label>Card Number <span class="text-danger">*</span></label>
                            <input type="text" id="cardNumber" class="form-control" placeholder="1234 5678 9012 3456" maxlength="20" />
                            <span id="errorCardNumber" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Expiry Month</label>
                                    <select name="cardExpMonth" id="cardExpMonth" class="">
                                        <option value="">~Select Month~</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                    <!-- <input type="text" placeholder="MM"class="form-control" placeholder="MM" maxlength="2" /> -->
                                    <span id="errorCardExpMonth" class="text-danger"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>Expiry Year</label>
                                    <select name="cardExpYear" id="cardExpYear" class="">
                                        <option value="">~Select Year~</option>
                                        <?php 
                                        $cur_year = date("Y");
                                        for($cur_year;$cur_year<=2035;$cur_year++):
                                        ?>
                                        <option value="<?php echo $cur_year; ?>"><?php echo $cur_year; ?></option>
                                        <?php endfor; ?>
                                        
                                    </select>
                                    <!-- <input type="text" placeholder="YY" id="cardExpYear" class="form-control" placeholder="YYYY" maxlength="4" /> -->
                                    <span id="errorCardExpYear" class="text-danger"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>CVC</label>
                                    <input type="text" id="cardCVC" class="form-control" placeholder="123" maxlength="3" />
                                    <span id="errorCardCvc" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                     
                        <div align="center">
                            <input type="hidden" name="price" value="<?= $package_price ?>">
                            <input type="hidden" name="total_amount" value="<?= $package_price ?>">
                            <input type="hidden" name="currency_code" value="EUR">
                            <input type="hidden" name="item_details" value="<?= $package_name ?>">
                            <input type="hidden" name="item_number" value="<?= $package_hour ?>">
                            <input type="hidden" name="order_number" value="">
                            <input type="hidden" name="mentoring_action" value="make_payment">
                            <input type="hidden" id="makePayment" class="btn btn-success" value="Make Payment">
                            <input type="submit" name="sumbit" id="payNow" class="btn btn-primary btn-bg" onclick="stripePay(event)" value="Pay Now" style="border: none;font-weight: 700;margin-top: 24px;font-family:  Nunito Sans, Sans-serif; color: #fff; background-color: #003893; letter-spacing: 0.4px; padding: 15px 40px;" />
                        </div>
                     
                    </div>

               
            </form>
                </div>

            </div>
           

        </div>
    </div>
</div>
<?php
get_footer(); 
?>