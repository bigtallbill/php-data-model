<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 24/12/14
 * Time: 18:04
 */

namespace Bigtallbill\Model\DbWrapper\Options\Mongo;

use Bigtallbill\Model\DbWrapper\OperationOptions;


/**
 * Class DbOptionsInsert
 * @package Bigtallbill\MongoModel
 */
class Insert extends OperationOptions
{
    public $options;
    public $object;

    function __construct($db, $col, $object, $options = array())
    {
        parent::__construct($db, $col);
        $this->object = $object;
        $this->options = $options;
    }
}
