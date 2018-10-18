<?php
/**********************************************************************************
* Subs-BBCode-OffTopic.php
***********************************************************************************
* This mod is licensed under the 2-clause BSD License, which can be found here:
*	http://opensource.org/licenses/BSD-2-Clause
***********************************************************************************
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

function BBCode_OffTopic(&$bbc)
{
	global $txt;

	// Define these tags, which have no issue with block-level bbcode tags:
	$bbc[] = array(
		'tag' => 'offtopic',
		'type' => 'unparsed_content',
		'parameters' => array(
			'text' => array('optional' => true),
			'quote' => array('optional' => true, 'quoted' => true),
			'show' => array('optional' => true),
			'hide' => array('optional' => true),
		),
		'content' => '<div style="padding: 3px; font-size: 1em;"><div style="text-transform: uppercase; border-bottom: 1px solid #5873B0; margin-bottom: 3px; font-size: 0.8em; font-weight: bold; display: block;"><span onClick="if (this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display != \'\') {  this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'\'; this.innerHTML = \'<b><text>{text}</text>{quote}: </b><a href=\\\'#\\\' onClick=\\\'return false;\\\'><hide>{hide}</hide></a>\'; } else { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'none\'; this.innerHTML = \'<b><text>{text}</text>{quote}: </b><a href=\\\'#\\\' onClick=\\\'return false;\\\'><show>{show}</show></a>\'; }" /><b><text>{text}</text>{quote}: </b><a href="#" onClick="return false;"><show>{show}</show></a></span></div><div class="quotecontent"><div style="display: none;">$1</div></div></div>',
		'validate' => 'BBCode_OffTopic_Validate',
		'block-level' => true,
	);
	$bbc[] = array(
		'tag' => 'offtopic',
		'type' => 'unparsed_content',
		'content' => '<div style="padding: 3px; font-size: 1em;"><div style="text-transform: uppercase; border-bottom: 1px solid #5873B0; margin-bottom: 3px; font-size: 0.8em; font-weight: bold; display: block;"><span onClick="if (this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display != \'\') {  this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'\'; this.innerHTML = \'<b>' . $txt['offtopic'] . ': </b><a href=\\\'#\\\' onClick=\\\'return false;\\\'>' . $txt["debug_hide"] . '</a>\'; } else { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'none\'; this.innerHTML = \'<b>' . $txt['offtopic'] . ': </b><a href=\\\'#\\\' onClick=\\\'return false;\\\'>' . $txt["debug_show"] . '</a>\'; }" /><b>' . $txt['offtopic'] . ': </b><a href="#" onClick="return false;">' . $txt["debug_show"] . '</a></span></div><div class="quotecontent"><div style="display: none;">$1</div></div></div>',
		'validate' => 'BBCode_OffTopic_Validate',
		'block-level' => true,
	);

	// Gather up all the block-level bbcode tags, then include that list in the next tag definition:
	$disallowed = array();
	foreach ($bbc as $code)
		if (!empty($code['block_level']))
			$disallowed[] = $code['tag'];
	$bbc[] = array(
		'tag' => 'offtopic',
		'type' => 'parsed_equals',
		'before' => '<div style="padding: 3px; font-size: 1em;"><div style="text-transform: uppercase; border-bottom: 1px solid #5873B0; margin-bottom: 3px; font-size: 0.8em; font-weight: bold; display: block;"><span onClick="if (this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display != \'\') {  this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'\'; this.innerHTML = \'<b>' . $txt['offtopic'] . ': $1 &#149; </b><a href=\\\'#\\\' onClick=\\\'return false;\\\'>' . $txt["debug_hide"] . '</a>\'; } else { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'none\'; this.innerHTML = \'<b>' . $txt['offtopic'] . ': $1 &#149; </b><a href=\\\'#\\\' onClick=\\\'return false;\\\'>' . $txt["debug_show"] . '</a>\'; }" /><b>' . $txt['offtopic'] . ': $1 &#149; </b><a href="#" onClick="return false;">' . $txt["debug_show"] . '</a></span></div><div class="quotecontent"><div style="display: none;">',
		'after' => '</div></div></div>',
		'disallow_children' => array_unique($disallowed),
		'block-level' => true,
	);
}

function BBCode_OffTopic_Validate(&$tag, &$data, &$disabled)
{
	global $txt;

	if (empty($data))
		return ($tag['content'] = '');
	$data = parse_bbc($data);
	$tag['content'] = str_replace('<show></show>', $txt['debug_show'], $tag['content']);
	$tag['content'] = str_replace('<show>', '', str_replace('</show>', '', $tag['content']));
	$tag['content'] = str_replace('<hide></hide>', $txt['debug_hide'], $tag['content']);
	$tag['content'] = str_replace('<show>', '', str_replace('</show>', '', $tag['content']));
	$tag['content'] = str_replace('<text></text>', $txt['offtopic'], $tag['content']);
	$tag['content'] = str_replace('<text>', '', str_replace('</text>', '', $tag['content']));
}

function BBCode_OffTopic_Button(&$buttons)
{
	global $txt;

	$buttons[count($buttons) - 1][] = array(
		'image' => 'offtopic',
		'code' => 'offtopic',
		'description' => $txt['offtopic'],
		'before' => '[offtopic]',
		'after' => '[/offtopic]',
	);
}

?>