<?php
namespace wcf\data\like;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\exception\ValidateActionException;
use wcf\system\like\LikeHandler;
use wcf\system\WCF;

/**
 * Executes like-related actions.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	data.like
 * @category 	Community Framework
 */
class LikeAction extends AbstractDatabaseObjectAction {
	/**
	 * @see wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\like\LikeEditor';
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::validateCreate()
	 */
	public function validateCreate() {
		throw new ValidateActionException("Action 'create' for likes is not supported.");
	}
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::validateDelete()
	 */
	public function validateDelete() {
		throw new ValidateActionException("Action 'delete' for likes is not supported.");
	}
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::validateUpdate()
	 */
	public function validateUpdate() {
		throw new ValidateActionException("Action 'update' for likes is not supported.");
	}
	
	public function validateLike() {
		if (!WCF::getUser()->userID) {
			//throw new ValidateActionException("Guests are not allowed to like content.");
		}
	}
	
	public function validateUnlike() {
		if (!WCF::getUser()->userID) {
			//throw new ValidateActionException("Guests are not allowed to unlike content.");
		}
	}
	
	public function like() {
		$likeObjectType = LikeHandler::getInstance()->getLikeObjectType($this->parameters['data']['objectType']);
		$likeObjectProcessor = $likeObjectType->getProcessor();
		$likeableObject = $likeObjectProcessor->getObjectByID(1);
		$likeData = LikeHandler::getInstance()->like($likeableObject, WCF::getUser(), $this->parameters['data']['isDislike']);
		
		// get stats
		return array(
			'likes' => $likeData['likes'],
			'dislikes' => $likeData['dislikes'],
			'cumulativeLikes' => $likeData['cumulativeLikes'],
			'isLiked' => ($likeData['liked'] == 1) ? 1 : 0,
			'isDisliked' => ($likeData['liked'] == -1) ? 1 : 0
		);
	}
	
	public function unlike() {
		$likeObjectType = LikeHandler::getInstance()->getLikeObjectType($this->parameters['data']['objectType']);
		$likeableObject = $likeObjectType->getProcessor();
		$updated = LikeHandler::getInstance()->unlike($likeableObject, WCF::getUser(), $this->parameters['data']['isDislike']);
	}
}
