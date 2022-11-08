<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Dispenser;
use App\Domain\DispenserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

class MysqlDispenserRepository extends ServiceEntityRepository 
    implements DispenserRepository
{
    private EntityManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dispenser::class);

        $this->em = $this->getEntityManager();
    }

    public function save(Dispenser $dispenser): void
    {
        $this->em->persist($dispenser);
        $this->em->flush();
    }

    public function findById(string $id): ?Dispenser
    {
        return $this->find($id);
    }
}