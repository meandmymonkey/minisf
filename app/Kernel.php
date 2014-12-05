<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Debug\Debug;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;

class Kernel extends SymfonyKernel
{
    public function __construct(
        $envVar = 'SYMFONY_ENV',
        $debugVar = 'SYMFONY_DEBUG'
    ) {
        if (!getenv($envVar) || 'cli-server' === php_sapi_name()) {
            \Dotenv::makeMutable();
            \Dotenv::load($this->getRootDir().'/..');
        }
        
        $env = getenv($envVar);
        $debug = (bool)getenv($debugVar);
        
        if ($debug) {
            Debug::enable();
        }
        
        parent::__construct($env, $debug);
    }
    
    public function registerBundles()
    {
        $bundles = array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle()
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->rootDir.'/config.yml');

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $loader->load(
                function (ContainerBuilder $container) {
                    $container->loadFromExtension(
                        'web_profiler',
                        array(
                            'toolbar' => true,
                        )
                    );
                }
            );
        }
    }

    public function getCacheDir()
    {
        return $this->rootDir.'/../var/cache';
    }

    public function getLogDir()
    {
        return $this->rootDir.'/../var/log';
    }
}