<?php

namespace Podlove\Modules\Logging;

use Podlove\Publisher\Vendor\Monolog\Handler\AbstractProcessingHandler;
use Podlove\Publisher\Vendor\Monolog\Logger;

class WPDBHandler extends AbstractProcessingHandler
{
    private $wpdb;

    public function __construct($wpdb, $level = Logger::DEBUG, $bubble = true)
    {
        $this->wpdb = $wpdb;
        parent::__construct($level, $bubble);
    }

    protected function write(array $record)
    {
        $row = new LogTable();
        $row->channel = $record['channel'];
        $row->level = $record['level'];
        $row->message = esc_sql($record['message']);
        $row->context = json_encode($record['context']);
        $row->time = $record['datetime']->format('U');
        $row->save();
    }
}
