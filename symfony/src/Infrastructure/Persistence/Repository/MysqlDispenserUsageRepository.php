<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\DispenserUsage;
use App\Domain\DispenserUsageRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

class MysqlDispenserUsageRepository extends ServiceEntityRepository
    implements DispenserUsageRepository
{
    private EntityManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DispenserUsage::class);

        $this->em = $this->getEntityManager();
    }

    public function save(DispenserUsage $dispenserUsage): void
    {
        $this->em->persist($dispenserUsage);
        $this->em->flush();
    }

    public function findLast(string $id): ?DispenserUsage
    {
        return $this->findOneBy(['id' => $id], ['openedAt' => 'DESC']);
    }

    public function fetchById(string $id): array
    {
        return $this->findBy(['id' => $id]);
    }
}