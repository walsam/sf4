<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getLastThreeProducts(){
        $query = $this->getEntityManager()->getRepository('App:Product')
            ->createQueryBuilder('a')
            ->select('a.id,a.price,a.name,a.quantity,a.description,a.imageURL, a.createAt')
            ->orderBy('a.id', 'DESC')->getQuery()->setMaxResults(3);
        $products= $query->getResult();
        return $products;

    }
}
