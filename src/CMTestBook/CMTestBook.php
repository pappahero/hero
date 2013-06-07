<?php
/**
 * A model for content stored in database.
 * 
 * @package LydiaCore
 */
class CMTestBook extends CObject implements IHasSQL, ArrayAccess, IModule {

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
   * Implementing ArrayAccess for $this->data
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
    $queries = array(
      'drop table content'        => "DROP TABLE IF EXISTS TestBook;",
      'create table content'      => "CREATE TABLE IF NOT EXISTS TestBook (id INTEGER PRIMARY KEY, name TEXT, telNr TEXT, mail TEXT, filter TEXT);",
      'insert content'            => 'INSERT INTO TestBook (name,telNr,mail,filter) VALUES (?,?,?,?);',
      'select * by id'            => 'SELECT * FROM TestBook WHERE id=?;',
      'select * from medemobbook' => 'SELECT * FROM TestBook ORDER BY id ASC;',
      'delete from medemobbook'   => 'DELETE FROM TestBook WHERE id=?;',
      'update content'            => "UPDATE TestBook SET name=?, telNr=?, mail=?, filter=? WHERE id=?;",
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
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Henrik Rödén', '070-606 48 77', "henrikroden@gmail.com", 'plain'));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Maj Bohlin', '070-070 07 07', 'majbohlin@live.se', 'plain'));
          return array('success', 'Successfully created the database tables');
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
   * Save content. If it has an id, use it to update current entry or else insert new entry.
   *
   * @returns boolean true if success else false.
   */
  public function Save() {
    $msg = null;
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update content'), array($this['name'], $this['telNr'], $this['mail'], $this['filter'], $this['id']));
      $msg = 'update';
    } else {
      $this->db->ExecuteQuery(self::SQL('insert content'), array($this['name'], $this['telNr'], $this['mail'], $this['filter']));
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
  public function Delete() {
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('delete from medemobbook'), array($this['id']));
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successfully set content '" . htmlEnt($this['key']) . "' as deleted.");
    } else {
      $this->AddMessage('error', "Failed to set content '" . htmlEnt($this['key']) . "' as deleted.");
    }
    return $rowcount === 1;
  }
  
    /**
   * Delete all entries from the guestbook and database.
   */
  public function DeleteAll() {
    $this->db->ExecuteQuery(self::SQL('delete from medemobbook'));
    $this->session->AddMessage('info', 'Removed all messages from the database table.');
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
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * from medemobbook', $args));
      	}
      catch(Exception $e) {
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
      case 'htmlpurify': $data = nl2br(CHTMLPurifier::Purify($data)); break;
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
