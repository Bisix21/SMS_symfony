<?php

namespace App\Repository;

use App\Entity\StudyClass;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudyClass>
 *
 * @method StudyClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudyClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudyClass[]    findAll()
 * @method StudyClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudyClassRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, StudyClass::class);
	}

//    /**
//     * @return StudyClass[] Returns an array of StudyClass objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StudyClass
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

	public function addStudents($users, StudyClass $studyClass, UserRepository $userRepository){
		foreach ( $users as $user) {
			$studyClass->addStudents($userRepository->find($user->getId()));
		}
	}




}
