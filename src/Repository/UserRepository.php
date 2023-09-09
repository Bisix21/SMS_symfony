<?php

namespace App\Repository;

use App\Entity\User;
use App\Enum\RolesEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LogicException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, User::class);
	}

	/**
	 * Used to upgrade (rehash) the user's password automatically over time.
	 */
	public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
	{
		if (!$user instanceof User) {
			throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
		}

		$user->setPassword($newHashedPassword);
		$this->getEntityManager()->persist($user);
		$this->getEntityManager()->flush();
	}

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

	public function getClassUsers(int $class_id): array
	{
		return $this->findBy(['studyClass' => $class_id, 'roles' => RolesEnum::Student]);
	}

	public function getTeachers(): array
	{
		return $this->selectUsersWithCallbackFilter(
			fn(User $user) => in_array(RolesEnum::Teacher, $user->getRoles())
		);
	}

	public function selectUsersWithCallbackFilter(callable $callback): array
	{
		try {
			$data = [];
			$users = $this->findAll();
			foreach ($users as $user) {
				if ($callback($user)) {
					$data[] = $user;
				}
			}
		} catch (LogicException) {
			throw new \LogicException(sprintf('User %s is not verified', $user->getName()));
		}
		return $data;
	}

	public function getTeacherWithClass(int $id): ?User
	{
		return $this->find($id);
	}

	public function getClassmateWithClass(int $classId): array
	{
		return $this->selectUsersWithCallbackFilter(
			function(User $user) use ($classId){
				return in_array(RolesEnum::Classmate, $user->getRoles()) &&
				$user->getStudyClass() === $classId;
			}
		);
	}
}
