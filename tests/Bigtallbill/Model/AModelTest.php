<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 30/12/14
 * Time: 13:20
 */

namespace Bigtallbill\Model;


use Bigtallbill\Model\DbWrapper\ADbWrapper;

class AModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AModel
     */
    protected $model;

    /**
     * @var ADbWrapper
     */
    protected $dbWrapper;

    protected function setUp()
    {
        parent::setUp();

        $this->dbWrapper = $this->getMockForAbstractClass("Bigtallbill\\Model\\DbWrapper\\ADbWrapper");
        $this->model = $this->getMockForAbstractClass("Bigtallbill\\Model\\AModel", array($this->dbWrapper));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function test_MagicGet_non_existing_prop()
    {
        $this->model->i_dont_exist;
    }

    /**
     * @expectedException \RuntimeException
     */
    public function test_MagicSet_non_existing_prop()
    {
        $this->model->i_dont_exist = 'foo';
    }

    /**
     * @expectedException \RuntimeException
     */
    public function test_MagicSet_prop_with_strict_type_exception()
    {
        $this->model->addProp('must_be_string', array('types' => array('string')));
        $this->model->must_be_string = 123456;
    }

    public function test_MagicSet_prop_with_strict_type_object()
    {
        $this->model->addProp('must_be_stdClass', array('types' => array('stdClass')));
        $this->model->must_be_stdClass = new \stdClass();
    }

    public function test_MagicGet_notset_property()
    {
        $this->model->addProp('poo');
        $this->assertNull($this->model->poo, 'an unset property is always null');
    }

    public function test_MagicGet_set_property()
    {
        $this->model->addProp('poo');
        $this->model->poo = 'poo value';
        $this->assertSame('poo value', $this->model->poo, 'poo should be the set value');
    }

    public function test_MagicGetSet_reference_test()
    {
        $this->model->addProp('array_ref');
        $this->model->array_ref = array('cheese');
        $this->assertEquals(array('cheese'), $this->model->array_ref, 'array should have the cheese value');

        $this->model->array_ref[] = 'ham';
        $this->assertEquals(array('cheese', 'ham'), $this->model->array_ref, 'array should have been modified');
    }

    public function test_MagicGetSet_modified_values()
    {
        $this->model->addProp('my_prop');

        $this->model->my_prop = 'prop';
        $modified = $this->model->getModified();
        $this->assertArrayHasKey('my_prop', $modified, 'setting a property from null should  cause a modification');
        $this->assertSame('prop', $modified['my_prop']);

        $this->model->my_prop = 'prop2';
        $modified = $this->model->getModified();

        $this->assertArrayHasKey('my_prop', $modified, 'any change that is different from the current value should cause a modification');
        $this->assertSame('prop2', $modified['my_prop']);
    }

    public function test_MagicSet_id_immutable()
    {
        $this->model->id = 'moo';
        $this->model->id = 'moo2';

        $this->assertSame('moo', $this->model->id, 'value should be "moo" and not "moo2" because the id can only be set once');
    }
}
