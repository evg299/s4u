<?php

// дейсвие по умолчанию для контроллера
define('DEFAULT_ACTION_NAME', 'index');
// контроллер по умолчанию
define('DEFAULT_CONTROLLER_NAME', 'index');
// суффикс названия действия
define('ACTION_NAME_SUFFIX', 'Action');
// суффикс названия контроллера
define('CONTROLLER_NAME_SUFFIX', 'Controller');

// префикс блока магазинов
define('IMAG_PREFIX', 'imag');
// префикс миниатюры картинки
define('SMAL_PICT_PREFIX', 'thumb_');
// размер миниатюры
define('SIZE_SMAL_PICT', 250);
// размер миниатюры
define('SIZE_BIG_PICT', 666);

// субдиректория магазина: витрина
define('IMAG_DIR', '');
// субдиректория магазина: блог
define('BLOG_DIR', 'blog');
// субдиректория магазина: конкретный товар
define('PRODUCT_DIR', 'product');
// субдиректория магазина: статья
define('ARTICLE_DIR', 'article');

// количество витрин на странице
define('IMG_ON_PAGE', 9);
// количество анонсов статей на странице
define('ART_ON_PAGE', 9);
// количество анансов товаров на странице
define('GDS_ON_PAGE', 9);
// количество в дополнительных рубриках (новые и рекомендуемые)
define('GDS_ADDITIONAN_ON_PAGE', 3);



// имя переменной которая хранит ID категории товара
define('PROD_CAT_PARAM_NAME', 'prod_cat');
// имя переменной которая хранит ID категории стати
define('ART_CAT_PARAM_NAME', 'art_cat');
// имя переменной которая хранит ID товара
define('PRODUCT_PARAM_NAME', 'prod_id');
// имя переменной которая хранит ID стати
define('ART_PARAM_NAME', 'art_id');




// субдиректория системы: новости
define('SYS_BLOG_DIR', 'news');
// субдиректория системы: статья
define('SYS_ARTICLE_DIR', 'article');
// имя переменной которая хранит ID категории стати для системы
define('SYS_ART_CAT_PARAM_NAME', 'cat_id');
// имя переменной которая хранит ID стати для системы
define('SYS_ART_PARAM_NAME', 'art_id');



// имя переменной передающей страницу 
define('PAGE_PARAM_NAME', 'page');
// Префикс для URL картинки
define('PICT_PARAM_NAME', 'pict_id');
// Открытый ключ RECAPCHA
define('RECAPCHA_PUBLIC_KEY', '6Ldo1NYSAAAAAHCKvDWaSc8cVNoCcIKtBeVx_AU8');
// Закрытый ключ RECAPCHA
define('RECAPCHA_PRIVATE_KEY', '6Ldo1NYSAAAAAHyaVHGfPkyBSjDOOxS8Whf9fJ_t');
