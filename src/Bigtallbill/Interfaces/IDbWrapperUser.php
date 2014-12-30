<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 30/12/14
 * Time: 12:00
 */

namespace Bigtallbill\Interfaces;


use Bigtallbill\Model\DbWrapper\ADbWrapper;

interface IDbWrapperUser {
    public function setConnection(ADbWrapper $conn);
}
