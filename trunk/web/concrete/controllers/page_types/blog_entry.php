<?php defined('C5_EXECUTE') or die(_("Access Denied."));

class BlogEntryPageTypeController extends Controller {	
	
	
	public function on_page_add($c) {
		// @todo make this work and scrape content for description		
	}
	
	
	/**
	 * Returns a formated text for the number of comments in the first comment block in the "Entry Comments" area
	 * @param string $singular_format
	 * @param string $plural_format
	 * @param string $disabled_message
	 * @return string
	 */
	public function getCommentCountString($singular_format, $plural_format, $disabled_message = '') {
		$count = 0;
		$comments_enabled = false;
		
		$c = $this->getCollectionObject();
		$a = new Area('Main');
		$blocks = $a->getAreaBlocksArray($c);
		if(is_array($blocks) && count($blocks) > 0) {
			foreach($blocks as $b) {
				if($b->getBlockTypeHandle() == 'guestbook') {
					$controller = $b->getInstance();
					echo var_dump($controller);
					$comment_bID = $b->bID;
					$comments_enabled = true;
					break;// stop at the fist guestbook block found
				}	
			}
		}
		
		if(isset($comment_bID) && $comments_enabled) {
			$ca = new Cache();		
			//$ca->set('GuestBookCount',$comment_bID,1);
			$count = $ca->get('GuestBookCount',$comment_bID);
			echo var_dump($count);
		}
		if($comments_enabled) {
			echo $count; 
			$format = ($count == 1 ? $singular_format : $plural_format);
			return sprintf($format, $count);
		} else {
			return $disabled_message;
		}
	}
	
}
?>