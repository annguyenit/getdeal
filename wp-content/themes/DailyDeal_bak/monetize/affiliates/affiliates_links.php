<h2><a href="#?affiliate=1"><?php echo AFFILIATE_LINK_TAB; ?></a></h2>
<table class="purchase_table">
<tbody>
<?php
    $affiliate_links = get_option('affiliate_links');
	if($affiliate_links)
	{ ?>
	<tr class="row">
	<td style="width:200px;" class="td_title"><?php echo LINK_TITLE; ?></td>
	<td class="td_title"><?php echo LINK_URL; ?></td>
	</tr>
	<?php
		foreach($affiliate_links as $key=>$affiliate_links_Obj)
		{
			if($affiliate_links_Obj['link_status'])
			{
		?>
            <tr class="row">
                <td><?php echo $affiliate_links_Obj['link_title'];?></td>
                 <?php 
                $lkey = $affiliate_links_Obj['link_key'];
                $link =  $affiliate_links_Obj['link_url']; 
				if(strpos($link,'?')){
				 $link =  $affiliate_links_Obj['link_url'].'&ptype=account&lkey='.$lkey.'&aid='.$user_id; 
				}else{
				 $link =  $affiliate_links_Obj['link_url'].'?ptype=account&lkey='.$lkey.'&aid='.$user_id; 
				}
				?>
               
                 <td>
				<?php //echo htmlspecialchars('<a href="'. $link.'">'.$affiliate_links_Obj['link_title'].'</a>');
				echo $link;
				?>
                </td>
            </tr>   
        <?php	
			}
		}
	}
	?>
	</tbody>
</table>