<?php
/**
* @package   ZOO Component
* @file      intensedebate.php
* @version   2.0.0 May 2010
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2010 YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

/*
   Class: ElementIntensedebate
       The Intensedebate element class (http://www.intensedebate.com)
*/
class ElementIntensedebate extends Element {

	/*
		Function: render
			Override. Renders the element.

	   Parameters:
            $params - render parameter

		Returns:
			String - html
	*/
	public function render($params = array()) {

		// init vars
		$account = $this->_config->get('account');		
		
		// render html
		if ($account && $this->_data->get('value')) {
			$html[] = "<script type='text/javascript'>";
			$html[] = "var idcomments_acct = '".$account."';";
			$html[] = "var idcomments_post_id = 'zoo-".$this->_item->id."';";
			$html[] = "var idcomments_post_url;";
			$html[] = "</script>";
			$html[] = '<span id="IDCommentsPostTitle" style="display:none"></span>';
			$html[] = "<script type='text/javascript' src='http://www.intensedebate.com/js/genericCommentWrapperV2.js'></script>";
			return implode("\n", $html);
		}

		return null;
	}

	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit() {

		// init vars
		$default = $this->_config->get('default');
		
		// set default, if item is new
		if ($default != '' && $this->_item != null && $this->_item->id == 0) {
			$this->_data->set('value', 1);
		}

		return JHTML::_('select.booleanlist', 'elements[' . $this->identifier . '][value]', '', $this->_data->get('value'));
	}

}