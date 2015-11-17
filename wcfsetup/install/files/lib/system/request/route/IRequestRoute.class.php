<?php
namespace wcf\system\request\route;
use wcf\system\request\IRoute;

/**
 * Default interface for route implementations.
 * 
 * @author      Alexander Ebert
 * @copyright   2001-2015 WoltLab GmbH
 * @license     GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package     com.woltlab.wcf
 * @subpackage  system.request
 * @category    Community Framework
 */
interface IRequestRoute extends IRoute {
	/**
	 * Configures this route to handle either ACP or frontend requests.
	 * 
	 * @param boolean $isACP true if route handles ACP requests
	 */
	public function setIsACP($isACP);
}
