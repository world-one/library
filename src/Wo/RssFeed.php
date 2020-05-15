<?php
namespace Wo;
use Wo\ResultToJson;
use Exception;
class RssFeed{

	private $return;

	public function __construct(){
		$this->return = new ResultToJson();
	}

	private function xmlLoad($xml)
	{
		$xmlDoc = new \DOMDocument();

		try{
			$xmlDoc->load(($xml));
			if( !$xmlDoc ) throw new Exception('aaa', -2);
			return $xmlDoc;
		}catch(Exception $e){
			$this->return->error($e->getCode(), $e->getMessage());
		}
	}

	private function channelInfo($channel){
		$data = [];
		$data['title'] = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
		$data['link'] = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
		return $data;
	}
	private function setItems( $items, $len = 3 )
	{
		$data = [];
		$itemsLen = count( $items );
		$len = $len > $itemsLen ? $itemsLen : $len;

		for ($i=0; $i < $len; $i++) {
			$item = $items->item($i);
			$data[$i]['title'] = $item->getElementsByTagName('title')->item(0)->nodeValue;
			$data[$i]['link'] = $item->getElementsByTagName('link')->item(0)->nodeValue;
			$data[$i]['category'] = $item->getElementsByTagName('category')->item(0)->nodeValue;
			$date = $item->getElementsByTagName('pubDate')->item(0)->nodeValue;
			$data[$i]['date'] = date_format(date_create($date),"Y-m-d");

			if($item->getElementsByTagName('description')->length > 0){
				$content = $item->getElementsByTagName('description')->item(0)->nodeValue;
			}else{
				$content = $item->getElementsByTagName('encoded')->item(0)->nodeValue;
			}
			$content = $this->htmlParseSlice($content);
			$data[$i]['description'] = $content['text'];
			$data[$i]['image'] = $content['image'];
		}
		
		return $data;
	}

	private function htmlParseSlice($content)
	{
		$html = new \DOMDocument();
		libxml_use_internal_errors(true);
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
		$image = $html->getElementsByTagName('img')->item(0)->getAttribute('src');
		
		return [ 'text' => $textContent, 'image' => $image ];
	}

	public function get($url)
	{
  	$data = [];
    $xml=($url);
		$xmlDoc = $this->xmlLoad($xml);
		$channel = $xmlDoc->getElementsByTagName('channel')->item(0);
		$items = $channel->getElementsByTagName('item');
		
		$data = $this->channelInfo($channel);
		$data['list'] = $this->setItems($items);
		
		return $data;

  }
}