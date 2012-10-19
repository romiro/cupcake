<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <title>CupcakePhp</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <?=$this->layoutScripts(array(
        'jquery.js',
        'jquery/jquery.dimensions.js',
        'jquery/ui.mouse.js',
        'jquery/ui.draggable.js',
        'jquery/ui.slider.js',
        'jquery/ui.resizable.js',
        'main.js'))?>
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="/js/jquery/themes/thunderbolt/thunderbolt.resizable.css" />
</head>

<body>
    <?if(isset($_SESSION['noticeMessage'])):?>
        <div id="Notice">
            <span class="text"><?=$_SESSION['noticeMessage']?></span>
        </div>
        <?unset($_SESSION['noticeMessage'])?>
    <?endif?>

    <div id="TopRight">
        

        [
        <a href="/">home</a> |
        <a href="/testAction">test</a>        
        ]<br />

        CupcakePhp<br />
        &copy;2007-2008 Robert Rogers<br />
        <a href="http://romiro.com"><img src="/img/romiro.png" /></a>
    </div>

    <div id="container">
        <?=$content?>
    </div>

    <div style="clear:both"></div>
    <div id="footer"></div>

</body>
</html>