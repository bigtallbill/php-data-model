<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 24/12/14
 * Time: 20:49
 */

namespace Bigtallbill\Model\DbWrapper\Options\Mongo;


use Bigtallbill\Model\DbWrapper\OperationOptions;

class Find extends OperationOptions
{
    public $query;
    public $options;

    public function __construct($db, $col, array $query = array(), array $options = array())
    {
        parent::__construct($db, $col);
        $this->query = $query;
        $this->options = $options;
    }
}
