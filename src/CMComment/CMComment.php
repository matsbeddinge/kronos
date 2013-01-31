<?php
/**
 * A model for comments stored in database.
 *
 * @package KronosCore
 */
class CMComment extends CObject implements IHasSQL, ArrayAccess, IModule {

	/**
	 * Properties
	 */
  public $dataComment;
  
  /**
	 * Constructor
	 */
  public function __construct($id=null) {
    parent::__construct();
    if($id) {
      $this->LoadById($id);
    } else {
      $this->dataComment = array();
    }
  }
	
	/**
	 * Implementing ArrayAccess for $this->dataComment
	 */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->dataComment[] = $value; } else { $this->dataComment[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->dataComment[$offset]); }
  public function offsetUnset($offset) { unset($this->dataComment[$offset]); }
  public function offsetGet($offset) { return isset($this->dataComment[$offset]) ? $this->dataComment[$offset] : null; }

  
  /**
	 * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
	 *
	 * @param $key string the string that is the key of the wanted SQL-entry in the array.
	 * @args $args array with arguments to make the SQL queri more flexible.
	 * @returns string.
	 */
  public static function SQL($key=null, $args=null) {
    $order_order = isset($args['order-order']) ? $args['order-order'] : 'ASC';
    $order_by = isset($args['order-by']) ? $args['order-by'] : 'created';
    $queries = array(
      'drop table comment' => "DROP TABLE IF EXISTS Comment;",
	  'create table comment' => "CREATE TABLE IF NOT EXISTS Comment (id INTEGER PRIMARY KEY, data TEXT, filter TEXT, idUser INT, idContent INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idUser) REFERENCES User(id), FOREIGN KEY(idContent) REFERENCES Content(id));",
      'insert comment' => 'INSERT INTO Comment (data,filter,idUser,idContent) VALUES (?,?,?,?);',
      'select * by id' => 'SELECT c.*, u.acronym as owner FROM Comment AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=? AND c.deleted IS NULL;',
      'select * by content' => "SELECT Comment.*, User.acronym as owner, User.email as email FROM Comment INNER JOIN User ON Comment.idUser=User.id WHERE idContent=? AND Comment.deleted IS NULL;",
      'select *' => "SELECT Comment.*, User.acronym as owner FROM Comment INNER JOIN User ON Comment.idUser=User.id WHERE Comment.deleted IS NULL ORDER BY Comment.{$order_by} {$order_order};",
      'update comment' => "UPDATE Comment SET data=?, filter=?, updated=datetime('now') WHERE id=?;",
	  'update comment as deleted' => "UPDATE Comment SET deleted=datetime('now') WHERE id=?;",
     );
    if(!isset($queries[$key])) {
      throw new Exception("No such SQL query, key '$key' was not found.");
    }
    return $queries[$key];
  }

  
	/**
	 * Implementing interface IModule. Manage install/update/deinstall and equal actions.
	 */
  public function Manage($action=null) {
    switch($action) {
      case 'install':
        try {
          $this->db->ExecuteQuery(self::SQL('drop table comment'));
		  $this->db->ExecuteQuery(self::SQL('create table comment'));
          $this->db->ExecuteQuery(self::SQL('insert comment'), array("This is a demo comment.", 'plain', 1, 2));
		  return array('success', 'Successfully created the Comment table and created default comments.');
        } catch(Exception$e) {
          die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
        }
      break;
      
      default:
        throw new Exception('Unsupported action for this module.');
      break;
    }
  }

  /**
	 * Save content. If it has a id, use it to update current entry or else insert new entry.
	 *
	 * @returns boolean true if success else false.
	 */
  public function Save() {
    $msg = null;
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update comment'), array($this['data'], $this['filter'], $this['id']));
      $msg = 'update';
    } else {
      $this->db->ExecuteQuery(self::SQL('insert comment'), array($this['data'], $this['filter'], $this->user['id'], $this['idContent']));
      $this['id'] = $this->db->LastInsertId();
      $msg = 'created';
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successfully {$msg} comment");
    } else {
      $this->AddMessage('error', "Failed to {$msg} comment ");
    }
    return $rowcount === 1;
  }

	/**
	 * Delete content. Set its deletion-date to enable wastebasket functionality.
	 *
	 * @returns boolean true if success else false.
	 */
  public function Delete($id) {
    $this->db->ExecuteQuery(self::SQL('update comment as deleted'), array($id));
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successfully put comment in waste basket.");
    } else {
      $this->AddMessage('error', "Failed to put comment in waste basket.");
    }
    return $rowcount === 1;
  }


  /**
	 * Load comment by id.
	 *
	 * @param $id integer the id of the comment.
	 * @returns boolean true if success else false.
	 */
  public function LoadById($id) {
    $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
    if(empty($res)) {
      $this->AddMessage('error', "Failed to load comment with id '$id'.");
      return false;
    } else {
      $this->dataComment = $res[0];
    }
		return true;
  }
  
	
  
  /**
	 * List all comments.
	 *
	 * @param $args array with various settings for the request. Default is null.
	 * @returns array with listing or null if empty.
	 */
  public function ListAll($args=null) {
    try {
      $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *', $args));
	  return $res;
    } catch(Exception $e) {
		echo $e;
		return null;
    }
  }
  
  
  /**
	 * List comments related to specific content.
	 *
	 * @param $id integer the id of the related comment.
	 * @returns array with listing or null if empty.
	 */
  public function ListComments($id) {
    try {
	  $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by content'), array($id));
	  return $res;
    } catch(Exception $e) {
		echo $e;
		return null;
    }
  }
  
}