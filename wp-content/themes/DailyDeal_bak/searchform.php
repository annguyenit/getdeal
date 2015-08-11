<div class="search">
    <form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
        <fieldset>
            <input name="s" type="text" onfocus="if(this.value=='<?php echo SEARCH_TEXT;?>') this.value='';" onblur="if(this.value=='') this.value='<?php echo SEARCH_TEXT;?>';" value="<?php echo SEARCH_TEXT;?>" />
            <button type="submit"></button>
        </fieldset>
    </form>
</div>