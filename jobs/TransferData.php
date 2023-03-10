<?php

namespace jobs;
use services\DBConnection as Dbc;

class TransferData
{
    private $db;

    private function __construct(){
        $this->db = Dbc::getInstance();
    }

    public function toEmercury() {
        if ($last_id = file_get_contents($_ENV['LAST_ID_PATH'])) {
            $sql = 'SELECT * FROM `leads` WHERE id > ' . $last_id;
            foreach ($this->db->query($sql) as $lead) {
                $url = 'https://panel.emercury.net/api-json.php?request=' . json_encode($lead);
                file_put_contents($_ENV['LAST_ID_PATH'], $lead['id']);
            }
        }
    }
}