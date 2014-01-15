<?php
/**
 * This file is part of Bulky.
 *
 * (c) Yuya Takeyama
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Unit-tests for Yuyat_Bulky_DbAdapter_PdoMysqlAdapter_QueryBuilder.
 *
 * @author Yuya Takeyama
 */
class Yuyat_Tests_Bulky_DbAdapter_PdoMysqlAdapter_QueryBuilderTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function build_should_be_insert_query()
    {
        $builder = $this->createBuilder();
        $query   = $builder->build('foo', array('bar', 'baz'), array(array(1, 2)));

        $this->assertEquals(
            'INSERT INTO `foo` (`bar`, `baz`) VALUES (?, ?)',
            $query
        );
    }

    /**
     * @test
     */
    public function build_should_be_bulk_insert_query()
    {
        $builder = $this->createBuilder();
        $query   = $builder->build('foo', array('bar', 'baz'), array(
            array(1, 2),
            array('foo', 'bar'),
            array('hoge', 'fuga'),
        ));

        $this->assertEquals(
            'INSERT INTO `foo` (`bar`, `baz`) VALUES (?, ?), (?, ?), (?, ?)',
            $query
        );
    }

    /**
     * @test
     */
    public function with_on_duplicate_key_update_option()
    {
        $builder = $this->createBuilder();
        $query   = $builder->build('foo', array('bar', 'baz'), array(
            array(1, 2),
            array('foo', 'bar'),
            array('hoge', 'fuga'),
        ), array(
            'on_duplicate_key_update' => array(
                'abc' => 'def',
                'ghi' => 'jkl',
            )
        ));

        $this->assertEquals(
            'INSERT INTO `foo` (`bar`, `baz`) VALUES (?, ?), (?, ?), (?, ?) ON DUPLICATE KEY UPDATE `abc` = ?, `ghi` = ?',
            $query
        );
    }

    private function createBuilder()
    {
        return new Yuyat_Bulky_DbAdapter_PdoMysqlAdapter_QueryBuilder;
    }
}
