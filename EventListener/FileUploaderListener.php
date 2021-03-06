<?php

/*
 * This file is part of the AdminBundle package.
 *
 * (c) Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfonian\Indonesia\AdminBundle\EventListener;

use Symfonian\Indonesia\AdminBundle\Annotation\Util\Upload;
use Symfonian\Indonesia\AdminBundle\Configuration\Configurator;
use Symfonian\Indonesia\AdminBundle\Event\FilterEntityEvent;
use Symfonian\Indonesia\AdminBundle\Handler\UploadHandler;

/**
 * @author Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 */
class FileUploaderListener
{
    /**
     * @var Configurator
     */
    private $configuration;

    /**
     * @var UploadHandler
     */
    private $uploadHandler;

    /**
     * @var string
     */
    private $uploadDir;

    /**
     * @param Configurator  $configurator
     * @param UploadHandler $uploadHandler
     * @param string        $uploadDir
     */
    public function __construct(Configurator $configurator, UploadHandler $uploadHandler, $uploadDir)
    {
        $this->configuration = $configurator;
        $this->uploadHandler = $uploadHandler;
        $this->uploadDir = $uploadDir;
    }

    public function setUploadField()
    {
        /** @var Upload $upload */
        $upload = $this->configuration->getConfiguration(Upload::class);
        $this->uploadHandler->setFields(array($upload->getUploadable()), array($upload->getTargetField()));
    }

    /**
     * @param FilterEntityEvent $event
     */
    public function onPreSave(FilterEntityEvent $event)
    {
        $entity = $event->getEntity();

        if ($this->uploadHandler->isUploadable()) {
            $this->uploadHandler->setUploadDir($this->uploadDir['server_path']);
            $this->uploadHandler->upload($entity);
        }

        $event->setEntity($entity);
    }
}
