<!DOCTYPE html>
<html>
<head>
    <title>xsolve rss filter test</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<?php

include_once "app/XsolveRssFilter.php";

$keyword = "";
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
} elseif (isset($argv[1])) {
    $keyword = $argv[1];
}
$template = <<<TPL
    <article>
        <h2>[title]</h2>
        <p>[description] <a href="[link]" target="_blank">Czytaj więcej&#8230;</a></p>
    </article>
TPL;

$oXsolveRssFilter = new XsolveRssFilter("http://xlab.pl/feed/");
try {
    $feed = $oXsolveRssFilter->get_messages($keyword);
} catch (Exception $e) {
    $message = "No keyword passed. Type keyword to search xlab.";
}

?>
<header>Test<span class="color">Task</span></header>
<section>
    <h1>Search xlab</h1>
    <form action="" method="GET">
        <label for="keyword">Keyword:</label>
        <input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>">
        <button type="submit">Search</button>
    </form>
    <?php if ($message): ?>
        <div class="error"><i class="icon-exclamation">!</i> <?php echo $message; ?></div>
    <?php endif; ?>
    <?php
    if (isset($feed) && count($feed)) {
        foreach ($feed as $node) {
            echo $oXsolveRssFilter->render_node($node, $template);
        }
    } else {
        echo '<article class="empty"><p>No results. Type keyword to search xlab.</p></article>';
    }
    ?>
</section>
<footer>2013 Piotr Adamowicz</footer>
</body>
</html>
