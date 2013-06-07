<?php
/**
 * A model for a peopleapplikation to create my own first applikation
 * 
 * @package LydiaCore
 */
class CMMedEmobBook extends CObject implements IHasSQL, IModule {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }


  /**
   * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
   *
   * @param string $key the string that is the key of the wanted SQL-entry in the array.
   *  Detta möjliggör ju ändring av databaskod på ett ganska smidigt vis.
   */
  public static function SQL($key=null) {
    $queries = array(
      'create table medemobbook'  => "CREATE TABLE IF NOT EXISTS MedEmobBook (id INTEGER PRIMARY KEY, name TEXT, telNr TEXT, mail TEXT, created DATETIME default (datetime('now')));",
      'insert into medemobbook'   => 'INSERT INTO MedEmobBook (name, telNr, mail) VALUES (?, ?, ?);',
      'select * from medemobbook' => 'SELECT * FROM MedEmobBook ORDER BY id DESC;',
      'delete from medemobbook'   => 'DELETE FROM MedEmobBook;',
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
          $this->db->ExecuteQuery(self::SQL('create table medemobbook'));
           $this->session->AddMessage('success', 'Successfully created the database tables (or left them untouched if they already existed).');
          return array('success', 'Successfully created the database tables (or left them untouched if they already existed).');
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
   * Add a new entry to the medemobbook and save to database.
   */
  public function Add($name, $telNr, $mail) {
    $this->db->ExecuteQuery(self::SQL('insert into medemobbook'), array($name, $telNr, $mail));
    $this->session->AddMessage('success', 'Successfully inserted new person.');
    if($this->db->rowCount() != 1) {
      die('Failed to insert new medemobbook item into database.');
    }
  }
  

  /**
   * Delete all entries from the guestbook and database.
   */
  public function DeleteAll() {
    $this->db->ExecuteQuery(self::SQL('delete from medemobbook'));
    $this->session->AddMessage('info', 'Removed all messages from the database table.');
  }
  
  
  /**
   * Read all entries from the guestbook & database.
   */
  public function ReadAll() {
    try {
      return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * from medemobbook'));
    } catch(Exception $e) {
      return array();    
    }
  }

  
}
