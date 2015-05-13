/**
 * Bootstraps WCF's JavaScript.
 * It defines globals needed for backwards compatibility
 * and runs modules that are needed on page load.
 * 
 * @author	Tim Duesterhus
 * @copyright	2001-2015 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @module	WoltLab/WCF/Bootstrap
 */
define(
	[
		'jquery',            'favico',                 'enquire',                'WoltLab/WCF/Date/Time/Relative',
		'UI/SimpleDropdown', 'WoltLab/WCF/UI/Mobile',  'WoltLab/WCF/UI/TabMenu', 'WoltLab/WCF/UI/FlexibleMenu',
		'UI/Dialog',         'WoltLab/WCF/UI/Tooltip'
	], 
	function(
		 $,                   favico,                   enquire,                  relativeTime,
		 simpleDropdown,      UIMobile,                 UITabMenu,                UIFlexibleMenu,
		 UIDialog,            UITooltip
	)
{
	"use strict";
	
	window.Favico = favico;
	window.enquire = enquire;
	
	/**
	 * @constructor
	 */
	function Bootstrap() {}
	Bootstrap.prototype = {
		/**
		 * Initializes the core UI modifications and unblocks jQuery's ready event.
		 */
		setup: function() {
			relativeTime.setup();
			simpleDropdown.setup();
			UIMobile.setup();
			UITabMenu.setup();
			UIFlexibleMenu.setup();
			UIDialog.setup();
			UITooltip.setup();
			
			// convert method=get into method=post
			var forms = document.querySelectorAll('form[method=get]');
			for (var i = 0, length = forms.length; i < length; i++) {
				forms[i].setAttribute('method', 'post');
			}
			
			if ($.browser.msie) {
				window.onbeforeunload = function() {
					/* Prevent "Back navigation caching" (http://msdn.microsoft.com/en-us/library/ie/dn265017%28v=vs.85%29.aspx) */
				};
			}
			
			$.holdReady(false);
		}
	};
	
	return new Bootstrap();
});