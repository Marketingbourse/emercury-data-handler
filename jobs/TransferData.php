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
        if (file_exists($_ENV['LAST_ID_PATH']) && $last_id = file_get_contents($_ENV['LAST_ID_PATH'])) {
            $log = '';
            $sql = 'SELECT * FROM `leads` WHERE id > ' . $last_id;
            foreach ($this->db->query($sql) as $lead) {
                $url = 'https://panel.emercury.net/api-json.php?request=' . json_encode($lead);
                file_put_contents($_ENV['LAST_ID_PATH'], $lead['id']);
                $log .= "{lead: {$lead['id']}, {$lead['email']}, {$lead['first_name']}, {$lead['last_name']}, log_time: ".time()."}";
            }
            file_put_contents($_ENV['LOG_PATH'], $log, FILE_APPEND);
        }
    }
}