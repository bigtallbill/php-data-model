<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 24/12/14
 * Time: 20:13
 */

namespace Bigtallbill\Model\DbWrapper\Options\Mongo;


use Bigtallbill\Model\DbWrapper\OperationOptions;

class Remove extends OperationOptions
{
    /** @var array */
    protected $query;

    /** @var array */
    protected $options;

    public function __construct($db, $col, $query, $options = array())
    {
        parent::__construct($db, $col);
        $this->query = $query;
        $this->options = $options;
    }
}
