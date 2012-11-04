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
 * Factory of queues to execute bulk insert.
 *
 * @author Yuya Takeyama
 */
class Yuyat_Bulky_QueueFactory
{
    /**
     * @var Yuyat_Bulky_DbAdapter_DbAdapterInterface
     */
    private $db;

    /**
     * @var int
     */
    private $recordsPerQuery;

    public function __construct(
        Yuyat_Bulky_DbAdapter_DbAdapterInterface $db,
        $recordsPerQuery = 100
    )
    {
        $this->db              = $db;
        $this->recordsPerQuery = $recordsPerQuery;
    }

    public function createQueue($table, array $columns, $recordsPerQuery = null)
    {
        if (is_null($recordsPerQuery)) {
            $recordsPerQuery = $this->recordsPerQuery;
        }

        return new Yuyat_Bulky_Queue(
            $this->db,
            $table,
            $columns,
            $recordsPerQuery
        );
    }
}
