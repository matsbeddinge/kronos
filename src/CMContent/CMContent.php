<?php
/**
 * A model for content stored in database.
 *
 * @package KronosCore
 */
class CMContent extends CObject implements IHasSQL, ArrayAccess, IModule {

  /**
	 * Properties
	 */
  public $data;


  /**
	 * Constructor
	 */
  public function __construct($id=null) {
    parent::__construct();
    if($id) {
      $this->LoadById($id);
    } else {
      $this->data = array();
    }
  }


  /**
	 * Implementing ArrayAccess for $this->dataContent
	 */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->data[] = $value; } else { $this->data[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->data[$offset]); }
  public function offsetUnset($offset) { unset($this->data[$offset]); }
  public function offsetGet($offset) { return isset($this->data[$offset]) ? $this->data[$offset] : null; }


  /**
	 * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
	 *
	 * @param $key string the string that is the key of the wanted SQL-entry in the array.
	 * @args $args array with arguments to make the SQL queri more flexible.
	 * @returns string.
	 */
  public static function SQL($key=null, $args=null) {
    $order_order = isset($args['order-order']) ? $args['order-order'] : 'ASC';
    $order_by = isset($args['order-by']) ? $args['order-by'] : 'id';
    $queries = array(
	  'drop table content' => "DROP TABLE IF EXISTS Content;",
      'create table content' => "CREATE TABLE IF NOT EXISTS Content (id INTEGER PRIMARY KEY, key TEXT KEY, type TEXT, title TEXT, data TEXT, filter TEXT, idUser INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idUser) REFERENCES User(id));",
	  'insert content' => 'INSERT INTO Content (key,type,title,data,filter,idUser) VALUES (?,?,?,?,?,?);',
      //'select * by id' => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=? AND deleted IS NULL;',
	  'select * by id' => 'SELECT c.*, u.acronym as owner, COUNT(cmt.id) AS counts FROM Content AS c INNER JOIN User as u ON c.idUser=u.id LEFT OUTER JOIN Comment AS cmt ON c.id=cmt.idContent AND cmt.deleted IS NULL WHERE c.id=? AND c.deleted IS NULL GROUP BY c.id;',
      'select * by key' => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=? AND deleted IS NULL;',
      //'select * by type' => "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE type=? AND deleted IS NULL ORDER BY {$order_by} {$order_order};",
	  'select * by type' => "SELECT c.*, u.acronym as owner, COUNT(cmt.id) AS counts FROM Content AS c INNER JOIN User as u ON c.idUser=u.id LEFT OUTER JOIN Comment AS cmt ON c.id=cmt.idContent AND cmt.deleted IS NULL WHERE type=? AND c.deleted IS NULL GROUP BY c.id ORDER BY c.{$order_by} {$order_order};",
      'select *' => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE deleted IS NULL;',
      'update content' => "UPDATE Content SET key=?, type=?, title=?, data=?, filter=?, updated=datetime('now') WHERE id=?;",
	  'update content as deleted' => "UPDATE Content SET deleted=datetime('now') WHERE id=?;",
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
		  $this->db->ExecuteQuery(self::SQL('drop table content'));
          $this->db->ExecuteQuery(self::SQL('create table content'));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('about-me', 'page', 'About Me', "This can be your about page.<br>You can structure data by using html tags.", 'htmlpurify', 1));
		  $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world', 'post', 'Hello World', "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. \n\n Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. ", 'plain', 1));
          return array('success', 'Successfully created the database tables and created a default "Hello World" blog post, owned by you.');
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
      $this->db->ExecuteQuery(self::SQL('update content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this['id']));
      $msg = 'update';
    } else {
      $this->db->ExecuteQuery(self::SQL('insert content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this->user['id']));
      $this['id'] = $this->db->LastInsertId();
      $msg = 'created';
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successfully {$msg} content '" . htmlEnt($this['key']) . "'.");
    } else {
      $this->AddMessage('error', "Failed to {$msg} content '" . htmlEnt($this['key']) . "'.");
    }
    return $rowcount === 1;
  }

	/**
	 * Delete content. Set its deletion-date to enable wastebasket functionality.
	 *
	 * @returns boolean true if success else false.
	 */
  public function Delete($id) {
    $this->db->ExecuteQuery(self::SQL('update content as deleted'), array($id));
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successfully set content with id:" . $id . " as deleted.");
    } else {
      $this->AddMessage('error', "Failed to set content with id:" . $id . " as deleted.");
    }
    return $rowcount === 1;
  }


  /**
	 * Load content by id.
	 *
	 * @param $id integer the id of the content.
	 * @returns boolean true if success else false.
	 */
  public function LoadById($id) {
    $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
    if(empty($res)) {
      $this->AddMessage('error', "Failed to load content with id '$id'.");
      return false;
    } else {
      $this->data = $res[0];
    }
    return true;
  }
  
  
  /**
	 * List all content.
	 *
	 * @param $args array with various settings for the request. Default is null.
	 * @returns array with listing or null if empty.
	 */
  public function ListAll($args=null) {
    try {
      if(isset($args) && isset($args['type'])) {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by type', $args), array($args['type']));
      } else {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *', $args));
      }
    } catch(Exception $e) {
      echo $e;
      return null;
    }
  }
  
  
  /**
	 * Filter content according to a filter.
	 *
	 * @param $data string of text to filter and format according its filter settings.
	 * @returns string with the filtered data.
	 */
  public static function Filter($data, $filter) {
    switch($filter) {
      /*case 'php': $data = nl2br(makeClickable(eval('?>'.$data))); break;
			case 'html': $data = nl2br(makeClickable($data)); break;*/
      case 'htmlpurify': $data = CHTMLPurifier::Purify($data); break;
      case 'bbcode': $data = nl2br(bbcode2html(htmlEnt($data))); break;
      case 'plain':
      default: $data = nl2br(makeClickable(htmlEnt($data))); break;
    }
    return $data;
  }
  
  
  /**
	 * Get the filtered content.
	 *
	 * @returns string with the filtered data.
	 */
  public function GetFilteredData() {
    return $this->Filter($this['data'], $this['filter']);
  }
  
  
}