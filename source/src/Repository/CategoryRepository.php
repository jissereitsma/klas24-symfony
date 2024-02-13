<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param $id
     * @param $lockMode
     * @param $lockVersion
     * @return Category
     * @throws NotFoundHttpException
     */
    /*
    public function find($id, $lockMode = null, $lockVersion = null): Category
    {
        $category = parent::find($id, $lockMode, $lockVersion);
        if (!$category instanceof Category) {
            throw new NotFoundHttpException('Category not found exception');
        }

        return $category;
    }*/
}
