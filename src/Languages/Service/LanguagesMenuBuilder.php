<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 23/06/14
 * Time: 20:19
 */
namespace ConcertoCms\CoreBundle\Languages\Service;

use ConcertoCms\CoreBundle\Service\Content;
use Knp\Menu\FactoryInterface;
use PHPCRProxies\__CG__\ConcertoCms\CoreBundle\Document\LanguageRoute;
use Symfony\Component\HttpFoundation\Request;

class LanguagesMenuBuilder
{
    /**
     * @var Content
     */
    private $cm;

    public function __construct(Content $cm)
    {
        $this->cm = $cm;
    }

    public function build(FactoryInterface $factory, Request $request)
    {
        $root = $factory->createItem("LanguagesMenu");
        if (isset($options["parentClass"])) {
            $root->setAttribute("class", $options["parentClass"]);
        }
        $languages = $this->cm->getLanguages();
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
