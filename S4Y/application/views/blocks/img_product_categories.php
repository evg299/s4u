<? if (0 != strcmp("", trim($v_params['img_gds_cats_HTML']))): ?>
    <div class="navigation_block">
        <div class="navigation_block_header">
            <a class="a_clear" href="<? echo $v_params['img_all_gds_cats_href']; ?>">Категории товаров</a>
        </div>
        <div class="navigation_block_content">
            <?php echo $v_params['img_gds_cats_HTML']; ?>	
        </div>
    </div>
<? endif; ?>