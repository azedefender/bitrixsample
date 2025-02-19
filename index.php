<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"] . "/bitrix/templates/" . SITE_TEMPLATE_ID . "/header.php");
$APPLICATION->SetTitle("");
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon.png">
    <?php $APPLICATION->ShowHead(); ?>
    <title><?php $APPLICATION->ShowTitle() ?></title>

    <?php
    // Упрощенное подключение CSS
    $styles = [
        "/css/style.css",
        "/css/tcal.css",
        "/vendor/fancybox/jquery.fancybox.css",
        "/css/custom.css", // Добавьте свой файл стилей
    ];
    foreach ($styles as $style) {
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . $style);
    }

    // Упрощенное подключение JS
    $scripts = [
        "/js/jquery.min.js",
        "/js/fixedmenu.js",
        "/js/dialog.js",
        "/js/gallery.js",
        "/js/slide.js",
        "/js/tabs.js",
        "/js/tcal.js",
        "/js/dropdown.js",
        "/js/custom.js",
        "/vendor/fancybox/jquery.mousewheel.pack.js",
        "/vendor/fancybox/jquery.fancybox.js", 
    ];
    foreach ($scripts as $script) {
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . $script);
    }
    ?>
    
    <meta property="fb:app_id" content="658853490972549" />
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(39714, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/39714" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</head>
<body>
<div id="up-button"></div>
<div id="panel"><?php $APPLICATION->ShowPanel(); ?></div>
<div class="head">
    <a class="nav" href="javascript:menu()"></a>
    <div class="menu">
        <a class="close" href="javascript:menu()"></a>
        <div class="top_menu_wrap">
            <?php $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "tree_top",
                array(
                    "ROOT_MENU_TYPE" => "top",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_THEME" => "site",
                    "CACHE_SELECTED_ITEMS" => "N",
                    "MENU_CACHE_GET_VARS" => array(),
                    "MAX_LEVEL" => "2",
                    "CHILD_MENU_TYPE" => "under",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "COMPONENT_TEMPLATE" => "tree_top",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                ),
                false
            ); ?>
        </div>
    </div>
    <div class="content">
        <div id="search">
            <form action="/search/#body" method="get">
                <input name="tags" value="" type="hidden">
                <input name="how" value="r" type="hidden">
                <input class="search-query" name="q" value="" type="text">
                <input class="search-button" value="Поиск" type="submit">
            </form>
        </div>
        <a class="search" href="javascript:dialog('search',{width:360})">Поиск</a>
        <a class="logo" href="/"></a>

        <div class="header-right">
            <!-- Кнопка-переключатель для снежинок -->
            <button class="switch-btn" id="toggleContainer">
                <div class="toggle-button" id="toggleButton"></div>
            </button>
            <div class="phone"><?php $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/telephone.php"), false); ?></div>
        </div>

        <div class="login">
            <a href="/login/" target="_self" class="button">Login</a>
            <div class="lang">Ru
                <div>
                    <a href="https://tourtraveltorussia.com/">Eng</a>
                    <a href="<?= ($APPLICATION->GetProperty("LINKDE") ? $APPLICATION->GetProperty("LINKDE") : 'https://reisennachrussland.com/'); ?>">De</a>
                </div>
            </div>
        </div>
    </div>
    <div class="slogan"><i>Наши гости -<br>наши друзья!</i><br><b>21 год Успеха!</b></div>
    <!--Image background-->
    <div class="image" style="background-image:url(<?php echo is_file($_SERVER['DOCUMENT_ROOT'] . $APPLICATION->GetCurDir() . 'head.jpg') ? $APPLICATION->GetCurDir() : SITE_TEMPLATE_PATH . '/img/'; ?>head.jpg)">
        <div class="disk-parent">
            <div class="disk">
                <?php $APPLICATION->IncludeComponent("bitrix:main.include", "template3", Array(
                    "AREA_FILE_RECURSIVE" => "Y",
                    "AREA_FILE_SHOW" => "sect",
                    "PATH" => "./disk.php"
                ), false); ?>
            </div>
        </div>
        <div class="wave"></div>
    </div>
</div>
<div id="snowflakes"></div>
<script>
    const snowflakesCount = 100; // Количество снежинок
    let snowflakeInterval; // Переменная для хранения интервала
    let isSnowing = localStorage.getItem('isSnowing') === 'true'; // Получаем состояние из localStorage

    function createSnowflake() {
        const snowflake = document.createElement("div");
        snowflake.className = "snowflake";
        snowflake.innerHTML = "&#10052;"; // Символ снежинки
        snowflake.style.left = Math.random() * 100 + "vw"; // Случайное положение по горизонтали
        snowflake.style.animationDuration = Math.random() * 3 + 2 + "s"; // Случайная длительность анимации
        snowflake.style.fontSize = Math.random() * 10 + 10 + "px"; // Случайный размер снежинки
        document.getElementById("snowflakes").appendChild(snowflake);

        // Удаление снежинки после завершения анимации
        snowflake.addEventListener("animationend", () => {
            snowflake.remove();
        });
    }

    function startSnowAnimation() {
        // Запускаем анимацию
        for (let i = 0; i < snowflakesCount; i++) {
            createSnowflake();
        }
        snowflakeInterval = setInterval(createSnowflake, 500);
    }

    function toggleSnowAnimation() {
        const toggleButton = document.getElementById("toggleContainer");
        isSnowing = !isSnowing; // Переключаем состояние

        // Сохраняем состояние в localStorage
        localStorage.setItem('isSnowing', isSnowing);

        if (isSnowing) {
            startSnowAnimation(); // Запускаем анимацию
            toggleButton.classList.add("switch-on"); // Добавляем класс для изменения цвета фона
        } else {
            // Останавливаем анимацию
            clearInterval(snowflakeInterval);
            document.getElementById("snowflakes").innerHTML = ''; // Очищаем снежинки
            toggleButton.classList.remove("switch-on"); // Убираем класс
        }
    }

    // Обработчик события нажатия на контейнер
    document.getElementById("toggleContainer").addEventListener("click", toggleSnowAnimation);

    // Запускаем анимацию при загрузке страницы, если она включена
    if (isSnowing) {
        startSnowAnimation(); // Включаем анимацию
        document.getElementById("toggleContainer").classList.add("switch-on"); // Включаем переключатель
    } else {
        document.getElementById("toggleContainer").classList.remove("switch-on"); // Убираем класс, если анимация отключена
    }
</script>
<?php
if (strpos($curPage, 'kruizy/') === false && strpos($curPage, 'catalog/') === false) {
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "banners",
        array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "N",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "N",
            "DISPLAY_PICTURE" => "N",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array(
                0 => "ID",
                1 => "PREVIEW_PICTURE",
                2 => "",
            ),
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "18",
            "IBLOCK_TYPE" => "Banner",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "N",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "20",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Новости",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => array(
                0 => "LINK",
                1 => "",
            ),
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_BY2" => "SORT",
            "SORT_ORDER1" => "DESC",
            "SORT_ORDER2" => "ASC",
            "COMPONENT_TEMPLATE" => "banners",
            "STRICT_SECTION_CHECK" => "N",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO"
        ),
        false
    );
} else {
    echo '<br><br>';
}
?>
<div class="body" id="body">
    <div class="content">
        <?php if ($curPage != SITE_DIR . "index.php") : ?>
            <?php $APPLICATION->IncludeComponent("bitrix:breadcrumb", "", array(
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => "-"
                ),
                false,
                Array('HIDE_ICONS' => 'Y')
            ); ?>
        <?php endif ?>
        #WORK_AREA#
    </div>
</div>
<div class="body">
    <div class="content bottom">
        <?php if ($_REQUEST["DOWN"]) echo $_REQUEST["DOWN"]; else { ?>
            <?php $APPLICATION->IncludeComponent("bitrix:main.include", "template2", array(
                "AREA_FILE_RECURSIVE" => "Y",
                "AREA_FILE_SHOW" => "sect",
                "AREA_FILE_SUFFIX" => "non",
                "PATH" => "/catalog/index_news.php",
                "COMPONENT_TEMPLATE" => "template2",
                "COMPOSITE_FRAME_MODE" => "Y",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "EDIT_TEMPLATE" => ""
            ),
                false,
                array(
                    "ACTIVE_COMPONENT" => "Y"
                )
            ); ?>
        <?php } ?>
    </div>
</div>
<div class="feedback">
    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.feedback",
        "contact",
        array(
            "EMAIL_TO" => "",
            "EVENT_MESSAGE_ID" => array(
                0 => "7",
            ),
            "OK_TEXT" => "Спасибо, Ваше сообщение принято.",
            "REQUIRED_FIELDS" => array(
                0 => "EMAIL",
            ),
            "USE_CAPTCHA" => "N",
            "COMPONENT_TEMPLATE" => "contact",
            "COMPOSITE_FRAME_MODE" => "N",
            "COMPOSITE_FRAME_TYPE" => "AUTO"
        ),
        false
    ); ?>
</div>
<div class="foot">
    <div class="content">
        <a class="nav" href="javascript:menu()"></a>
        <?php $APPLICATION->IncludeComponent("bitrix:menu", "tree2", Array(
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "under",
            "DELAY" => "N",
            "MAX_LEVEL" => "2",
            "MENU_CACHE_GET_VARS" => "",
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "ROOT_MENU_TYPE" => "bottom",
            "USE_EXT" => "N",
            "COMPONENT_TEMPLATE" => "tree"
        ),
            false
        ); ?>
        <div class="footer_second_line">
            <div class="copy">
                Все права защищены &copy; ООО "ФОРТУНА" <?= date("Y"); ?><br/>
                Представленная на сайте информация носит<br/>
                справочный характер и не является<br/>
                публичной офертой.
                <a class="rst"></a>
                <br/><br/><br/>
            </div>
            <a class="mail" href="mailto: info@fortuna-travel.ru">info@fortuna-travel.ru</a>
            <?php $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => SITE_DIR . "include/socnet_footer.php",
                    "AREA_FILE_RECURSIVE" => "N",
                    "EDIT_MODE" => "html",
                ),
                false,
                Array('HIDE_ICONS' => 'Y')
            ); ?>
            <a href="/" target="_self" class="logo"></a><br/><br/>
        </div>
    </div>
    <div class="paykeeper">
        <img src="/bitrix/templates/fortuna/img/paykeeper_h.png" alt="Путешествия с турфирмой" class="desktop">
        <?php /*<img src="/bitrix/templates/fortuna/img/paykeeper_v.png" alt="Путешествия с турфирмой" class="mobile">*/ ?>
    </div>
</div>
<!--LiveInternet counter-->
<script>
    new Image().src = "//counter.yadro.ru/hit?r" +
        escape(document.referrer) + ((typeof(screen) == "undefined") ? "" :
            ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
                screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
        ";h" + escape(document.title.substring(0, 150)) +
        ";" + Math.random();
</script>
<!--/LiveInternet-->
<!-- BEGIN JIVOSITE CODE {literal} -->
<script src="//code.jivosite.com/widget/AW8MkBDTsn" async></script>
<!-- {/literal} END JIVOSИТЕ CODE -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-97174337-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-97174337-2');
</script>
<!-- CLEANTALK template addon -->
<?php $frame = (new \Bitrix\Main\Page\FrameHelper("cleantalk_frame"))->begin();
if (CModule::IncludeModule("cleantalk.antispam")) echo CleantalkAntispam::FormAddon();
$frame->end(); ?>
<!-- /CLEANTALK template addon -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" async></script>
</body>
</html>
