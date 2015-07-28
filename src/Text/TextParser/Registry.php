<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28/07/15
 * Time: 14:58
 */

namespace Aot\Text\TextParser;


class Registry
{
    protected $index = 0;
    protected $registry = [];

    public static function create()
    {
        return new static();
    }

    /**
     * @param $record
     */
    public function add($record)
    {
        $this->registry[++$this->index] = $record;
    }

    /**
     * @param int $index
     * @return string|bool
     */
    public function get($index)
    {
        if (is_int($index) && !empty($this->registry[$index])) {
            return $this->registry[$index];
        }

        return false;
    }
}