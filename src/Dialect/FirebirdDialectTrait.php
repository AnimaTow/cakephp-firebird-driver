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
namespace CakephpFirebird\Dialect;

use Cake\Database\QueryCompiler;
use Cake\Database\SqlDialectTrait;
use CakephpFirebird\Schema\FirebirdSchema;
use CakephpFirebird\FirebirdCompiler;

/**
 * Contains functions that encapsulates the SQL dialect used by Firebird,
 * including query translators and schema introspection.
 *
 * @internal
 */
trait FirebirdDialectTrait
{

    use SqlDialectTrait;

    /**
     *  String used to start a database identifier quoting to make it safe
     *
     * @var string
     */
    protected $_startQuote = '"';

    /**
     * String used to end a database identifier quoting to make it safe
     *
     * @var string
     */
    protected $_endQuote = '"';

    /**
     * The schema dialect class for this driver
     *
     * @var \CakephpFirebird\Schema\FirebirdSchema
     */
    protected $_schemaDialect;

    /**
     * Modify the limit/offset to TSQL
     *
     * @param \Cake\Database\Query $query The query to translate
     * @return \Cake\Database\Query The modified query
     */
    protected function _selectQueryTranslator($query)
    {
        $skip = false;
        $limit = $query->clause('limit');
        $offset = $query->clause('offset');

        if (isset($query->clause('select')['count'])) {
            //TODO instanceof \Cake\Database\Expression\FunctionExpression)
            $skip = true;
        }

        if ($limit && !$offset && !$skip) {
            $query->modifier(['_auto_top_' => sprintf('FIRST %d', $limit)]);
        }

        if ($limit && $offset && !$skip) {
            $query->modifier(['_auto_top_' => sprintf('FIRST %d SKIP %d', $limit, $offset)]);
        }

        if ($skip) {
            $query->modifier(['_auto_top_' => '']);
        }

        return $this->_transformDistinct($query);
    }

    /**
     * Transforms an insert query that is meant to insert multiple rows at a time,
     * otherwise it leaves the query untouched.
     *
     * The way Firebird works with multi insert is by having multiple select statements
     * joined with UNION.
     *
     * @param \Cake\Database\Query $query The query to translate
     * @return \Cake\Database\Query
     */
    protected function _insertQueryTranslator($query)
    {
        $v = $query->clause('values');
        if (count($v->getValues()) === 1 || $v->query()) {
            return $query;
        }

        $newQuery = $query->connection()->newQuery();
        $cols = $v->columns();
        $placeholder = 0;
        $replaceQuery = false;

        foreach ($v->getValues() as $k => $val) {
            $fillLength = count($cols) - count($val);
            if ($fillLength > 0) {
                $val = array_merge($val, array_fill(0, $fillLength, null));
            }

            foreach ($val as $col => $attr) {
                if (!($attr instanceof ExpressionInterface)) {
                    $val[$col] = sprintf(':c%d', $placeholder);
                    $placeholder++;
                }
            }

            $select = array_combine($cols, $val);
            if ($k === 0) {
                $replaceQuery = true;
                $newQuery->select($select);
                continue;
            }

            $q = $newQuery->connection()->newQuery();
            $newQuery->unionAll($q->select($select));
        }

        if ($replaceQuery) {
            $v->query($newQuery);
        }

        return $query;
    }

    /**
     * Get the schema dialect.
     *
     * Used by Cake\Database\Schema package to reflect schema and
     * generate schema.
     *
     * @return \CakephpFirebird\Schema\FirebirdSchema
     */
    public function schemaDialect()
    {
        return new FirebirdSchema($this);
    }

    /**
     * {@inheritDoc}
     */
    public function disableForeignKeySQL(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function enableForeignKeySQL(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     *
     * @return \Cake\Database\SqlserverCompiler
     */
    public function newCompiler(): QueryCompiler
    {
        return new FirebirdCompiler();
    }

}
