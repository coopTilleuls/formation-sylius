<?php

namespace App\Repository\Admin;

use App\Entity\Cms\Page;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageRepository extends EntityRepository
{
    public function getBySlug(string $slug): Page
    {
        $page = $this->findOneBy(['slug' => $slug]);

        if (!$page) {
            throw new NotFoundHttpException();
        }

        return $page;
    }
}
