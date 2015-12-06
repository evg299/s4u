<div class="navigation_block">
    <div class="navigation_block_header" style="background-color: orangered;">
        Управление
    </div>
    <div class="navigation_block_content">
        <ul>
            <li><a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/settings">Настройки</a></li>
            <li><a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/albums">Альбомы</a></li>
            <li><a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/GDScats">Категории товаров</a></li>
            <li><a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/GDSs">Товары</a></li>
            <li><a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/ARTcats">Блоки статей</a></li>
            <li><a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/ARTs">Статьи</a></li>
        </ul>
    </div>
</div>

<br />
<div class="navigation_block">
    <div class="navigation_block_header" style="background-color: orangered;">
        Заказы
    </div>
    <div class="navigation_block_content">
        <ul>
            <li><a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/orders?type=last">Последние</a></li>
            <li><a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/orders?type=notprocessed">Не завершенные</a></li>
            <li><a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/orders">Все</a></li>
        </ul>
    </div>
</div>