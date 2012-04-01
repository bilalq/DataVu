<?php

class RSSParser {
   var $is_inside_tag_element = false;
   var $tag = "";
   var $title = "";
   var $description = "";
   var $link = "";
   
   var $item_cnt = 0; 
   var $items = array();
   
   function startElement($parser, $tagName) {
      if ($this->is_inside_tag_element) {
         $this->tag = $tagName;
      } elseif ($tagName == "ITEM") {
         $this->is_inside_tag_element = true;
      }
   }
   function endElement($parser, $tagName) {

      if ($tagName == "ITEM") {
         $this->description = strip_tags(trim($this->description));
         $this->description = substr($this->description, 0, 130) . ' ... ';
         
         $this->items[$this->item_cnt]['title'] = trim($this->title);
         $this->items[$this->item_cnt]['description'] = $this->description;
         $this->items[$this->item_cnt]['link'] = trim($this->link);
         
         $this->title = "";
         $this->description = "";
         $this->link = "";
         $this->is_inside_tag_element = false;
         $this->item_cnt++;
      }
   }
   function characterData($parser, $data) {
      if ($this->is_inside_tag_element) {
         switch ($this->tag) {
            case "TITLE":
            $this->title .= $data;
            break;
            case "DESCRIPTION":
            $this->description .= $data;
            break;
            case "LINK":
            $this->link .= $data;
            break;
         }
      }
   }
   
   function getItems() {
      return $this->items;
   }
}

$my_rss_parser = new RssParser();
$xml_parser = xml_parser_create();
		
xml_set_object($xml_parser, &$my_rss_parser);
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "characterData");

$fp = fopen("http://cnj.craigslist.org/apa/index.rss","r")//"http://losangeles.craigslist.org/apa/index.rss"
or die("Error reading RSS data.");		   //"http://$area.craigslist.org/$category/index.rss"

while ($data = fread($fp, 4096)) {
	xml_parse($xml_parser, $data, feof($fp));
}
fclose($fp);

xml_parser_free($xml_parser);

$items = $my_rss_parser->getItems();
foreach($items as $item) {
	print_r($item);
}
