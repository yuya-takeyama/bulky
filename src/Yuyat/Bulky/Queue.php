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
 * Queue of bulk insertion.
 *
 * @author Yuya Takeyama
 */
class Yuyat_Bulky_Queue extends Edps_EventEmitter
{
    /**
     * @var Yuyat_Bulky_DbAdapter_DbAdapterInterface
     */
    private $db;

    /**
     * @var string
     */
    private $table;

    /**
     * @var array
     */
    private $columns;

    /**
     * @var int
     */
    private $columnSize;

    /**
     * @var int
     */
    private $recordsPerQuery;

    /**
     * @var array
     */
    private $records;

    /**
     * @var array
     */
    private $options;

    public function __construct(
        Yuyat_Bulky_DbAdapter_DbAdapterInterface $db,
        $table,
        array $columns,
        $recordsPerQuery
    )
    {
        $this->db              = $db;
        $this->table           = $table;
        $this->columns         = $columns;
        $this->columnSize      = count($this->columns);
        $this->recordsPerQuery = $recordsPerQuery;
        $this->records         = array();
    }

    public function insert(array $record, array $options = array())
    {
        if (count($record) !== $this->columnSize) {
            throw new InvalidArgumentException('Size of columns is unmatched');
        }

        $this->records[] = $record;
        $this->options   = $options;

        if (count($this->records) >= $this->recordsPerQuery) {
            $this->flush();
        }
    }

    public function flush()
    {
        if (count($this->records) === 0) {
            return;
        }

        $result = $this->db->execute(
            $this->table,
            $this->columns,
            $this->records,
            $this->options
        );

        if ($result === false) {
            $this->emit('error', array($this->records));
        }

        $this->records = array();
    }

    public function __destruct()
    {
        $this->flush();
    }
}
