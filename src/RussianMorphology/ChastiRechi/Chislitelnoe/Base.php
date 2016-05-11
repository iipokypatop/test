<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/07/15
 * Time: 17:44
 */

namespace Aot\RussianMorphology\ChastiRechi\Chislitelnoe;


use Aot\RussianMorphology\Slovo;

/**
 * Class Base
 * @package Aot\RussianMorphology\ChastiRechi\Chislitelnoe
 * @property Morphology\Vid\Base $vid
 * @property Morphology\Tip\Base $tip
 * @property Morphology\Podvid\Base $podvid
 * @property Morphology\Chislo\Base $chislo
 * @property Morphology\Rod\Base $rod
 * @property Morphology\Padeszh\Base $padeszh
 */
class Base extends Slovo
{
    /** @var  int */
    protected $digital_view;

    /**
     * @param int|double $value
     */
    public function setDigitalView($value)
    {
        assert(is_numeric($value));
        $this->digital_view = $value;
    }

    public static function getMorphology()
    {
        return [
            'vid' => Morphology\Vid\Base::class,
            'tip' => Morphology\Tip\Base::class,
            'podvid' => Morphology\Podvid\Base::class,
            'chislo' => Morphology\Chislo\Base::class,
            'rod' => Morphology\Rod\Base::class,
            'padeszh' => Morphology\Padeszh\Base::class
        ];
    }

    /**
     * Chislitelnoe constructor.
     * @param $text
     * @param Morphology\Vid\Base $vid
     * @param Morphology\Tip\Base $tip
     * @param Morphology\Podvid\Base $podvid
     * @param Morphology\Chislo\Base $chislo
     * @param Morphology\Rod\Base $rod
     * @param Morphology\Padeszh\Base $padeszh
     * @return static
     */
    public static function create(
        $text,
        Morphology\Vid\Base $vid,
        Morphology\Tip\Base $tip,
        Morphology\Podvid\Base $podvid,
        Morphology\Chislo\Base $chislo,
        Morphology\Rod\Base $rod,
        Morphology\Padeszh\Base $padeszh
    )
    {

        $ob = new static($text);

        $ob->vid = $vid;
        $ob->tip = $tip;
        $ob->podvid = $podvid;
        $ob->chislo = $chislo;
        $ob->rod = $rod;
        $ob->padeszh = $padeszh;

        return $ob;
    }

    /**
     * @return int
     * @throws \Aot\Exception
     */
    public function getDigitalView()
    {
        if ($this->digital_view === null) {
            return \Aot\RussianMorphology\ChastiRechi\Chislitelnoe\Helper::convertToDigital($this->initial_form);
        }
        return $this->digital_view;
    }
    
}