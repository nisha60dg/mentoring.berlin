<?php
//Template Name:Schedule
get_header();

// 
?>


<main id="content" class="site-main" role="main">

    <div class="container" style="margin:0px !important;">
        <h1 class='text-center'>Schedule</h1>
        <div class="col text-center">
            <!-- When you would you like to receive your emails for your productname? -->
        </div>
        <form method='post' action="">
            <input type="hidden" name="mentoring_action" value="mentee_update">
            <div class="container">
                <div class="row border border-1 p-3 m-3 rounded-3" id='weekDays'>
                    <?php $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                    foreach ($weekdays as $key => $day) {
                    ?>
                        <div class="col p-1 m-2 border border-2 text-center">
                            <input type="checkbox" value='<?php echo $day; ?>' name='schedule_days[]' id='schedule_day_<?= $day; ?>'>
                            <label for=""><?php echo ucfirst($day); ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="container" style="margin:0px !important;">
                <div class="row ">
                    <?php
                    $startTime = strtotime("08:00");
                    $endTime = strtotime("20:00");
                    $loopTime = $startTime;
                    $index = 0;
                    while ($loopTime <= $endTime) { ?>
                        <div class="col p-1 m-2 border border-2 text-center">
                            <input class="form-check-input" type="checkbox" name="schedule_timings[]" id="checkboxNoLabel_<?= $index ?>" value=<?= date("H:i:s", $loopTime) ?> aria-label="...">
                            <label class="form-check-label" for="checkboxNoLabel_<?= $index ?>"><?php echo date("h:i A", $loopTime); ?></label>
                        </div>
                        <?php
                        $loopTime = strtotime('+60 minutes', $loopTime);
                        $index++;
                        ?>
                    <?php } ?>
                </div>
                <div class="col text-center">
                    <input type="submit" id="submitbtn" value='submit' class="btn btn-primary" name='submit'>
                </div>
        </form>
    </div>
</main>
<?php
get_footer();
?>