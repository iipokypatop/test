<?php
/**
 * Created by PhpStorm.
 * User: p.semenyuk
 * Date: 30.07.2015
 * Time: 14:03
 */

namespace AotTest\Functional\Sviaz\Podchinitrelnaya\Filters;


use Aot\RussianMorphology\ChastiRechi\Glagol\Base as Glagol;
use Aot\RussianMorphology\ChastiRechi\Predlog\Base as Predlog;
use Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Base as Prilagatelnoe;
use Aot\RussianMorphology\ChastiRechi\Soyuz\Base;
use Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Base as Suschestvitelnoe;
use Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Base as SuschestvitelnoePadeszhBase;
use Aot\RussianSyntacsis\Punctuaciya\Zapiataya;
use Aot\Sviaz\Rule\AssertedMatching\MorphologyMatchingOperator\Eq;
use MivarTest\PHPUnitHelper;
use \Aot\RussianMorphology\ChastiRechi\ChastiRechiRegistry;
use Aot\RussianMorphology\ChastiRechi\MorphologyRegistry;
use Aot\Sviaz\Role\Registry as RoleRegistry;
use Aot\Sviaz\Rule\Checker\Registry as LinkCheckerRegistry;
use Aot\Sviaz\Rule\AssertedMember\Checker\Registry as MemberCheckerRegistry;
use Aot\Sviaz\Rule\Builder\Base as AssertedLinkBuilder;
use Aot\Sviaz\Rule\AssertedMember\PositionRegistry;
use Aot\Sviaz\Rule\AssertedMember\PresenceRegistry;
use Aot\Text\GroupIdRegistry;

class HomogeneityTest extends \AotTest\AotDataStorage
{
    public function testLaunch()
    {
        //$homogeneity=\Aot\Sviaz\Homogeneity::create();
    }

    public function testCreateSequenceWithHomogeneity()
    {
        //СОздаём процессор
        $processor = \Aot\Sviaz\Processor\Base::create();

        $sequences = $processor->go(
            $this->getNormalizedMatrix1(),
            [

                $this->getRule1(),
                $this->getRule2(),
                $this->getRule3(),
                $this->getRule4(),
                $this->getRule5(),
                $this->getRule6()
            ]
        );

        //print_r($this->getProstoyMassivSviazi($sequences[0]->getSviazi()));
        $homogeneities=$sequences[0]->getHomogeneities();

        $i=0;
    }




    /** @var \Aot\Sviaz\Podchinitrelnaya\Base[] $sviazi */
    protected function printSviazi($sviazi)
    {
        $result = array_filter([$sviazi]);
        $pretty = $this->pretty(
            $result
        );
        echo join("\n", $pretty);
        echo "\n";

    }

    /** @var \Aot\Sviaz\Podchinitrelnaya\Base[] $sviazi */
    protected function getProstoyMassivSviazi($sviazi)
    {
        $result = [];
        foreach ($sviazi as $sviaz) {
            $result[] = [
                'main' => $sviaz->getMainSequenceMember()->getSlovo()->getText(),
                'depended' => $sviaz->getDependedSequenceMember()->getSlovo()->getText(),
                'rule_id' => $sviaz->getRule()->getDao()->getId()
            ];
        }
        return $result;
    }


    public function getSequencesForTests()
    {
        //СОздаём процессор
        $processor = \Aot\Sviaz\Processor\Base::create();

        //Получаем два правила, причё они будут противоречить друг другу
        $rule1 = $this->getRule1();
        $rule2 = $this->getRule2();

        $sequences = $processor->go(
            $this->getNormalizedMatrix1(),
            [$rule1, $rule2]
        );

        $sviazi_container = [];
        foreach ($sequences as $index => $sequence) {
            $sviazi_container[$index] = $sequence->getSviazi();
        }

        return $sviazi_container;
    }


    public function getMock(
        $originalClassName,
        $methods = array(),
        array $arguments = array(),
        $mockClassName = '',
        $callOriginalConstructor = false,
        $callOriginalClone = true,
        $callAutoload = true,
        $cloneArguments = false,
        $callOriginalMethods = false
    ) {
        return parent::getMock($originalClassName, $methods, $arguments, $mockClassName, $callOriginalConstructor,
            $callOriginalClone, $callAutoload, $cloneArguments,
            $callOriginalMethods); // TODO: Change the autogenerated stub
    }


    /**
     * @return \Aot\Text\NormalizedMatrix
     */
    public function getNormalizedMatrix1()
    {
        $matrix = $this->getMatrix1();

        $normalized_matrix = \Aot\Text\NormalizedMatrix::create($matrix);

        return $normalized_matrix;
    }

    public function getMatrix1()
    {
        $mixed = $this->getWordsAndPunctuation1();

        $matrix = \Aot\Text\Matrix::create($mixed);

        return $matrix;
    }

    protected function getWordsAndPunctuation1()
    {
        <<<TEXT
Над горами появились облака – сначала легкие и воздушные, затем серые, с рваными краями
TEXT;
        //$nad[0] = $this->getSafeMockLocal1(Predlog::class, ['__set', 'getMorphology', '__get', 'getMorphologyByClass_TEMPORARY']);
        $nad[0] = $this->getMock(Predlog::class, ['_']);
        PHPUnitHelper::setProtectedProperty($nad[0], 'text', 'Над');

        $gorami[0] = $this->getMock(Suschestvitelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($gorami[0], 'text', 'горами');
        PHPUnitHelper::setProtectedProperty($gorami[0], 'initial_form', 'гора');
        $gorami[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $gorami[0]->naritcatelnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Naritcatelnost\ImiaNaritcatelnoe::create();
        $gorami[0]->odushevlyonnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Odushevlyonnost\Neodushevlyonnoe::create();
        $gorami[0]->padeszh = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Tvoritelnij::create();
        $gorami[0]->rod = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Rod\Zhenskii::create();
        $gorami[0]->sklonenie = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Sklonenie\Null::create();

        $poiavilis[0] = $this->getMock(Glagol::class, ['_']);
        PHPUnitHelper::setProtectedProperty($poiavilis[0], 'text', 'появились');
        PHPUnitHelper::setProtectedProperty($poiavilis[0], 'initial_form', 'появиться');
        $poiavilis[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Chislo\Mnozhestvennoe::create();
        $poiavilis[0]->litso = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Litso\Tretie::create();
        $poiavilis[0]->naklonenie = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Naklonenie\Izyavitelnoe::create();
        $poiavilis[0]->perehodnost = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Perehodnost\Perehodnyj::create();
        $poiavilis[0]->rod = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Rod\Null::create();
        $poiavilis[0]->spryazhenie = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Spryazhenie\Pervoe::create();
        $poiavilis[0]->vid = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Vid\Sovershennyj::create();
        $poiavilis[0]->vozvratnost = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Vozvratnost\Nevozvratnyj::create();
        $poiavilis[0]->vremya = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Vremya\Proshedshee::create();
        $poiavilis[0]->razryad = \Aot\RussianMorphology\ChastiRechi\Glagol\Morphology\Zalog\Null::create();


        $oblaka[0] = $this->getMock(Suschestvitelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($oblaka[0], 'text', 'облака');
        PHPUnitHelper::setProtectedProperty($oblaka[0], 'initial_form', 'облако');
        $oblaka[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Chislo\Edinstvennoe::create();
        $oblaka[0]->naritcatelnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Naritcatelnost\ImiaNaritcatelnoe::create();
        $oblaka[0]->odushevlyonnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Odushevlyonnost\Neodushevlyonnoe::create();
        $oblaka[0]->padeszh = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Roditelnij::create();
        $oblaka[0]->rod = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Rod\Srednij::create();
        $oblaka[0]->sklonenie = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Sklonenie\Null::create();


        $oblaka[1] = $this->getMock(Suschestvitelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($oblaka[1], 'text', 'облака');
        PHPUnitHelper::setProtectedProperty($oblaka[1], 'initial_form', 'облако');
        $oblaka[1]->chislo = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $oblaka[1]->naritcatelnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Naritcatelnost\ImiaNaritcatelnoe::create();
        $oblaka[1]->odushevlyonnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Odushevlyonnost\Neodushevlyonnoe::create();
        $oblaka[1]->padeszh = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Imenitelnij::create();
        $oblaka[1]->rod = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Rod\Srednij::create();
        $oblaka[1]->sklonenie = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Sklonenie\Null::create();

        $oblaka[2] = $this->getMock(Suschestvitelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($oblaka[2], 'text', 'облака');
        PHPUnitHelper::setProtectedProperty($oblaka[2], 'initial_form', 'облако');
        $oblaka[2]->chislo = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $oblaka[2]->naritcatelnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Naritcatelnost\ImiaNaritcatelnoe::create();
        $oblaka[2]->odushevlyonnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Odushevlyonnost\Neodushevlyonnoe::create();
        $oblaka[2]->padeszh = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Imenitelnij::create();
        $oblaka[2]->rod = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Rod\Srednij::create();
        $oblaka[2]->sklonenie = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Sklonenie\Null::create();


        $legkie[0] = $this->getMock(Suschestvitelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($legkie[0], 'text', 'легкие');
        PHPUnitHelper::setProtectedProperty($legkie[0], 'initial_form', 'легкий');

        $legkie[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $legkie[0]->naritcatelnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Naritcatelnost\ImiaNaritcatelnoe::create();
        $legkie[0]->odushevlyonnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Odushevlyonnost\Neodushevlyonnoe::create();
        $legkie[0]->padeszh = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Imenitelnij::create();
        $legkie[0]->rod = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Rod\Srednij::create();
        $legkie[0]->sklonenie = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Sklonenie\Null::create();

        $legkie[1] = $this->getMock(Suschestvitelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($legkie[1], 'text', 'легкие');
        PHPUnitHelper::setProtectedProperty($legkie[1], 'initial_form', 'легкий');
        $legkie[1]->chislo = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $legkie[1]->naritcatelnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Naritcatelnost\ImiaNaritcatelnoe::create();
        $legkie[1]->odushevlyonnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Odushevlyonnost\Neodushevlyonnoe::create();
        $legkie[1]->padeszh = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Imenitelnij::create();
        $legkie[1]->rod = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Rod\Srednij::create();
        $legkie[1]->sklonenie = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Sklonenie\Null::create();

        $legkie[2] = $this->getMock(Suschestvitelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($legkie[2], 'text', 'легкие');
        PHPUnitHelper::setProtectedProperty($legkie[2], 'initial_form', 'легкий');
        $legkie[2]->chislo = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Chislo\Edinstvennoe::create();
        $legkie[2]->naritcatelnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Naritcatelnost\ImiaNaritcatelnoe::create();
        $legkie[2]->odushevlyonnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Odushevlyonnost\Neodushevlyonnoe::create();
        $legkie[2]->padeszh = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Vinitelnij::create();
        $legkie[2]->rod = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Rod\Srednij::create();
        $legkie[2]->sklonenie = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Sklonenie\Null::create();

        $legkie[3] = $this->getMock(Suschestvitelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($legkie[3], 'text', 'легкое');
        PHPUnitHelper::setProtectedProperty($legkie[3], 'initial_form', 'легкий');
        $legkie[3]->chislo = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $legkie[3]->naritcatelnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Naritcatelnost\ImiaNaritcatelnoe::create();
        $legkie[3]->odushevlyonnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Odushevlyonnost\Neodushevlyonnoe::create();
        $legkie[3]->padeszh = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Imenitelnij::create();
        $legkie[3]->rod = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Rod\Srednij::create();
        $legkie[3]->sklonenie = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Sklonenie\Null::create();

        /*
        $legkie[0] = $this->getMock(Prilagatelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($legkie[0], 'text', 'воздушные');
        PHPUnitHelper::setProtectedProperty($legkie[0], 'initial_form', 'воздушный');
        $legkie[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $legkie[0]->forma = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Polnaya::create();
        $legkie[0]->padeszh = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Imenitelnij::create();
        $legkie[0]->razryad = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Null::create();
        $legkie[0]->rod = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Srednij::create();
        $legkie[0]->stepen_sravneniia = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Null::create();*/


        $i[0] = $this->getMock(Base::class, ['_']);
        PHPUnitHelper::setProtectedProperty($i[0], 'text', 'и');


        $vozdushnue[0] = $this->getMock(Prilagatelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($vozdushnue[0], 'text', 'воздушные');
        PHPUnitHelper::setProtectedProperty($vozdushnue[0], 'initial_form', 'воздушный');
        $vozdushnue[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $vozdushnue[0]->forma = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Polnaya::create();
        $vozdushnue[0]->padeszh = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Imenitelnij::create();
        $vozdushnue[0]->razryad = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Null::create();
        //$vozdushnue[0]->rod = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Null::create();
        $vozdushnue[0]->rod = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Srednij::create();
        $vozdushnue[0]->stepen_sravneniia = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Null::create();

        $vozdushnue[1] = $this->getMock(Prilagatelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($vozdushnue[1], 'text', 'воздушные');
        PHPUnitHelper::setProtectedProperty($vozdushnue[1], 'initial_form', 'воздушный');
        $vozdushnue[1]->chislo = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $vozdushnue[1]->forma = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Polnaya::create();
        $vozdushnue[1]->padeszh = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Vinitelnij::create();
        $vozdushnue[1]->razryad = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Null::create();
        $vozdushnue[1]->rod = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Null::create();
        $vozdushnue[1]->stepen_sravneniia = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Null::create();

        $zapiztaya[0] = $this->getMock(Zapiataya::class, ['_']);

        $serye[0] = $this->getMock(Prilagatelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($serye[0], 'text', 'серые');
        PHPUnitHelper::setProtectedProperty($serye[0], 'initial_form', 'серый');

        $serye[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $serye[0]->forma = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Polnaya::create();
        $serye[0]->padeszh = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Imenitelnij::create();
        $serye[0]->razryad = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Null::create();
        $serye[0]->rod = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Null::create();
        $serye[0]->stepen_sravneniia = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Null::create();

        $serye[1] = $this->getMock(Prilagatelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($serye[1], 'text', 'серые');
        PHPUnitHelper::setProtectedProperty($serye[1], 'initial_form', 'серый');
        $serye[1]->chislo = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $serye[1]->forma = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Polnaya::create();
        $serye[1]->padeszh = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Vinitelnij::create();
        $serye[1]->razryad = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Null::create();
        $serye[1]->rod = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Null::create();
        $serye[1]->stepen_sravneniia = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Null::create();

        $zapiztaya[1] = $this->getMock(Zapiataya::class, ['_']);

        #     $s[0] = $this->getSafeMockLocal1(Predlog::class);
        $s[0] = $this->getMock(Predlog::class, ['_']);
        PHPUnitHelper::setProtectedProperty($s[0], 'text', 'с');

        $rvanymi[0] = $this->getMock(Prilagatelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($rvanymi[0], 'text', 'рваными');
        PHPUnitHelper::setProtectedProperty($rvanymi[0], 'initial_form', 'рваный');
        $rvanymi[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $rvanymi[0]->forma = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Polnaya::create();
        $rvanymi[0]->padeszh = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Tvoritelnij::create();
        $rvanymi[0]->razryad = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Null::create();
        $rvanymi[0]->rod = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Null::create();
        $rvanymi[0]->stepen_sravneniia = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Null::create();

        $dranimi[0] = $this->getMock(Prilagatelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($dranimi[0], 'text', 'драными');
        PHPUnitHelper::setProtectedProperty($dranimi[0], 'initial_form', 'драный');
        $dranimi[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $dranimi[0]->forma = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Forma\Polnaya::create();
        $dranimi[0]->padeszh = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Padeszh\Tvoritelnij::create();
        $dranimi[0]->razryad = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Razryad\Null::create();
        $dranimi[0]->rod = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\Rod\Null::create();
        $dranimi[0]->stepen_sravneniia = \Aot\RussianMorphology\ChastiRechi\Prilagatelnoe\Morphology\StepenSravneniya\Null::create();


        $krayami[0] = $this->getMock(Suschestvitelnoe::class, ['_']);
        PHPUnitHelper::setProtectedProperty($krayami[0], 'text', 'краями');
        PHPUnitHelper::setProtectedProperty($krayami[0], 'initial_form', 'край');
        $krayami[0]->chislo = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Chislo\Mnozhestvennoe::create();
        $krayami[0]->naritcatelnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Naritcatelnost\ImiaNaritcatelnoe::create();
        $krayami[0]->odushevlyonnost = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Odushevlyonnost\Neodushevlyonnoe::create();
        $krayami[0]->padeszh = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Padeszh\Tvoritelnij::create();
        $krayami[0]->rod = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Rod\Muzhskoi::create();
        $krayami[0]->sklonenie = \Aot\RussianMorphology\ChastiRechi\Suschestvitelnoe\Morphology\Sklonenie\Null::create();

        return [
            'nad' => $nad,
            'gorami' => $gorami,
            'poiavilis' => $poiavilis,
            'oblaka' => $oblaka,
            'legkie' => $legkie,
            'i' => $i,
            'vozdushnue' => $vozdushnue,
            'zapiztaya' => $zapiztaya,
            'serye' => $serye,
            's' => $s,
            'rvanymi' => $rvanymi,
            'krayami' => $krayami,
            'dranimi' =>$dranimi
        ];
    }



    protected function getRule1()
    {
        $builder =
            \Aot\Sviaz\Rule\Builder2::create()
                ->main(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Main\Base::create(ChastiRechiRegistry::SUSCHESTVITELNOE, RoleRegistry::SVOISTVO)
                        ->text("облака")
                )
                ->depended(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Depended\Base::create(
                        ChastiRechiRegistry::SUSCHESTVITELNOE,
                        RoleRegistry::OTNOSHENIE
                    )
                        ->text("легкие")
                )
                ->link(
                    AssertedLinkBuilder::create()
                        ->dependedAfterMain()
                );
        $rule=$builder->get();
        PHPUnitHelper::setProtectedProperty($rule->getDao(), 'id', "123");
        return $rule;
    }

    protected function getRule2()
    {
        $builder =
            \Aot\Sviaz\Rule\Builder2::create()
                ->main(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Main\Base::create(ChastiRechiRegistry::SUSCHESTVITELNOE, RoleRegistry::SVOISTVO)
                        ->text("облака")
                )
                ->depended(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Depended\Base::create(
                        ChastiRechiRegistry::PRILAGATELNOE,
                        RoleRegistry::OTNOSHENIE
                    )
                        ->text("воздушные")
                )
                ->link(
                    AssertedLinkBuilder::create()
                        ->dependedAfterMain()
                );

        $rule=$builder->get();
        PHPUnitHelper::setProtectedProperty($rule->getDao(), 'id', "123");
        return $rule;
    }

    protected function getRule3()
    {
        $builder =
            \Aot\Sviaz\Rule\Builder2::create()
                ->main(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Main\Base::create(ChastiRechiRegistry::SUSCHESTVITELNOE, RoleRegistry::SVOISTVO)
                        ->text("облака")
                )
                ->depended(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Depended\Base::create(
                        ChastiRechiRegistry::PRILAGATELNOE,
                        RoleRegistry::OTNOSHENIE
                    )
                        ->text("серые")
                )
                ->link(
                    AssertedLinkBuilder::create()
                        ->dependedAfterMain()
                );

        $rule=$builder->get();
        PHPUnitHelper::setProtectedProperty($rule->getDao(), 'id', "123");
        return $rule;
    }

    protected function getRule4()
    {
        $builder =
            \Aot\Sviaz\Rule\Builder2::create()
                ->main(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Main\Base::create(ChastiRechiRegistry::SUSCHESTVITELNOE, RoleRegistry::SVOISTVO)
                        ->text("облака")
                )
                ->depended(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Depended\Base::create(
                        ChastiRechiRegistry::GLAGOL,
                        RoleRegistry::OTNOSHENIE
                    )
                        ->text("появились")
                )
                ->link(
                    AssertedLinkBuilder::create()
                );

        $rule=$builder->get();
        PHPUnitHelper::setProtectedProperty($rule->getDao(), 'id', "4");
        return $rule;
    }

    protected function getRule5()
    {
        $builder =
            \Aot\Sviaz\Rule\Builder2::create()
                ->main(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Main\Base::create(ChastiRechiRegistry::SUSCHESTVITELNOE, RoleRegistry::SVOISTVO)
                        ->text("краями")
                )
                ->depended(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Depended\Base::create(
                        ChastiRechiRegistry::PRILAGATELNOE,
                        RoleRegistry::OTNOSHENIE
                    )
                        ->text("рваными")
                )
                ->link(
                    AssertedLinkBuilder::create()
                );

        $rule=$builder->get();
        PHPUnitHelper::setProtectedProperty($rule->getDao(), 'id', "56");
        return $rule;
    }

    protected function getRule6()
    {
        $builder =
            \Aot\Sviaz\Rule\Builder2::create()
                ->main(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Main\Base::create(ChastiRechiRegistry::SUSCHESTVITELNOE, RoleRegistry::SVOISTVO)
                        ->text("краями")
                )
                ->depended(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Depended\Base::create(
                        ChastiRechiRegistry::PRILAGATELNOE,
                        RoleRegistry::OTNOSHENIE
                    )
                        ->text("драными")
                )
                ->link(
                    AssertedLinkBuilder::create()
                );

        $rule=$builder->get();
        PHPUnitHelper::setProtectedProperty($rule->getDao(), 'id', "56");
        return $rule;
    }

    protected function getRule7()
    {
        $builder =
            \Aot\Sviaz\Rule\Builder2::create()
                ->main(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Main\Base::create(ChastiRechiRegistry::SUSCHESTVITELNOE, RoleRegistry::SVOISTVO)
                        ->text("краями")
                )
                ->depended(
                    \Aot\Sviaz\Rule\AssertedMember\Builder\Depended\Base::create(
                        ChastiRechiRegistry::PRILAGATELNOE,
                        RoleRegistry::OTNOSHENIE
                    )
                        ->text("воздушные")
                )
                ->link(
                    AssertedLinkBuilder::create()
                );

        $rule=$builder->get();
        PHPUnitHelper::setProtectedProperty($rule->getDao(), 'id', "56");
        return $rule;
    }



}