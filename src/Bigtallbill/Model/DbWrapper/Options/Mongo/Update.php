<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 24/12/14
 * Time: 19:57
 */

namespace Bigtallbill\Model\DbWrapper\Options\Mongo;


use Bigtallbill\Model\DbWrapper\OperationOptions;

class Update extends OperationOptions
{
    /** @var array */
    public $query;

    /** @var array */
    public $object;

    /** @var array */
    public $options;

    public function __construct($db, $col, $query, $object, array $options = array())
    {
        parent::__construct($db, $col);
        $this->query = $query;
        $this->object = $object;
        $this->options = $options;
    }
}
