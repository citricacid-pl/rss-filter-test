<?php
class XsolveRssFilter
{
    public $url;
    public $feed;

    public function __construct($url)
    {
        echo "Adres: " . $url . "\n\n";
        $this->url = $url;
    }

    public function get_messages($filter = "")
    {
        $feed = $this->_get_feed();
        $filtered_feed = $this->_filter_feed($filter, $feed);
        unset($feed);
        echo $filtered_feed[0]->content . "\n------\n";
        return $filtered_feed;
    }

    public function render_node($node, $template)
    {
        var_dump($node);
        return "---\n\n";
    }

    private function _get_feed()
    {
        $feed = "";
        if (!$file_handler = fopen($this->url, "r")) {
            throw new Exception("Cannot open feed for reading");
        }
        while (!feof($file_handler)) {
            $feed .= fread($file_handler, 4096);
        }
        return $feed;
    }

    private function _filter_feed($keyword, $feed)
    {
        if ($keyword == "") {
            throw new Exception("Filter not set");
        }
        $filtered_feed = array();
        $xml = new SimpleXMLElement($feed);
        foreach ($xml->channel->item as $item) {
            if (
                strpos($item->description, $keyword) !== false ||
                strpos($item->title, $keyword) !== false
            ) {
                $filtered_feed[] = $item;
            }
        }
        return $filtered_feed;
    }
}