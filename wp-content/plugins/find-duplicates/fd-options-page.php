<?php
$options = get_option('find_duplicates_data');
?>

<style>
    <!--
    #logtabs {
        max-width: 350px;
        width: 350px;
        float: right;
        height: 300px;
    }

    #log, #cronlog {
        overflow-y: scroll;
        height: 238px;
    }

    .container {
        border: 1px dotted #ccc;
        padding: 0 10px 10px 10px;
        margin: 10px
    }

    #options {
        width: 480px;
        float: left;
    }

    #settings li {
        margin: 10px 0;
        padding: 5px;
        background-color: #f5f5f5;
    }

    .clear {
        clear: both;
    }

    div.cron {
        border: 1px dotted #ccc;
        padding: 5px;
    }

    #deletebutton {
        margin: 10px;
    }

    -->
</style>


<div class="wrap"><h2>Find duplicates - <?php echo __('Settings','find-duplicates') ?></h2>

    <div id="donation" class="container">
        <h3><?php echo __('Say "Thank you"','find-duplicates') ?></h3>
        <?php echo __('Say "Thank you" and further more free plugins!', 'find-duplicates'); ?>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="4S7SVMALSSZ2Y">
            <input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donate_SM.gif" border="0"
                   name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
            <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
        </form>
    </div>
    <form method="POST">
        <div class="container" id="options" class="form-wrap">

            <h3><?php echo __('Automatic duplicate handling','find-duplicates') ?></h3>
            <ul id="settings">
                <li>
                    <input name="auto_active" id="auto_active" type="checkbox" value="1"<?php echo ($options['auto_active'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __('Activate automatic post handling', 'find-duplicates') ?>
                <p><?php echo __('Set all posts matching the following criteria as "pending" directly after publishing it.','find-duplicates') ?></p></li>
                <li id="types"><label for="types"><?php echo __('Activate for these <strong>types</strong>:', 'find-duplicates') ?></label><br/>
                    <?php
                    $post_types = get_post_types(array(), 'objects');
                    foreach ($post_types as $post_type) {
                        echo '<input type="checkbox" value="' . $post_type->name . '" name="auto_types[]"';
                        if (in_array($post_type->name, $options['auto_types']))
                            echo " checked";
                        echo '> ' . $post_type->label . '<br /> ';
                    }
                    ?>
                </li>
                <li><?php echo __('Delete all posts with an <strong>content-similarity</strong> of more than:', 'find-duplicates') ?>
                    <strong><span id="auto_similarity_amount"><?php echo $options['auto_similarity'] ?></span>%</strong>

                    <div id="auto_similarity"></div>
                    <input type="hidden" value="<?php echo $options['auto_similarity'] ?>" name="auto_similarity">
                </li>
                <li id="statuses"><?php echo __('Include these <strong>statuses</strong>:', 'find-duplicates') ?>
                    <br/>
                    <?php
                    $statuses = get_post_statuses();
                    foreach ($statuses as $key => $value) {
                        echo '<input name="auto_status[]" type="checkbox" value="' . $key . '"';
                        if (in_array($key, $options['auto_statuses']))
                            echo ' checked';
                        echo '> ' . $value . '<br />';
                    }
                    ?>
                </li>
                <li id="dates"><?php echo __('Limit by <strong>post date</strong>:', 'find-duplicates') ?><br/>
                    <?php echo __('from','find-duplicates') ?> <input id="auto_datefrom" name="auto_datefrom" class="datepicker" type="text"
                                value="<?php echo $options['auto_datefrom'] ?>" readonly="readonly"> <?php echo __('until','find-duplicates') ?> <input
                        id="auto_dateto" name="auto_dateto" class="datepicker" type="text" value="<?php echo $options['auto_dateto'] ?>" readonly="readonly">
                </li>
                <li>
                    <input name="auto_onlytitle" id="auto_onlytitle" type="checkbox" value="1"<?php echo ($options['auto_onlytitle'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Compare post's titles instead of contents",'find-duplicates') ?><br />
                    <input name="auto_filterhtml" id="auto_filterhtml" type="checkbox" value="1"<?php echo ($options['auto_filterhtml'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Filter out HTML-Tags while comparing",'find-duplicates') ?>
                </li>
                <li>
                    <div style="height:100px;overflow: scroll;">
                        LOG:<br />
                        <?php
                            $log = get_option('find_duplicates_auto_log',"");
                            echo $log;
                        ?>
                    </div>
                </li>
            </ul>
        </div>

        <div class="container" id="options" class="form-wrap">

            <h3><?php echo __('Manual duplicate handling','find-duplicates') ?></h3>
            <ul id="settings">
                <li>
                    <input name="meta_active" id="meta_active" type="checkbox" value="1"<?php echo ($options['meta_active'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __('Activate manual post handling', 'find-duplicates') ?>
                    <p><?php echo __('Allows you to check for similar entries before publishing an post.','find-duplicates') ?></p></li>
                <li id="types"><label for="types"><?php echo __('Activate for these <strong>types</strong>:', 'find-duplicates') ?></label><br/>
                    <?php
                    $post_types = get_post_types(array(), 'objects');
                    foreach ($post_types as $post_type) {
                        echo '<input type="checkbox" value="' . $post_type->name . '" name="meta_types[]"';
                        if (in_array($post_type->name, $options['meta_types']))
                            echo " checked";
                        echo '> ' . $post_type->label . '<br /> ';
                    }
                    ?>
                </li>
                <li><?php echo __('Include all posts with an <strong>content-similarity</strong> of more than:', 'find-duplicates') ?>
                    <strong><span id="meta_similarity_amount"><?php echo $options['meta_similarity'] ?></span>%</strong>

                    <div id="meta_similarity"></div>
                    <input type="hidden" value="<?php echo $options['meta_similarity'] ?>" name="meta_similarity">
                </li>
                <li id="statuses"><?php echo __('Include these <strong>statuses</strong>:', 'find-duplicates') ?>
                    <br/>
                    <?php
                    $statuses = get_post_statuses();
                    foreach ($statuses as $key => $value) {
                        echo '<input name="meta_status[]" type="checkbox" value="' . $key . '"';
                        if (in_array($key, $options['meta_statuses']))
                            echo ' checked';
                        echo '> ' . $value . '<br />';
                    }
                    ?>
                </li>
                <li id="dates"><?php echo __('Limit by <strong>post date</strong>:', 'find-duplicates') ?><br/>
                    <?php echo __('from','find-duplicates') ?> <input id="meta_datefrom" name="meta_datefrom" class="datepicker" type="text"
                                                               value="<?php echo $options['meta_datefrom'] ?>" readonly="readonly"> <?php echo __('until','find-duplicates') ?> <input
                        id="meta_dateto" name="meta_dateto" class="datepicker" type="text" value="<?php echo $options['meta_dateto'] ?>" readonly="readonly">
                </li>
                <li>
                    <input name="meta_onlytitle" id="meta_onlytitle" type="checkbox" value="1"<?php echo ($options['meta_onlytitle'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Compare post's titles instead of contents",'find-duplicates') ?><br />
                    <input name="meta_filterhtml" id="meta_filterhtml" type="checkbox" value="1"<?php echo ($options['meta_filterhtml'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Filter out HTML-Tags while comparing",'find-duplicates') ?>
                </li>
            </ul>

        </div>

        <div class="clear"></div>
    <input id="save" title="for searching while editing posts" class="button button-highlighted" type="submit"
           name="save" value="<?php echo __('Save settings', 'find-duplicates') ?>">
    </form>

</div>

    <script>

    jQuery(document).ready(function () {
        jQuery( "#auto_similarity" ).slider({
            min:50,
            max:100,
            value:jQuery( "input[name='auto_similarity']" ).val(),
            change: function( event, ui ) {
                jQuery( "#auto_similarity_amount" ).html( ui.value );
                jQuery( "input[name='auto_similarity']" ).val( ui.value );
            }
        });
        jQuery( "#meta_similarity" ).slider({
            min:50,
            max:100,
            value:jQuery( "input[name='meta_similarity']" ).val(),
            change: function( event, ui ) {
                jQuery( "#meta_similarity_amount" ).html( ui.value );
                jQuery( "input[name='meta_similarity']" ).val( ui.value );
            }
        });
        jQuery( "#auto_similarity_amount" ).html( jQuery("#auto_similarity").slider("value") );
        jQuery( "#meta_similarity_amount" ).html( jQuery("#meta_similarity").slider("value") );

        jQuery(function() {
            var dates = jQuery( "#auto_datefrom, #auto_dateto" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                dateFormat: "yy-mm-dd",
                clearText: 'löschen', clearStatus: 'aktuelles Datum löschen',
                showOn: "button",
                buttonImage: "images/date-button.gif",
                buttonImageOnly: true,
                showButtonPanel: true,
                beforeShow: function( input ) {
                    setTimeout(function() {
                        var buttonPane = jQuery(input)
                            .datepicker( "widget" )
                            .find( ".ui-datepicker-buttonpane" );

                        var btn = jQuery('<button class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" type="button">Clear</button>');
                        btn
                            .unbind("click")
                            .bind("click", function () {
                                jQuery.datepicker._clearDate( input );
                                jQuery(input).val("");
                            });

                        btn.appendTo( buttonPane );

                    }, 1 );
                },
                //numberOfMonths: 1,
                onSelect: function( selectedDate ) {
                    var option = this.id == "auto_datefrom" ? "minDate" : "maxDate",
                        instance = jQuery( this ).data( "datepicker" ),
                        date = jQuery.datepicker.parseDate(
                            instance.settings.dateFormat ||
                                jQuery.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings );
                    dates.not( this ).datepicker( "option", option, date );
                }
            });
        });

        jQuery(function() {
            var dates = jQuery( "#meta_datefrom, #meta_dateto" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                dateFormat: "yy-mm-dd",
                clearText: 'löschen', clearStatus: 'aktuelles Datum löschen',
                showOn: "button",
                buttonImage: "images/date-button.gif",
                buttonImageOnly: true,
                showButtonPanel: true,
                beforeShow: function( input ) {
                    setTimeout(function() {
                        var buttonPane = jQuery(input)
                            .datepicker( "widget" )
                            .find( ".ui-datepicker-buttonpane" );

                        var btn = jQuery('<button class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" type="button">Clear</button>');
                        btn
                            .unbind("click")
                            .bind("click", function () {
                                jQuery.datepicker._clearDate( input );
                                jQuery(input).val("");
                            });

                        btn.appendTo( buttonPane );

                    }, 1 );
                },
                //numberOfMonths: 1,
                onSelect: function( selectedDate ) {
                    var option = this.id == "meta_datefrom" ? "minDate" : "maxDate",
                        instance = jQuery( this ).data( "datepicker" ),
                        date = jQuery.datepicker.parseDate(
                            instance.settings.dateFormat ||
                                jQuery.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings );
                    dates.not( this ).datepicker( "option", option, date );
                }
            });
        });
    });
    </script>