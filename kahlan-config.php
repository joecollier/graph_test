<?php
use kahlan\filter\Filter as Filter;
use kahlan\jit\Interceptor;
use kahlan\reporter\Coverage;
use kahlan\jit\patcher\Layer;

// use W3\Phoenix\Core\Context\PhoenixContext;

Filter::register('mycustom.namespaces', function($chain) {
    $this->_autoloader->addPsr4('Editor\\Library\\', __DIR__ . '/src/Library');
    // $this->_autoloader->addPsr4('W3\\Phoenix\\Core\\Utilities\\', __DIR__ . '/vendor/W3/Phoenix/Core/Utilities/');
    // $this->_autoloader->addPsr4('W3\\Phoenix\\FiftyFive\\Library\\', __DIR__ . '/src/Library/');
    // $this->_autoloader->addPsr4('W3\\Phoenix\\FiftyFive\\Listeners\\', __DIR__ . '/src/Listeners/');
    // $this->_autoloader->addPsr4('W3\\Phoenix\\FiftyFive\\Models\\', __DIR__ . '/src/Models/');
    // $this->_autoloader->addPsr4('W3\\Phoenix\\FiftyFive\\Transformers\\', __DIR__ . '/src/Transformers/');
    // $this->_autoloader->addPsr4('W3\\Vivastreet\\Classified\\Models\\', __DIR__ . '/vendor/W3/Vivastreet/Classified/Models/');
});

Filter::apply($this, 'namespaces', 'mycustom.namespaces');
Filter::register('api.patchers', function($chain) {
    if (!$interceptor = Interceptor::instance()) {
        return;
    }
    $patchers = $interceptor->patchers();
    // $patchers->add('layer', new Layer([
    //     'override' => [
    //         'Phalcon\Mvc\Model' // Will dynamically apply a layer on top of the `Phalcon\Mvc\Model` when extended.
    //     ]
    // ]));
    return $chain->next();
});
Filter::apply($this, 'patchers', 'api.patchers');

// /**
//  * Initializing a custom coverage reporter
//  */

Filter::register('app.coverage', function($chain) {
    $reporters = $this->reporters();

    if ($this->args()->exists('coverage')) {
        // Limit the Coverage analysis to only a couple of directories only
        $coverage = new Coverage([
                'verbosity' => $this->args()->get('coverage'),
                'driver' => new \kahlan\reporter\coverage\driver\Xdebug(),
                'path' => [
                    // 'src/Listeners',
                    'src/Library',
                    // 'src/Models',
                    // 'src/Transformers'
                ]
        ]);
        $reporters->add('coverage', $coverage);
    }

    return $reporters;
});

Filter::apply($this, 'coverage', 'app.coverage');

// /**
//  * Initializing a DI
//  */
// $di = new \Phalcon\DI\FactoryDefault();

// $dbs = ['db_master', 'db_slave', 'dbcommon_master', 'dbcommon_slave'];

// foreach ($dbs as $db) {
//     $di->setShared($db, function() {
//         return new \Phalcon\Db\Adapter\Pdo\Sqlite([
//             'dbname' => __DIR__ . '/spec/db.sqlite',
//             ]);
//     });
// }

// $di->set('modelsCache', function () {
//     $stub = kahlan\plugin\Stub::create(['implements' => ['Phalcon\Cache\BackendInterface']]);
//     return $stub;
// });

// defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)));

// if (is_readable(APPLICATION_PATH . '/config/config.php')) {
//     $config = include APPLICATION_PATH . '/config/config.php';
//     $di->set('config', $config);
// }

// $context = new PhoenixContext($di);
// $di->setShared(PhoenixContext::DI_KEY, $context);

// \Phalcon\DI::setDefault($di);

// $context = new PhoenixContext($di);
// $di->setShared(PhoenixContext::DI_KEY, $context);