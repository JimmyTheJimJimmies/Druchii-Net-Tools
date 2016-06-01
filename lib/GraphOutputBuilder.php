<?php


/**
 * A builder pattern to build the graphs
 */
abstract class GraphOutputBuilder
{
	/**
	 * addBar
	 *  adds a bar to the graph.
	 */
	abstract function addBar($x, $y, $width, $height, $type);
	/**
	 * addText
	 *  adds a text to the graph.
	 */
	abstract function addText($x, $y, $text, $type);
	/**
	 * setDimensions
	 * sets the dimensions of the graph
	 */
	abstract function setDimensions($width, $height);
	/**
	 * getWidth
	 * gives the width of the graph
	 */
	abstract function getWidth();
	/**
	 * getHeight
	 *  gives the height of the graph
	 */
	abstract function getHeight();
	 
	/**
	 * getContent
	 *  returns the content to be sent to the user.
	 */
	abstract function getContent();
	/**
	 * getContentType
	 *  returns the content type to be used in the HTML header
	 */
	abstract function getContentType();
	
	/**
	 * getStyle
	 *  returns the style used for the graph.
	 */
	abstract function getStyle();
	/**
	 * setStyle
	 *  sets the style used for the graph.
	 */
	abstract function setStyle($style);
	
	/**
	 * addIcon
	 *  draws an icon from a predefined list
	 *  on the specified x y coordinates
	 */
	abstract function addIcon($x, $y, $size, $icon);
}
?>