<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 24/12/14
 * Time: 18:04
 */

namespace Bigtallbill\Model\DbWrapper;

/**
 * Forms the basis for an operation option.
 *
 * An operation option object is used to pass database-specific options for specific operations to the DbWrapper
 *
 * Class OperationOptions
 * @package Bigtallbill\Model\DbWrapper
 */
abstract class OperationOptions
{
    public $db;
    public $col;

    public function __construct($db, $col)
    {
        $this->db = $db;
        $this->col = $col;
    }
}
