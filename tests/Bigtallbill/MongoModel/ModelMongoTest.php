<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 24/12/14
 * Time: 14:06
 */

namespace Bigtallbill\Model;


use MongoId;

class ModelMongoTest extends \PHPUnit_Framework_TestCase
{
    /** @var AModel */
    protected $model;
    protected $mockMongoClient;

    protected function setUp()
    {
        parent::setUp();

        $this->mockMongoClient = \Mockery::mock('Bigtallbill\Model\DbWrapper\DbWrapper[insert,update,remove,find]');
        $this->mockMongoClient->shouldReceive('insert')->andReturn(true);
        $this->mockMongoClient->shouldReceive('update')->andReturn(true);
        $this->mockMongoClient->shouldReceive('remove')->andReturn(true);
        $this->mockMongoClient->shouldReceive('find')->andReturn(array(
            '_id' => new MongoId(),
            'some_key' => 'someValue'
        ));

        $this->model = new ModelMongo($this->mockMongoClient, 'test', 'test', array());
    }

    public function testAddProp()
    {
        $this->model->addProp('testProp', array());
        $config = $this->model->getPropConfig();
        $this->assertArrayHasKey('testProp', $config);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMagicGetException()
    {
        $this->model->someProp;
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMagicSetExecption1()
    {
        $this->model->testProp = 'prop does not exist';
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMagicSetExecption2()
    {
        $this->model->addProp('testProp', array('types' => array('Bigtallbill\Model\ModelMongo')));
        $this->model->testProp = 'not the correct type of data!';
    }

    public function testMagicGetSet()
    {
        $this->model->addProp('testProp', array('types' => array('Bigtallbill\Model\ModelMongo')));

        $this->assertSame(null, $this->model->testProp, 'values are always null before they are set a value');
        $this->model->testProp = $this->model;
        $this->assertSame($this->model, $this->model->testProp, 'the correct value should be returned');
    }

    public function testMagicGetSetUnknowProperties()
    {
        $this->model = new ModelMongo($this->mockMongoClient, '', '', array(), true);
        $this->model->someProperty = 'some value';

        $this->assertSame('some value', $this->model->someProperty);
    }

    public function testToArray()
    {
        $this->model->insert();
        $arr = $this->model->toArray();

        $this->assertArrayHasKey('_id', $arr);
    }

    public function testToFromArray()
    {
        $this->model->addProp('my_model', array('types' => array('Bigtallbill\Model\ModelMongo')));
        $this->model->my_model = new ModelMongo(null, '', '', array('sub_model_key' => array()));
        $this->model->my_model->sub_model_key = 'loooool';
        $this->model->insert();
        $arr = $this->model->toArray();
        $this->model->fromArray($arr);
        $this->assertArrayHasKey('_id', $arr);
    }

    //--------------------------------------
    // TEST DB
    //--------------------------------------

    public function testFind()
    {
        $this->model->addProp('some_key', array('types' => array('string')));
        $this->model->loadById('because we mock the db response the id value does not matter');
        $this->assertTrue($this->model->isLoaded());
        $this->assertSame($this->model->some_key, 'someValue');
    }
}
