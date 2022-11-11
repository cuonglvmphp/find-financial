<?php
namespace Phppot;

class Contacts
{
    private $ds;

    function __construct()
    {
        require_once __DIR__ . '/DataSource.php';
        $this->ds = new DataSource();
    }

    public function checkHasEmail($email) {
     
        $query = 'SELECT * FROM contacts where mail=?';
        $paramType = 's';
        $paramValue = [$email];
        $contactRecord = $this->ds->getRecordCount($query, $paramType, $paramValue);
        if ($contactRecord) {
            return true;
        }
        return false;
    }

    public function insertData($email) {
     
        $query = 'SELECT * FROM contacts where mail=?';
        $paramType = 's';
        $paramValue = [$email];
        $contactRecord = $this->ds->insert($query, $paramType, $paramValue);
        if ($contactRecord > 0) {
            return true;
        }
        return false;
    }
}