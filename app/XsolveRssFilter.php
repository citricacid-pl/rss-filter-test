<?php
class XsolveRssFilter
{
    public $url;
    public $feed;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get_messages($keyword = "")
    {
        $feed = $this->_get_feed();
        $filtered_feed = $this->_filter_feed($keyword, $feed);
        unset($feed);
        return $filtered_feed;
    }

    public function render_node($node, $template)
    {
        foreach ($node as $node_name => $item) {
            $template = str_replace("[" . $node_name . "]", $item, $template);
        }
        return $template . "\n";
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
                stripos($item->description, $keyword) !== false ||
                stripos($item->title, $keyword) !== false
            ) {
                $filtered_feed[] = $item;
            }
        }
        return $filtered_feed;
    }
}