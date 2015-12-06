<? if (1 < count($v_params['paginator'])): ?>
    <div class="paginator">
        <? foreach ($v_params['paginator'] as $paginator_item) : ?>
            <? if ($paginator_item['current']) : ?>
                <b><?= $paginator_item['value']; ?></b>
            <?php else: ?>
                <a href="<?= $paginator_item['url']; ?>"><?= $paginator_item['value']; ?></a>
            <? endif; ?>
        <? endforeach; ?>
    </div>
<? endif; ?>