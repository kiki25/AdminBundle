<?php

namespace Symfonian\Indonesia\AdminBundle\EventListener;

use Symfonian\Indonesia\AdminBundle\Event\FilterEntityEvent;
use Symfonian\Indonesia\AdminBundle\Handler\UploadHandler;
use Symfonian\Indonesia\AdminBundle\Security\Model\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: https://github.com/ihsanudin.
 */
class UploadAvatarListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onPreSave(FilterEntityEvent $event)
    {
        $entity = $event->getEntity();

        /** @var UploadHandler $uploadHandler */
        $uploadHandler = $this->container->get('symfonian_id.admin.handler.upload');

        if ($uploadHandler->isUploadable() && $entity instanceof User) {
            $uploadDir = $this->container->getParameter('symfonian_id.admin.upload_dir');
            $uploadHandler->setUploadDir($uploadDir['server_path']);
            $uploadHandler->upload($entity);
        }
    }
}