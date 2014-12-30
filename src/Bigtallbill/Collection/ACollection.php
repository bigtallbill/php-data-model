<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 30/12/14
 * Time: 11:59
 */

namespace Bigtallbill\Collection;


use Bigtallbill\Interfaces\IDbWrapperUser;
use Bigtallbill\Model\DbWrapper\ADbWrapper;

abstract class ACollection implements IDbWrapperUser, \ArrayAccess, \Iterator, \Countable
{
    /** @var ADbWrapper */
    protected $conn;

    //--------------------------------------
    // INTERFACE REQUIREMENTS
    //--------------------------------------

    public function setConnection(ADbWrapper $conn)
    {
        $this->conn = $conn;
    }
}
