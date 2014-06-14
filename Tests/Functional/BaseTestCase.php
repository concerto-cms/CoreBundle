<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 14/06/14
 * Time: 10:54
 */

namespace ConcertoCms\CoreBundle\Tests\Functional;


use ConcertoCms\CoreBundle\Tests\app\AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;

class BaseTestCase extends WebTestCase
{
    protected static function createKernel(array $options = array())
    {
        require_once(__DIR__ . "/../app/AppKernel.php");
        self::$kernel = new AppKernel('test', true);
        self::configureDB();

        return self::$kernel;
    }
    final protected static function configureDB()
    {
        $application = new \Symfony\Bundle\FrameworkBundle\Console\Application(self::$kernel);
        $application->setAutoExit(false);

        $input = new StringInput("doctrine:phpcr:init:dbal --drop");
        $application->run($input);

        $options = array('command' => 'doctrine:phpcr:repository:init');
        $input = new ArrayInput($options);
        $application->run($input);

        $options = array('command' => 'concerto:fixtures:load');
        $input = new ArrayInput($options);
        $application->run($input);
    }
}
