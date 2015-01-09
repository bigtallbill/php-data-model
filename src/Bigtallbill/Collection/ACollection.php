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
use Bigtallbill\Model\DbWrapper\OperationOptions;

abstract class ACollection implements IDbWrapperUser, \ArrayAccess, \Iterator, \Countable
{
    /** @var ADbWrapper */
    protected $conn;
    protected $databaseName;
    protected $collectionName;

    /**
     * @param ADbWrapper $client
     * @param string $databaseName
     * @param string $collectionName
     */
    function __construct(
        ADbWrapper $client = null,
        $databaseName = '',
        $collectionName = ''
    ) {
        $this->setConnection($client);
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
    }

    /**
     * Should populate this collection with results of the query
     *
     * @param OperationOptions $options
     */
    abstract public function find(OperationOptions $options);

    /**
     * Should batch insert all objects in this collection
     *
     * @param OperationOptions $options
     */
    abstract public function insert(OperationOptions $options);

    //--------------------------------------
    // INTERFACE REQUIREMENTS
    //--------------------------------------

    public function setConnection(ADbWrapper $conn)
    {
        $this->conn = $conn;
    }
}
