<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 24/12/14
 * Time: 17:56
 */

namespace Bigtallbill\Model\DbWrapper;

use MongoClient;

abstract class ADbWrapper
{
    /**
     * @var MongoClient
     */
    protected $conn;

    /** @var mixed */
    protected $lastError;

    /**
     * @param $client mixed The instance of the database connection or client instance
     */
    public function setConnection($client)
    {
        $this->conn = $client;
    }

    /**
     * @param OperationOptions $options
     * @return array|\MongoCursor|null
     */
    abstract public function find(OperationOptions $options);

    /**
     * @param OperationOptions $options
     * @return array|bool
     */
    abstract public function insert(OperationOptions $options);

    /**
     * @param OperationOptions $options
     * @return bool
     */
    abstract public function update(OperationOptions $options);

    /**
     * @param OperationOptions $options
     * @return array|bool
     */
    abstract public function remove(OperationOptions $options);

    /**
     * @param $response
     * @return boolean Use the lastError property to store details of failures
     */
    abstract protected function isResponseOk($response);

    /**
     * @return mixed The last error that occurred
     */
    public function lastError()
    {
        return $this->lastError;
    }
}
