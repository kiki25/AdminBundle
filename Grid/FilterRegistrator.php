<?php

namespace Symfonian\Indonesia\AdminBundle\Grid;

/*
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: https://github.com/ihsanudin
 */

use Symfonian\Indonesia\AdminBundle\Annotation\Grid;
use Symfonian\Indonesia\AdminBundle\Configuration\ConfigurationFactory;
use Symfonian\Indonesia\AdminBundle\Controller\CrudController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class FilterRegistrator
{
    /**
     * @var ConfigurationFactory
     */
    protected $configurationFactory;

    /**
     * @var array
     */
    protected $filter = array();

    public function __construct(ConfigurationFactory $configurationFactory)
    {
        $this->configurationFactory = $configurationFactory;
    }

    public function setFilter(array $filter)
    {
        $this->filter = $filter;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        $controller = $controller[0];

        if (!$controller instanceof CrudController) {
            return;
        }

        $grid = new Grid();
        $grid->setFilters($this->filter);

        $this->configurationFactory->addConfiguration($grid);
    }
}