<?php
/**
 * Copyright 2022 Stephan Bröker & mediafelis.de Kevin Gledhill
 * Original Plugin
 * CakePHP 3 Driver for Firebird Database
 * https://github.com/mbamarante/cakephp-firebird-driver

 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2016 Maicon Amarante (CakePHP 3 Driver for Firebird Database)
 * @copyright Copyright 2022 Stephan Bröker & mediafelis.de Kevin Gledhill (CakePHP 4 Driver for Firebird Database)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 */
namespace CakephpFirebird\Test\TestCase\Database;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;
/**
 * Tests Query class
 *
 */
class QueryTest extends TestCase
{
    public $connection = 'test_cakephpfirebird';

    /**
     * Test subject
     *
     * @var \Agricola\Model\Table\EscolasTable
     */
    public $Articles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cakephp_firebird.articles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        $connection = ConnectionManager::get('test_cakephpfirebird');
        $config = ['connection' => $connection];
//        $this->Articles = new Table($config);
        parent::setUp();
        $this->Articles = TableRegistry::get('Articles', $config);
    }


    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Articles);

        parent::tearDown();
    }

    /**
     * @inheritDoc
     */
    public function testSelectAll()
    {
        $query = $this->Articles->find('all');
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->enableHydration(false)->toArray();
        $expected = [
            ['id' => 1, 'author_id' => 1, 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y'],
        ];

        $this->assertEquals($expected, $result);
    }

}
