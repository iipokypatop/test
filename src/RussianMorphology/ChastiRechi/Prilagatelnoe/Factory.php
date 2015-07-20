<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/07/15
 * Time: 13:55
 */

namespace Aot\RussianMorphology\ChastiRechi\Prilagatelnoe;

use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Edinstvennoe;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Mnozhestvennoe;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Null as NullChislo;

use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Kratkaya;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Polnaya;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Null as NullForma;

use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Datelnij;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Imenitelnij;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Predlozshnij;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Roditelnij;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Tvoritelnij;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Vinitelnij;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Null as NullPadeszh;

use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Kachestvennoe;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Otnositelnoe;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Pritiazhatelnoe;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Null as NullRazryad;

use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Muzhskoi;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Srednij;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Zhenskij;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Null as NullRod;

use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Polozhitelnaya;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Prevoshodnaya;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Sravnitelnaya;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Null as NullStepenSravneniia;

use Dw;
use Word;

class Factory extends \Aot\RussianMorphology\Factory
{

    public function build(Dw $dw, Word $word)
    {
        $text = $dw->word_form;
        $words = [];

        if (isset($word->word) && intval($dw->id_word_class) === ADJECTIVE_CLASS_ID) {
            # число

            if (!empty($dw->parameters[NUMBER_ID])) {
                $chislo = $this->getChislo($dw->parameters[NUMBER_ID]);
            } else {
                $chislo[] = NullChislo::create();
            }

            # род
            if (!empty($dw->parameters[GENUS_ID])) {
                $rod = $this->getRod($dw->parameters[GENUS_ID]);
            } else {
                $rod[] = NullRod::create();
            }

            # разряд
            if (!empty($dw->parameters[\OldAotConstants::RANK_ADJECTIVES()])) {
                $razryad = $this->getRazryad($dw->parameters[\OldAotConstants::RANK_ADJECTIVES()]);
            } else {
                $razryad[] = NullRazryad::create();
            }

            # форма
            if (!empty($dw->parameters[\OldAotConstants::WORD_FORM()])) {
                $forma = $this->getForma($dw->parameters[\OldAotConstants::WORD_FORM()]);
            } else {
                $forma[] = NullForma::create();
            }

            # степень сравнения
            if (!empty($dw->parameters[DEGREE_COMPOSITION_ID])) {
                $stepen_sravneniia = $this->getStepenSravneniia($dw->parameters[DEGREE_COMPOSITION_ID]);
            } else {
                $stepen_sravneniia[] = NullStepenSravneniia::create();
            }

            # падеж
            if (!empty($dw->parameters[CASE_ID])) {
                $padeszh = $this->getPadeszh($dw->parameters[CASE_ID]);
            } else {
                $padeszh[] = NullPadeszh::create();
            }

            foreach ($chislo as $val_chislo) {
                foreach ($rod as $val_rod) {
                    foreach ($razryad as $val_razryad) {
                        foreach ($forma as $val_forma) {
                            foreach ($stepen_sravneniia as $val_stepen_sravneniia) {
                                foreach ($padeszh as $val_padeszh) {
                                    $words[] = Base::create(
                                        $text,
                                        $val_chislo,
                                        $val_forma,
                                        $val_padeszh,
                                        $val_razryad,
                                        $val_rod,
                                        $val_stepen_sravneniia
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
        return $words;
    }

    private function getChislo($param)
    {
        $chislo = [];
        foreach ($param->id_value_attr as $val) {
            if (intval($val) === NUMBER_SINGULAR_ID) {
                $chislo[] = Edinstvennoe::create();
            } elseif (intval($val) === NUMBER_PLURAL_ID) {
                $chislo[] = Mnozhestvennoe::create();
            }
            else{
                throw new \RuntimeException('Unsupported value exception = ' . var_export($val, 1));
            }
        }

        return $chislo;
    }

    private function getRod($param)
    {
        $rod = [];
        foreach ($param->id_value_attr as $val) {
            if (intval($val) === GENUS_MASCULINE_ID) {
                $rod[] = Muzhskoi::create();
            } elseif (intval($val) === GENUS_NEUTER_ID) {
                $rod[] = Srednij::create();
            } elseif (intval($val) === GENUS_FEMININE_ID) {
                $rod[] = Zhenskij::create();
            }
            else{
                throw new \RuntimeException('Unsupported value exception = ' . var_export($val, 1));
            }
        }
        return $rod;
    }

    private function getRazryad($param)
    {
        $razryad = [];
        foreach ($param->id_value_attr as $val) {
            if (intval($val) === \OldAotConstants::QUALIFYING_ADJECTIVE()) {
                $razryad[] = Kachestvennoe::create();
            } elseif (intval($val) === \OldAotConstants::RELATIVE_ADJECTIVE()) {
                $razryad[] = Otnositelnoe::create();
            } elseif (intval($val) === \OldAotConstants::POSSESSIVE_ADJECTIVE()) {
                $razryad[] = Pritiazhatelnoe::create();
            }
            else{
                throw new \RuntimeException('Unsupported value exception = ' . var_export($val, 1));
            }
        }

        return $razryad;
    }

    private function getForma($param)
    {
        $forma = [];
        foreach ($param->id_value_attr as $val) {
            if (intval($val) === \OldAotConstants::SHORT_WORD_FORM()) {
                $forma[] = Kratkaya::create();
            } elseif (intval($val) === \OldAotConstants::FULL_WORD_FORM()) {
                $forma[] = Polnaya::create();
            }
            else{
                throw new \RuntimeException('Unsupported value exception = ' . var_export($val, 1));
            }
        }
        return $forma;
    }

    private function getStepenSravneniia($param)
    {
        $stepen_sravneniia = [];
        foreach ($param->id_value_attr as $val) {
            if (intval($val) === \OldAotConstants::POSITIVE_DEGREE_COMPARISON()) {
                $stepen_sravneniia[] = Polozhitelnaya::create();
            } elseif (intval($val) === DEGREE_SUPERLATIVE_ID) {
                $stepen_sravneniia[] = Prevoshodnaya::create();
            } elseif (intval($val) === \OldAotConstants::COMPARATIVE_DEGREE_COMPARISON()) {
                $stepen_sravneniia[] = Sravnitelnaya::create();
            }
            else{
                throw new \RuntimeException('Unsupported value exception = ' . var_export($val, 1));
            }
        }

        return $stepen_sravneniia;
    }

    private function getPadeszh($param)
    {
        $padeszh = [];

        foreach ($param->id_value_attr as $val) {
            if (intval($val) === CASE_SUBJECTIVE_ID) {
                $padeszh[] = Imenitelnij::create();
            } elseif (intval($val) === CASE_GENITIVE_ID) {
                $padeszh[] = Roditelnij::create();
            } elseif (intval($val) === CASE_DATIVE_ID) {
                $padeszh[] = Datelnij::create();
            } elseif (intval($val) === CASE_ACCUSATIVE_ID) {
                $padeszh[] = Vinitelnij::create();
            } elseif (intval($val) === CASE_INSTRUMENTAL_ID) {
                $padeszh[] = Tvoritelnij::create();
            } elseif (intval($val) === CASE_PREPOSITIONAL_ID) {
                $padeszh[] = Predlozshnij::create();
            } else{
                throw new \RuntimeException('Unsupported value exception = ' . var_export($val, 1));
            }
        }


        return $padeszh;
    }
}