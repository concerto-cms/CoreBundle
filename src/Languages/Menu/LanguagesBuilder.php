<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 3/01/15
 * Time: 20:51
 */

namespace ConcertoCms\CoreBundle\Languages\Menu;

use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Languages\Service\LanguagesManager;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class LanguagesBuilder
{
    private $lm;

    public function __construct(LanguagesManager $lm)
    {
        $this->lm = $lm;
    }

    public function build(FactoryInterface $factory, Request $request)
    {
        $root = $factory->createItem("LanguagesMenu");
        if (isset($options["parentClass"])) {
            $root->setAttribute("class", $options["parentClass"]);
        }
        $languages = $this->lm->getAll();
        /**
         * @var $lang LanguageRoute
         */
        foreach ($languages as $lang) {
            $child = $root->addChild(
                $lang->getLocale()->getName(),
                array(
                    'route' => $lang->getId()
                )
            );
            if ($request->getLocale() == $lang->getLocale()->getPrefix()) {
                $child->setCurrent(true);
            }
        }
        return $root;
    }
}
