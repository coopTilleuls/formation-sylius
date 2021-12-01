<?php

namespace App\Repository\Admin;

use App\Entity\Cms\Page;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageRepository extends EntityRepository implements RepositoryInterface
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
