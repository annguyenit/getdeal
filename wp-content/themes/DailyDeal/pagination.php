<?php if (!templ_is_ajax_pagination()) : ?>
    <div class="pagination">
        <?php previous_posts_link(__('Previous Page','templatic')); ?>
        <?php next_posts_link(__('Next Page','templatic')); ?>
        <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>
    </div>
    <?php else : ?>
    <div id="pagination"><?php next_posts_link(__('LOAD MORE','templatic')); ?></div>
<?php endif; ?>