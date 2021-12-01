<?php

namespace App\Event\Listener\Admin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class MenuListener
{
    public function __invoke(MenuBuilderEvent $event): void
    {
        $child = $event->getMenu()->addChild('cms');
        $child->setLabel('admin.menu.cms');

        $child->addChild('pages', [
            'label' => 'admin.menu.pages',
            'route' => 'admin_cms_page_index',
        ])->setLabelAttribute('icon', 'edit');
        $child->addChild('blocks', [
            'label' => 'admin.menu.blocks',
            'route' => 'admin_cms_block_index',
        ]);
    }
}
