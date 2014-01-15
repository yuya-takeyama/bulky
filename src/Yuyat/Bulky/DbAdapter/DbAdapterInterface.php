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
 * Interface of database.
 *
 * @author Yuya Takeyama
 */
interface Yuyat_Bulky_DbAdapter_DbAdapterInterface
{
    public function execute($table, $columns, array $records, array $options = array());
}
