<?php
# -- BEGIN LICENSE BLOCK ---------------------------------------
#
# This file is part of Dotclear 2.
#
# Copyright (c) 2003-2013 Olivier Meunier & Association Dotclear
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# -- END LICENSE BLOCK -----------------------------------------
if (!defined('DC_CONTEXT_ADMIN')) { return; }

$GLOBALS['core']->addBehavior('adminPostsActionsPage',array('dcLegacyPosts','adminPostsActionsPage'));
$GLOBALS['core']->addBehavior('adminCommentsActionsPage',array('dcLegacyComments','adminCommentsActionsPage'));

/* Handle deprecated behaviors : 
    * adminPostsActionsCombo
	* adminPostsActionsHeaders
	* adminPostsActionsContent
*/
class dcLegacyPosts
{
	public static function adminPostsActionsPage($core, dcPostsActionsPage $as) {
		$stub_actions = new ArrayObject();
		$core->callBehavior('adminPostsActionsCombo',array($stub_actions));
		if (!empty($stub_actions)) {
			$as->addAction($stub_actions,array('dcLegacyPosts','onActionLegacy'));
		}
	}
	
	public static function onActionLegacy($core, dcPostsActionsPage $as, $post) {
		$core->callBehavior('adminPostsActions',$core,$as->getRS(),$as->getAction(),$as->getRedirection());
		$as->beginPage('',
			dcPage::jsLoad('js/jquery/jquery.autocomplete.js').
			dcPage::jsMetaEditor().
			$core->callBehavior('adminPostsActionsHeaders'),'');
		$core->callBehavior('adminPostsActionsContent',$core,$as->getAction(),$as->getHiddenFields(true));
		$as->endPage();
	
	}
}


/* Handle deprecated behaviors : 
    * adminCommentsActionsCombo
	* adminCommentsActionsHeaders
	* adminCommentsActionsContent
*/
class dcLegacyComments
{
	public static function adminCommentsActionsPage($core, dcCommentsActionsPage $as) {
		$stub_actions = new ArrayObject();
		$core->callBehavior('adminCommentsActionsCombo',array($stub_actions));
		if (!empty($stub_actions)) {
			$as->addAction($stub_actions,array('dcLegacyComments','onActionLegacy'));
		}
	}
	
	public static function onActionLegacy($core, dcCommentsActionsPage $as, $Comment) {
		$core->callBehavior('adminCommentsActions',$core,$as->getRS(),$as->getAction(),$as->getRedirection());
		$as->beginPage('',
			dcPage::jsLoad('js/jquery/jquery.autocomplete.js').
			dcPage::jsMetaEditor().
			$core->callBehavior('adminCommentsActionsHeaders'),'');
		$core->callBehavior('adminCommentsActionsContent',$core,$as->getAction(),$as->getHiddenFields(true));
		$as->endPage();
	
	}
}