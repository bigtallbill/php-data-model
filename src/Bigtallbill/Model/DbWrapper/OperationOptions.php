<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 24/12/14
 * Time: 18:04
 */

namespace Bigtallbill\Model\DbWrapper;


class OperationOptions extends \stdClass
{
    public $db;
    public $col;

    public function __construct($db, $col)
    {
        $this->db = $db;
        $this->col = $col;
    }
}
