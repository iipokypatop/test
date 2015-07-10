<?php
namespace Aot\RussianMorphology\ChastiRechi\Prichastie;
use Aot\RussianMorphology\Slovo;

/**
 * Class Base
 * @package Aot\RussianMorphology\ChastiRechi\Prichastie
 * @property Morphology\Chislo\Base $chislo
 */

class Base extends Slovo
{
    /**
     * @return array
     */
    public function getMorphology()
    {
        return [
            'chislo' => Morphology\Chislo\Base::class,
            'forma' => Morphology\Forma\Base::class,
            'padeszh' => Morphology\Padeszh\Base::class,
            'perehodnost' => Morphology\Perehodnost\Base::class,
            'rod' => Morphology\Rod\Base::class,
            'vid' => Morphology\Vid\Base::class,
            'vozvratnost' => Morphology\Vozvratnost\Base::class,
            'vremya' => Morphology\Vremya\Base::class,
            'razryad' => Morphology\Razryad\Base::class,
        ];
    }

    public static function create(
        $text,
        Morphology\Chislo\Base $chislo,
        Morphology\Forma\Base $forma,
        Morphology\Padeszh\Base $padeszh,
        Morphology\Perehodnost\Base $perehodnost,
        Morphology\Rod\Base $rod,
        Morphology\Vid\Base $vid,
        Morphology\Vozvratnost\Base $vozvratnost,
        Morphology\Vremya\Base $vremya,
        Morphology\Razryad\Base $razryad
    )
    {
        $ob = new static($text);

        $ob->chislo = $chislo;
        $ob->forma = $forma;
        $ob->padeszh = $padeszh;
        $ob->rod = $rod;
        $ob->perehodnost = $perehodnost;
        $ob->vid = $vid;
        $ob->vozvratnost = $vozvratnost;
        $ob->vremya = $vremya;
        $ob->razryad = $razryad;

        return $ob;
    }
}