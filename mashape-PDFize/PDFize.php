<?php
require_once("mashape/MashapeClient.php");

class PDFize
{
	private $developerKey;
	function __construct($developerKey)
	{
		$this->developerKey=$developerKey;
	}

	public function getPDF($orientation, $unit, $format, $unicode, $encoding, $author, $has_header, $header_title, $header_desc, $has_footer, $html)
	{
		$parameters = array("orientation" => $orientation,
		                    "unit" => $unit,
		                    "format" => $format,
		                    "unicode" => $unicode,
		                    "encoding" => $encoding,
		                    "author" => $author,
		                    "has_header" => $has_header,
		                    "header_title" => $header_title,
		                    "header_desc" => $header_desc,
		                    "has_footer" => $has_footer,
		                    "html" => $html);
		$response = HttpClient::doRequest(HttpMethod::POST, "http://a4mani.it/pdfize/api.php?_method=getPDF&orientation={orientation}&unit={unit}&format={format}&unicode={unicode}&encoding={encoding}&author={author}&has_header={has_header}&header_title={header_title}&header_desc={header_desc}&has_footer={has_footer}&html={html}", $parameters, $this->developerKey);
		return $response;
	}

	public function getPDFSimple($html)
	{
		$parameters = array("html" => $html);
		$response = HttpClient::doRequest(HttpMethod::POST, "http://a4mani.it/pdfize/api.php?_method=getPDFSimple&html={html}", $parameters, $this->developerKey);
		return $response;
	}
}
?>