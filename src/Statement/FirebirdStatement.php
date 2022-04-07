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
namespace CakephpFirebird\Statement;

use PDO;
use Cake\Database\Statement\PDOStatement;
use Cake\Database\Statement\BufferResultsTrait;

/**
 * Statement class meant to be used by a Firebird PDO driver
 *
 * @internal
 */
class FirebirdStatement extends PDOStatement
{

    use BufferResultsTrait;

    /**
     * {@inheritDoc}
     *
     */
    public function execute(?array $params = null): bool
    {
        $result = $this->_statement->execute($params);
        return $result;
    }

    /**
     * @return int
     */
    public function rowCount(): int
    {
        if (
            strpos($this->_statement->queryString, 'INSERT') === 0 ||
            strpos($this->_statement->queryString, 'UPDATE') === 0 ||
            strpos($this->_statement->queryString, 'DELETE') === 0
        ) {
            return ($this->errorCode() == '00000' ? 1 : 0);
        }

        $count = count($this->_statement->fetchAll());
        $this->execute(); // kind of rewind...
        return $count;
    }

}
