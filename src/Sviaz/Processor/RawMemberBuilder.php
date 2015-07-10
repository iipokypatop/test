<?php
/**
 * Created by PhpStorm.
 * User: p.semenyuk
 * Date: 05.07.2015
 * Time: 4:00
 */

namespace Aot\Sviaz\Processor;


use Aot\RussianMorphology\Slovo;
use Aot\Sviaz\SequenceMember\Punctuation;

class RawMemberBuilder
{
    /** @var  \Aot\Sviaz\Processor\ObjectRegistry */
    protected $registry;
    /** @var \Aot\Sviaz\SequenceMember\Base[]  */
    protected $store = [];

    /**
     * MemberBuilder constructor.
     */
    protected function __construct()
    {
        $this->registry = \Aot\Sviaz\Processor\ObjectRegistry::create();
    }

    public static function create()
    {
        return new static();
    }

    /**
     * @param $ob
     * @return \Aot\Sviaz\SequenceMember\Base
     */
    public function build($ob)
    {
        $id = $this->registry->registerMember($ob);

        if (!empty($this->store[$id])) {
            return $this->store[$id];
        }

        if ($ob instanceof \Aot\RussianSyntacsis\Punctuaciya\Base) {

            $this->store[$id] = Punctuation::create($ob);

        } elseif ($ob instanceof Slovo) {

            $this->store[$id] = \Aot\Sviaz\SequenceMember\Word\Base::create($ob);
        }

        if (!empty($this->store[$id])) {
            return $this->store[$id];
        }

        throw new \RuntimeException("unsupported object type ");
    }
}