<?php

namespace App\Event\Listener\Admin\Cms\Page;

use App\Entity\Cms\Page;
use LogicException;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Symfony\Component\String\Slugger\AsciiSlugger;

class PageUpdateListener
{
    public function __invoke(ResourceControllerEvent $event): void
    {
        $page = $event->getSubject();

        if (!$page instanceof Page) {
            throw new LogicException();
        }
        $page->setSlug(strtolower((new AsciiSlugger())->slug($page->getTitle())));
    }
}
