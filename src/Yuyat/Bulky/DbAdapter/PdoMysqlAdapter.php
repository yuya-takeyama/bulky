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
 * DbAdapter for PDO of MySQL.
 *
 * @author Yuya Takeyama
 */
class Yuyat_Bulky_DbAdapter_PdoMysqlAdapter
    implements Yuyat_Bulky_DbAdapter_DbAdapterInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    private $queryBuilder;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function execute($table, $columns, array $records)
    {
        $builder = $this->getQueryBuilder();
        $query   = $builder->build($table, $columns, $records);

        $stmt = $this->pdo->prepare($query);

        return $stmt->execute($this->toValues($records));
    }

    private function getQueryBuilder()
    {
        if (is_null($this->queryBuilder)) {
            $this->queryBuilder = new Yuyat_Bulky_DbAdapter_PdoMysqlAdapter_QueryBuilder;
        }

        return $this->queryBuilder;
    }

    private function toValues(array $records)
    {
        $values = array();

        foreach ($records as $record) {
            $values = array_merge($values, $record);
        }

        return $values;
    }
}
