<?php
/*
Plugin Name: Find duplicates
Description: A plugin that finds duplicate and similar posts based on their post_content or post_title similarity. You can define the percentage of similarity, post type and post status. The plugin is a great utility to find duplicates that differ in only a few characters.
Version: 1.3
Author: Markus Seyer
Plugin URI: http://www.markusseyer.de
Author URI: http://www.markusseyer.de
*/

add_action('init', 'fd_init');

function fd_init()
{
    add_action('save_post', 'fd_save_post');
}


add_action('admin_menu', 'add_fd_page');
add_action('admin_init', 'fd_admin_init');
add_action('post_submitbox_misc_actions', 'output_fd_meta');
add_action('wp_ajax_get_duplicate_results', 'get_duplicate_results');
add_action('wp_ajax_get_duplicate_results_meta', 'get_duplicate_results_meta');
add_action('wp_ajax_get_posts_count', 'get_posts_count');
add_action('wp_ajax_remove_result', 'remove_result');
register_deactivation_hook(__FILE__, 'fd_deactivation');
register_activation_hook(__FILE__, 'fd_activation');

function add_fd_page()
{
    $page = add_management_page('Find duplicates', 'Find duplicates', 'manage_options', __FILE__, 'output_fd_page');
    add_action('admin_print_styles-' . $page, 'load_javascript');
    $page = add_options_page('Find duplicates', 'Find duplicates', 'manage_options', __FILE__, 'output_fd_options_page');
    add_action('admin_print_styles-' . $page, 'load_javascript_options');
}

function load_javascript()
{
    wp_enqueue_script('find-duplicates-js');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('jquery-ui-datepicker');
}

function load_javascript_options()
{
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('jquery-ui-datepicker');
}

function fd_admin_init()
{
    wp_register_script('find-duplicates-js', plugins_url('/js/find-duplicates-page.js', __FILE__));
    wp_register_script('find-duplicates-js-meta', plugins_url('/js/find-duplicates-meta.js', __FILE__));
    load_plugin_textdomain('find-duplicates', false, basename(dirname(__FILE__)) . '/languages');
    wp_enqueue_style('find-duplicates-css', plugins_url('css/smoothness/jquery-ui.min.css', __FILE__));
}

function output_fd_page()
{
    if (!current_user_can('edit_posts')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    include($plugin_dir_path = dirname(__FILE__) . '/find-duplicates-page.php');
}

function output_fd_options_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    if (isset($_POST['save'])) {
        $options = get_option('find_duplicates_data', array());
        $options['auto_active'] = isset($_POST['auto_active']) ? 1 : 0;
        $options['auto_datefrom'] = $_POST['auto_datefrom'];
        $options['auto_dateto'] = $_POST['auto_dateto'];
        $options['auto_statuses'] = isset($_POST['auto_status']) ? $_POST['auto_status'] : array();
        $options['auto_types'] = isset($_POST['auto_types']) ? $_POST['auto_types'] : array();
        $options['auto_similarity'] = $_POST['auto_similarity'];
        $options['auto_onlytitle'] = isset($_POST['auto_onlytitle']) ? 1 : 0;
        $options['auto_filterhtml'] = isset($_POST['auto_filterhtml']) ? 1 : 0;
        $options['meta_active'] = isset($_POST['meta_active']) ? 1 : 0;
        $options['meta_datefrom'] = $_POST['meta_datefrom'];
        $options['meta_dateto'] = $_POST['meta_dateto'];
        $options['meta_statuses'] = isset($_POST['meta_status']) ? $_POST['meta_status'] : array();
        $options['meta_types'] = isset($_POST['meta_types']) ? $_POST['meta_types'] : array();
        $options['meta_similarity'] = $_POST['meta_similarity'];
        $options['meta_onlytitle'] = isset($_POST['meta_onlytitle']) ? 1 : 0;
        $options['meta_filterhtml'] = isset($_POST['meta_filterhtml']) ? 1 : 0;

        update_option('find_duplicates_data', $options);
    }
    include($plugin_dir_path = dirname(__FILE__) . '/fd-options-page.php');
}

function find_similar_posts()
{
    $log = "";
    $new_duplicates = array();
    $limit = 1000;
    $options = get_option('find_duplicates_data', array());
    // get Posts
    $post_status = implode("','", $options['statuses']);
    $excludes = implode("','", $options['done']);
    $datewhere = "";
    if (!empty($options['datefrom'])) {
        $datewhere .= "post_date>='" . $options['datefrom'] . " 00:00:00" . "' AND ";
    }

    if (!empty($options['dateto'])) {
        $datewhere .= "post_date<='" . $options['dateto'] . " 23:59:59" . "' AND ";
    }
    $post2_offset = $options['post2_offset'];
    global $wpdb;
    $posts = $wpdb->get_results("SELECT ID,post_title,post_date,post_content FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $options['types'] . "' AND post_status IN('" . $post_status . "') AND ID NOT IN('" . $excludes . "') LIMIT 1");
    $allPosts_count = $wpdb->get_results("SELECT COUNT(ID) as count FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $options['types'] . "' AND post_status IN('" . $post_status . "') AND ID NOT IN('" . $excludes . "')");
    $allPosts_count = $allPosts_count[0]->count;
    $allPosts = $wpdb->get_results("SELECT ID,post_title,post_date,post_content FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $options['types'] . "' AND post_status IN('" . $post_status . "') AND ID NOT IN('" . $excludes . "') LIMIT " . $post2_offset . "," . $limit);
    if ($allPosts_count >= ($options['post2_offset'] + $limit)   AND $allPosts_count > $limit) {
        $options['post2_offset'] = $options['post2_offset'] + $limit;
    } else {
        $options['post2_offset'] = 0;
    }
    // END get Posts

    foreach ($posts as $post) {
        $log .= "Comparing post " . $post->ID . " with " . $post2_offset . "-" . ($post2_offset + $limit) . "<br />";
        foreach ($allPosts as $post2) {
            if ($post2->ID != $post->ID AND !in_array($post2->ID, $options['done'])) {
                if ($options['onlytitle'] == 1) {
                    $post_compare = $post->post_title;
                    $post2_compare = $post2->post_title;
                } else {
                    $post_compare = $post->post_content;
                    $post2_compare = $post2->post_content;
                }
                if ($options['filterhtml'] == 1) {
                    $post_compare = strip_tags($post_compare);
                    $post2_compare = strip_tags($post2_compare);
                }
                $lenDiff = strlen($post_compare) - strlen($post2_compare);
                if ($lenDiff > -200 AND $lenDiff < 200) {
                    similar_text($post2_compare, $post_compare, $p);
                    if ($p > $options['similarity']) {
                        if (strtotime($post->post_date) > strtotime($post2->post_date)) {
                            $options['found'][] = array($post->ID, $post2->ID, intval(round($p)));
                            $new_duplicates[] = array($post->ID, $post2->ID, intval(round($p)), get_admin_url(), $post->post_title, $post2->post_title);
                        } else {
                            $options['found'][] = array($post2->ID, $post->ID, intval(round($p)));
                            $new_duplicates[] = array($post2->ID, $post->ID, intval(round($p)), get_admin_url(), $post2->post_title, $post->post_title);
                        }
                    }
                }
            }
        }
        if ($options['post2_offset'] == 0) {
            $options['done'][] = $post->ID;
        }
    }

    update_option('find_duplicates_data', $options);
    return json_encode(array(count($options['done']), $log, $new_duplicates, count($options['found'])));
}


function get_duplicate_results()
{
    if ($_POST['startnew'] == 1) {
        $options = get_option('find_duplicates_data', array());
        $options['onlytitle'] = $_POST['onlytitle'];
        $options['datefrom'] = $_POST['datefrom'];
        $options['dateto'] = $_POST['dateto'];
        $options['statuses'] = $_POST['statuses'];
        $options['types'] = $_POST['types'];
        $options['similarity'] = $_POST['similarity'];
        $options['done'] = array();
        $options['post2_offset'] = 0;
        $options['found'] = array();
        $options['filterhtml'] = $_POST['filterhtml'];
        update_option('find_duplicates_data', $options);
    }
    echo find_similar_posts();
    die;
}

function get_duplicate_results_meta()
{
    echo find_similar_post_meta($_POST['title'], $_POST['content'], $_POST['id'], $_POST['onlytitle'], $_POST['type']);
    die;
}

function find_similar_post_meta($title, $content, $id, $onlytitle = 0, $type = 'post')
{
    //ini_set("display_errors", true);
    //set_time_limit(1200);
    $log = "";
    $new_duplicates = array();
    $post2_limit = 1000;

    $options = get_option('find_duplicates_data', array());
    // get Posts
    $post_status = implode("','", $options['meta_statuses']);
    $datewhere = "";
    if (!empty($options['meta_datefrom'])) {
        $datewhere .= "post_date>='" . $options['meta_datefrom'] . " 00:00:00" . "' AND ";
    }

    if (!empty($options['meta_dateto'])) {
        $datewhere .= "post_date<='" . $options['meta_dateto'] . " 23:59:59" . "' AND ";
    }
    global $wpdb;
    $allPosts_count = $wpdb->get_results("SELECT COUNT(ID) as count FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $type . "' AND post_status IN('" . $post_status . "') AND ID != " . $id);
    $allPosts_count = $allPosts_count[0]->count;
    $allPosts = $wpdb->get_results("SELECT ID,post_title,post_date,post_content FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $type . "' AND post_status IN('" . $post_status . "') AND ID != " . $id);

    $log .= "Comparing " . $id . " (" . $allPosts_count . "," . $post2_limit . "," . $onlytitle . ")<br />";
    foreach ($allPosts as $post2) {
        if ($post2->ID != $id) {
            if ($onlytitle == 1) {
                $post_compare = $title;
                $post2_compare = $post2->post_title;
            } else {
                $post_compare = $content;
                $post2_compare = $post2->post_content;
            }
            if ($options['meta_filterhtml'] == 1) {
                $post_compare = strip_tags($post_compare);
                $post2_compare = strip_tags($post2_compare);
            }
            $lenDiff = strlen($post_compare) - strlen($post2_compare);
            if ($lenDiff > -200 AND $lenDiff < 200) {
                similar_text($post2_compare, $post_compare, $p);
                if ($p > $options['meta_similarity']) {
                    //$options['found'][] = array($post2->ID, $id, intval(round($p)));
                    $new_duplicates[] = array($post2->ID, $id, intval(round($p)), get_admin_url(), $post2->post_title, $title);
                }
            }
        }
    }

    return json_encode(array($allPosts_count, $log, $new_duplicates, count($new_duplicates)));
}

function remove_result()
{
    $data = get_option('find_duplicates_data', null);
    if (wp_delete_post($_POST['id'], false) != false) {
        foreach ($data['found'] as $key => $element) {
            if ($element[0] == $_POST['id']) {
                unset($data['found'][$key]);
            }
        }
        update_option('find_duplicates_data', $data);
        echo json_encode(array(1, $_POST['id']));
    } else {
        echo json_encode(array(0, $_POST['id']));
    }
    die;
}

function get_posts_count()
{
    $statuses = $_POST['statuses'];
    $post_type = $_POST['types'];
    $datefrom = (empty($_POST['datefrom'])) ? "" : $_POST['datefrom'] . " 00:00:00";
    $dateto = (empty($_POST['dateto'])) ? "" : $_POST['dateto'] . " 23:59:59";

    $datewhere = "";
    if (!empty($datefrom)) {
        $datewhere .= "post_date>='" . $datefrom . "' AND ";
    }

    if (!empty($dateto)) {
        $datewhere .= "post_date<='" . $dateto . "' AND ";
    }

    $count = 0;
    if (is_array($statuses)) {
        $post_statuses = "'" . implode("','", $statuses) . "'";
        global $wpdb;
        $posts = $wpdb->get_results("SELECT COUNT(ID) as count FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $post_type . "' AND post_status IN(" . $post_statuses . ") ");
        $count = $posts[0]->count;
    }
    echo json_encode(array(intval($count)));
    die;
}

function fd_save_post($pid)
{
    if (!wp_is_post_revision($pid) AND get_post_status($pid) != "auto-draft") {

        $newpost = get_post($pid);
        $options = get_option('find_duplicates_data', array());
        if ($options['auto_active'] == 1 AND in_array(get_post_type($newpost), $options['auto_types'])) {
            if ($newpost->post_status == "publish") {
                $type = get_post_type($newpost);
                $log = "";
                $options = get_option('find_duplicates_data', array());
                $post_status = implode("','", $options['auto_statuses']);
                $datewhere = "";
                if (!empty($options['auto_datefrom'])) {
                    $datewhere .= "post_date>='" . $options['auto_datefrom'] . " 00:00:00" . "' AND ";
                }

                if (!empty($options['auto_dateto'])) {
                    $datewhere .= "post_date<='" . $options['auto_dateto'] . " 23:59:59" . "' AND ";
                }
                global $wpdb;
                $allPosts_count = $wpdb->get_results("SELECT COUNT(ID) as count FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $type . "' AND post_status IN('" . $post_status . "') AND ID != " . $pid);
                $allPosts_count = $allPosts_count[0]->count;
                $allPosts = $wpdb->get_results("SELECT ID,post_title,post_date,post_content FROM $wpdb->posts WHERE " . $datewhere . "post_type='" . $type . "' AND post_status IN('" . $post_status . "') AND ID != " . $pid);
                foreach ($allPosts as $post2) {
                    if ($post2->ID != $pid) {
                        if ($options['auto_onlytitle'] == 1) {
                            $post_compare = $newpost->post_title;
                            $post2_compare = $post2->post_title;
                        } else {
                            $post_compare = $newpost->post_content;
                            $post2_compare = $post2->post_content;
                        }
                        if ($options['auto_filterhtml'] == 1) {
                            $post_compare = strip_tags($post_compare);
                            $post2_compare = strip_tags($post2_compare);
                        }
                        $lenDiff = strlen($post_compare) - strlen($post2_compare);
                        if ($lenDiff > -200 AND $lenDiff < 200) {
                            similar_text($post2_compare, $post_compare, $p);
                            if ($p > $options['auto_similarity']) {
                                $my_post = array();
                                $my_post['ID'] = $pid;
                                $my_post['post_status'] = 'pending';

                                if (wp_update_post($my_post) != false) {
                                    $log .= "Duplicate: " . $pid . " (similar to " . $post2->ID . ")<br />";
                                } else {
                                    $log .= "Error: " . $pid . "(similar to " . $post2->ID . ")<br />";
                                }
                            }
                        }
                    }
                }
                $old_log = get_option('find_duplicates_auto_log', '');
                update_option('find_duplicates_auto_log', $old_log . $log);
            }
        }
    }
    return $pid;
}


function output_fd_meta()
{
    global $post;
    $options = get_option('find_duplicates_data', array());
    if ($options['meta_active'] == 1 AND in_array(get_post_type($post), $options['meta_types'])) {
        wp_enqueue_script('find-duplicates-js-meta');

        echo '<div class="misc-pub-section misc-pub-section-last" style="padding-top: 10px;border-top: 1px solid #DFDFDF;">';
        echo '<a class="button" title="' . __('Similarity', 'find-duplicates') . ': ' . $options['meta_similarity'] . '% | ' . __('Date', 'find-duplicates') . ': ' . $options['meta_datefrom'] . '-' . $options['meta_dateto'] . ' | ' . __('Status', 'find-duplicates') . ': ' . implode(",", $options['meta_statuses']) . '" id="fd-meta-start">Find duplicates</a> <input type="checkbox" name="onlytitle" id="onlytitle" value="1"> ' . __('only compare title', 'find-duplicates');
        echo '<div id="ajax-loader" style="display:none;margin-top:10px"><img src="' . plugins_url('ajax-loader.gif', __FILE__) . '" /> ' . __('loading', 'find-duplicates') . '</div>';
        echo '<ul id="fd-meta-results">';
        echo '</ul>
        <script>
            jQuery("#fd-meta-start").click(function(){
                jQuery("#ajax-loader").show();
                find_meta("' . get_post_type($post) . '");
            });
        </script>
        ';
        echo '</div>';
    }
}

function fd_activation()
{
    $options = array();
    $options['auto_active'] = 0;
    $options['auto_datefrom'] = "";
    $options['auto_dateto'] = "";
    $options['auto_statuses'] = array('publish');
    $options['auto_similarity'] = 80;
    $options['auto_onlytitle'] = 0;
    $options['auto_types'] = array('post');
    $options['auto_filterhtml'] = 0;

    $options['meta_active'] = 0;
    $options['meta_datefrom'] = "";
    $options['meta_dateto'] = "";
    $options['meta_statuses'] = array('publish');
    $options['meta_similarity'] = 80;
    $options['meta_types'] = array('post');
    $options['meta_onlytitle'] = 0;
    $options['meta_filterhtml'] = 0;

    $options['onlytitle'] = 0;
    $options['datefrom'] = "";
    $options['dateto'] = "";
    $options['statuses'] = array('publish');
    $options['types'] = 'post';
    $options['similarity'] = 80;
    $options['done'] = array();
    $options['post2_offset'] = 0;
    $options['found'] = array();
    $options['filterhtml'] = 0;
    update_option('find_duplicates_data', $options);
}

function fd_deactivation()
{
    $options = delete_option('find_duplicates_data');
}

?>
