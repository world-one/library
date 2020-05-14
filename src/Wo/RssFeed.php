<?php
namespace Wo;
class RssFeed{

  function get($url){

    $data = array();

    // $feed = 'https://medium.com/feed/@ngoeke';
    $feed = 'https://medium.com/feed/grabityio/';

    $xml=($feed);

    $xmlDoc = new \DOMDocument();

    if(@$xmlDoc->load($xml)){

        $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
        $channel_title = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
        $channel_link = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;


        $item = $channel->getElementsByTagName('item');

        $html = new \DOMDocument();
        libxml_use_internal_errors(true);
//            for ($i=0; $i < $item->length; $i++) {
        for ($i=0; $i < 7; $i++) {
            $data[$i]['title'] = $item->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
            $data[$i]['link'] = $item->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
            $data[$i]['category'] = $item->item($i)->getElementsByTagName('category')->item(0)->childNodes->item(0)->nodeValue;
            $date = $item->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue;
            $data[$i]['date'] = date_format(date_create($date),"Y-m-d");

            $data[$i]['creator'] = $item->item($i)->getElementsByTagName('creator')->item(0)->nodeValue;

            $content = $item->item($i)->getElementsByTagName('content')->item(0);
            $content = $content;
            var_dump($content);
            // var_dump($item->item($i)->nodeValue);
            return;
            if($content->childNodes) $content = $content->childNodes->item(0)->nodeValue;
            else $content = $content->nodeValue;

            $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

            $html->loadHTML($content);
            $html->saveHTML();


            $paraLength = $html->getElementsByTagName('p')->length;
            if( $paraLength > 10 ){
                $paraLength = 10;
            }

            $textContent = '';
            for( $id = 0; $id < $paraLength; $id++ ){

                $text = trim( $html->getElementsByTagName('p')->item($id)->textContent );

                if( strlen( $text ) > 3 ){
                    $textContent .= ' '.$text;

                }
            }


            if( mb_strlen( $textContent ) > 112 ){
                $textContent = mb_substr( $textContent, 0, 112 ).'...';
            }
            $data[$i]['content'] = $textContent;

        

            $data[$i]['img'] = $html->getElementsByTagName('img')->item(0)->getAttribute('src');

        }
    }

    return $data;

  }
}