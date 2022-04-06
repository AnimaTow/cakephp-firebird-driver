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

namespace CakephpFirebird\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * Short description for class.
 *
 */
class ArticlesFixture extends TestFixture
{
    public $connection = 'test_cakephpfirebird';

    /**
     * fields property
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'null' => false],
        'author_id' => ['type' => 'integer', 'null' => true],
        'title' => ['type' => 'string', 'null' => true],
        'body' => ['type' => 'string', 'null' => true],
        'published' => ['type' => 'string', 'length' => 1, 'default' => 'N'],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
    ];

    /**
     * records property
     *
     * @var array
     */
    public $records = [
        ['id' => 1, 'author_id' => 1, 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y'],
//        ['id' => 2, 'author_id' => 3, 'title' => 'Second Article', 'body' => 'Second Article Body', 'published' => 'Y'],
//        ['id' => 3, 'author_id' => 1, 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y'],
    ];
}
