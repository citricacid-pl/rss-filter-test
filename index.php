<!DOCTYPE html>
<html>
<head>
    <title>xsolve rss filter test</title>
</head>
<body>
<?php

include_once "app/XsolveRssFilter.php";

$oXsolveRssFilter = new XsolveRssFilter("http://xlab.pl/feed/");
$feed = $oXsolveRssFilter->get_messages("Symfony2");
$template = <<<TPL
    <article>
        <h2>[title]</h2>
        <p>[description]</p>
        <p>[content:encoded]</p>
    </article>
TPL;

?>
<header>Test<span class="colour">Task</span></header>
<section>
    <h1>Search xlab</h1>
    <form action="" method="GET">
        <label for="keyword">Keyword:</label>
        <input type="text" id="keyword" name="keyword">
    </form>
    <?php
    foreach ($feed as $node) {
        echo $oXsolveRssFilter->render_node($node, $template);
    }
    ?>
</section>
<footer>2013 Piotr Adamowicz</footer>
</body>
</html>
