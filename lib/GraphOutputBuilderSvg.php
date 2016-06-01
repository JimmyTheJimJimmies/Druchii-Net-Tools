<?php

/**
 * The builder for SVG graphics
 */
class GraphOutputBuilderSvg extends GraphOutputBuilder
{
	private $content;
	private $width = 0;
	private $height = 0;
	private $font = "Helvetica";
	private $font_size = 12;
	private $showStyle;
	private $fixed_size = true;
	private $style = "default";
	
	
	public function __construct($showStyle = true)
	{
		$this->content = "";
		$this->showStyle = $showStyle;
	}
	/**
	 * addBar
	 *  returns an SVG bar. Used to clean up the code a bit.
	 */
	public function addBar($x, $y, $width, $height, $type)
	{
		$height = round($height);
		$width = round($width);
		$x = round($x);
		$y = round($y);
		$this->content .= "<rect x=\"$x\" y=\"$y\" width=\"$width\" height=\"$height\" fill=\"url(#$type)\"/>\r\n";
		$this->height = max($this->height, $y+$height);
		$this->width = max($this->width, $x+$width);
	}

	/**
	 * addText
	 *  returns an SVG text. Used to clean up the code a bit.
	 */
	public function addText($x, $y, $text, $type)
	{
		$x = round($x);
		$y = round($y);
		$this->content .= "<text x=\"$x\" y=\"$y\" class=\"$type\">$text</text>\r\n";
		$this->height = max($this->height, $y+5);
		$this->width = max($this->width, $x+strlen($text) * $this->font_size * 0.65);
	}
	
	
	/**
	 *
	 */
	
	public function getColorCode()
	{
		$style = "default";
		$file  = "./svgstyles/".$this->style.".svg";
		if(file_exists($file)) {
			return file_get_contents($file);
		} else {
			return '';
		}	
	}

	/**
	 * getContent
	 *  returns the content to be sent to the user.
	 */
	public function getContent()
	{
		return 
'<?xml version="1.0" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="'.(($this->fixed_size)? $this->width . 'px' : '100%').'" height="'.(($this->fixed_size)? $this->height . 'px' : '100%').'" viewBox="0 0 '.$this->width.' '.$this->height.'">
'.$this->getColorCode().'
'.$this->content.'</svg>';
	}
	/**
	 * getContentType
	 *  returns the content type to be used in the HTML header
	 */
	public function getContentType()
	{
		return "image/svg+xml";
	}
	/**
	 * setDimensions
	 *  sets the dimensions
	 */
	public function setDimensions($width,$height)
	{
		$this->width = $width;
		$this->height = $height;
	}
	/**
	 * getWidth
	 *  gives the width
	 */
	public function getWidth()
	{
		return $this->width;
	}
	/**
	 * getHeight
	 *  gives the width
	 */
	public function getHeight()
	{
		return $this->height;
	}
	/**
	 * setFixedSize
	 *  sets the size behavior
	 */
	public function setFixedSize($bool)
	{
		$this->fixed_size = $bool;
	}
	
	/**
	 * getStyle
	 *  returns the style used for the graph.
	 */
	public function getStyle()
	{
		return $this->style;
	}
	/**
	 * setStyle
	 *  sets the style used for the graph.
	 */
	public function setStyle($style)
	{
		$this->style = $style;
	}
		
	/**
	 * addIcon
	 *  draws an icon from a predefined list
	 *  on the specified x y coordinates
	 */
	public function addIcon($x, $y, $size, $icon) 
	{
		switch($icon) {
			case 'error':
				$rad = $size/2;
				$line = $size*0.18;
				$halfline = $line*0.6;
				$this->content .= "<path d=\"M$x,".($y+$rad)."a$rad,$rad 0,0 0 $size,0a$rad,$rad 0,0 0-$size,0z"
					."M".($x+$size/2-$halfline).",".($y+$size/2)
					."l-$line,-$line l$halfline,-$halfline l$line,$line l$line,-$line l$halfline,$halfline"
					."l-$line,$line l$line,$line l-$halfline,$halfline l-$line,-$line l-$line,$line l-$halfline,-$halfline l$line,-$line z"
					."\" fill=\"url(#$icon)\"/>\r\n";
				break;
			case 'warning':
				$this->content .= "<path d=\"M".($x+$size/2).",$y"."l".($size/2).",$size"."l-$size,0z\" fill=\"url(#$icon)\"/>\r\n";
				break;	
		}
		$this->height = max($this->height, $y+$size);
		$this->width = max($this->width, $x+$size);
	
	}
	
}
 
?>