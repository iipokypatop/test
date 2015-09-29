<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 13/07/15
 * Time: 13:54
 */

namespace Aot\RussianMorphology\ChastiRechi\Infinitive;


use Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Vid\Nesovershennyj;
use Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Vid\Sovershennyj;
use Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Vid\Null as NullVid;

use Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Perehodnost\Neperehodnyj;
use Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Perehodnost\Perehodnyj;
use Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Perehodnost\Null as NullPerehodnost;

use Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Vozvratnost\Nevozvratnyj;
use Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Vozvratnost\Vozvratnyj;
use Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Vozvratnost\Null as NullVozvratnost;

use Aot\RussianMorphology\FactoryException;
use Dw;
use Word;

class Factory extends \Aot\RussianMorphology\Factory
{

    /**
     * @param Dw $dw
     * @param Word $word
     * @return \Aot\RussianMorphology\ChastiRechi\Infinitive\Base[]
     * @throws \Exception
     */
    public function build(Dw $dw, Word $word)
    {
        $text = $dw->word_form;
        $words = [];
        if (isset($word->word) && intval($dw->id_word_class) === INFINITIVE_CLASS_ID ) {

            # вид
            $vid = $this->getVid($dw->parameters);

            # переходность
            $perehodnost = $this->getPerehodnost($dw->parameters);

            # возвратность
            $vozvratnost = $this->getVozvratnost($dw->parameters);

            foreach ($perehodnost as $val_perehodnost) {
                foreach ($vid as $val_vid) {
                    foreach ($vozvratnost as $val_vozvratnost) {
                        $words[] = $word = Base::create(
                            $text,
                            $val_perehodnost,
                            $val_vid,
                            $val_vozvratnost
                        );

                        $word->setInitialForm($dw->initial_form);
                    }
                }
            }


        }
        return $words;
    }


    /**
     * @param array $parameters
     * @return \Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Vid\Base[]
     */
    protected function getVid($parameters)
    {

        if (empty($parameters[VIEW_ID])) {
            return [NullVid::create()];
        }

        $param = $parameters[VIEW_ID];
        $vid = [];
        foreach ($param->id_value_attr as $val) {
            if (intval($val) === VIEW_PERFECTIVE_ID) {
                $vid[] = Sovershennyj::create();
            } elseif (intval($val) === VIEW_IMPERFECT_ID) {
                $vid[] = Nesovershennyj::create();
            } else {
                throw new \RuntimeException('Unsupported value exception = ' . var_export($val, 1));
            }
        }

        return $vid;
    }

    /**
     * @param array $parameters
     * @return \Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Perehodnost\Base[]
     */
    protected function getPerehodnost($parameters)
    {

        if (empty($parameters[TRANSIVITY_ID])) {
            return [NullPerehodnost::create()];
        }

        $param = $parameters[TRANSIVITY_ID];

        $perehodnost = [];
        foreach ($param->id_value_attr as $val) {
            if (intval($val) === \OldAotConstants::TRANSITIVE()) {
                $perehodnost[] = Perehodnyj::create();
            } elseif (intval($val) === \OldAotConstants::INTRANSITIVE()) {
                $perehodnost[] = Neperehodnyj::create();
            } else {
                throw new \RuntimeException('Unsupported value exception = ' . var_export($val, 1));
            }
        }

        return $perehodnost;
    }

    /**
     * @param array $parameters
     * @return \Aot\RussianMorphology\ChastiRechi\Infinitive\Morphology\Vozvratnost\Base[]
     */
    protected function getVozvratnost($parameters)
    {

        if (empty($parameters[\OldAotConstants::RETRIEVABLE_IRRETRIEVABLE()])) {
            return [NullVozvratnost::create()];
        }

        $param = $parameters[\OldAotConstants::RETRIEVABLE_IRRETRIEVABLE()];
        $vozvratnost = [];
        foreach ($param->id_value_attr as $val) {
            if (intval($val) === \OldAotConstants::RETRIEVABLE()) {
                $vozvratnost[] = Vozvratnyj::create();
            } elseif (intval($val) === \OldAotConstants::IRRETRIEVABLE()) {
                $vozvratnost[] = Nevozvratnyj::create();
            } else {
                throw new \RuntimeException('Unsupported value exception = ' . var_export($val, 1));
            }
        }

        return $vozvratnost;
    }

}