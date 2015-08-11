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

    li#types {
        float: left;
        width: 45%;
        overflow: hidden;
        margin-right: 10px;
    }

    li#statuses {
        float: left;
        width: 45%;
        overflow: hidden;
    }

    li#dates {
        clear: left;
    }

    .clear {
        clear: both;
    }

    div.cron {
        border: 1px dotted #ccc;
        padding: 5px;
    }

    #deletebutton,#deletebutton2 {
        margin: 10px;
    }

    -->
</style>
<div class="wrap"><h2>Find duplicates</h2>

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
    <div id="logtabs" class="container">
        <h3>Log:</h3>

        <div id="log"></div>
    </div>
    <form method="POST">
        <div class="container" id="options" class="form-wrap">

            <h3><?php echo __('Search settings','find-duplicates') ?></h3>
            <ul id="settings">
                <li><?php echo __('Get all posts with an <strong>content-similarity</strong> of more than:', 'find-duplicates') ?>
                    <strong><span id="similarity_amount"><?php echo $options['similarity'] ?></span>%</strong>

                    <div id="similarity"></div>
                </li>
                <input type="hidden" value="<?php echo $options['similarity'] ?>" name="similarity">
                <li id="types"><label
                    for="types"><?php echo __('Compare this <strong>type</strong>:', 'find-duplicates') ?></label><br/>
                    <?php
                    $post_types = get_post_types(array(), 'objects');
                    foreach ($post_types as $post_type) {
                        echo '<input type="radio" value="' . $post_type->name . '" name="types"';
                        if ($post_type->name == $options['types'])
                            echo " checked";
                        echo '> ' . $post_type->label . '<br /> ';
                    }
                    ?>
                </li>
                <li id="statuses"><?php echo __('Include these <strong>statuses</strong>:', 'find-duplicates') ?>
                    <br/>
                    <?php
                    $statuses = get_post_statuses();
                    foreach ($statuses as $key => $value) {
                        echo '<input name="status[]" type="checkbox" value="' . $key . '"';
                        if (in_array($key, $options['statuses']))
                            echo ' checked';
                        echo '> ' . $value . '<br />';
                    }
                    ?>
                </li>
                <li id="dates"><?php echo __('Limit by <strong>post date</strong>:', 'find-duplicates') ?><br/>
                    <?php echo __('from','find-duplicates') ?> <input id="datefrom" name="datefrom" class="datepicker" type="text"
                                value="<?php echo $options['datefrom'] ?>" readonly="readonly"> <?php echo __('until','find-duplicates') ?> <input
                        id="dateto" name="dateto" class="datepicker" type="text" value="<?php echo $options['dateto'] ?>" readonly="readonly">
                </li>
                <li>
                    <input name="onlytitle" id="onlytitle" type="checkbox" value="1"<?php echo ($options['onlytitle'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Compare post's titles instead of contents",'find-duplicates') ?><br />
                    <input name="filterhtml" id="filterhtml" type="checkbox" value="1"<?php echo ($options['filterhtml'] == 1) ? ' checked="checked"' : "" ?>> <?php echo __("Filter out HTML-Tags while comparing",'find-duplicates') ?>
                </li>
            </ul>

            <div id='ajax-loader' style="display:none"><img
                src="<?php echo plugins_url('ajax-loader.gif', __FILE__) ?>"/> <?php echo __('loading', 'find-duplicates') ?>
            </div>
            <input id="startbutton" class="button button-highlighted" type="button"
                   value="<?php echo __('Start new search', 'find-duplicates') ?>">
            <input class="button" type="button" value="<?php echo __('cancel', 'find-duplicates') ?>" id="cancel"
                   style="display:none">

            <input id="continuebutton" <?php
                if (count($options['done']) > 0) {
                    echo 'display: none';
                }
                ?> class="button" type="button" value="<?php echo __('Continue old search', 'find-duplicates') ?>">

            <div class="clear"></div>
        </div>

    </form>
    <div class="clear"></div>

    <br/>
    <?php
    printf(__('Compared %2$s of %3$s posts<br />Found %1$s duplicates', 'find-duplicates'), '<span id="found">0</span>', '<span id="done">0</span>', '<span id="count">0</span>');
    ?>
    <br/><input id="deletebutton" style="<?php if (count($options['found']) == 0) {echo 'display: none';} ?>" class="button" type="button" value="<?php echo __('Delete newer posts (to trash)', 'find-duplicates') ?>">
    <input id="deletebutton2" style="<?php if (count($options['found']) == 0) {echo 'display: none';} ?>" class="button" type="button" value="<?php echo __('Delete older posts (to trash)', 'find-duplicates') ?>">
    <table id="results" class="widefat">
        <thead>
        <tr>
            <th class="column-title"><?php echo __('similarity', 'find-duplicates') ?></th>
            <th><?php echo __('newer post', 'find-duplicates') ?></th>
            <th><?php echo __('older post', 'find-duplicates') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($options['found'] as $element) {
            echo'<tr class="resultrow" id="' . $element[0] . '" olderid="' . $element[1] . '">' .
                '<td>' . $element[2] . '%</td>' .
                '<td><a href="' . get_admin_url() . 'post.php?post=' . $element[0] . '&action=edit">' . get_the_title($element[0]) . ' (ID: ' . $element[0] . ')</a></td>' .
                '<td><a href="' . get_admin_url() . 'post.php?post=' . $element[1] . '&action=edit">' . get_the_title($element[1]) . ' (ID: ' . $element[1] . ')</a></td>' .
                '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>