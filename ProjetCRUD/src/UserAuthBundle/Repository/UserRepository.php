<?php

namespace UserAuthBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
	public function FindByEmailPasswordHash($email, $passwordHash)
	{
		$queryBuilder = $this->createQueryBuilder('u');
		$queryBuilder
			->where('u.email = :email')
				->setParameter('email', $email)
			->andWhere('u.password = :password')
				->setParameter('password', $passwordHash);

		return $queryBuilder->getQuery()->getResult();
	}

	public function FindByEmail($email)
	{
		$queryBuilder = $this->createQueryBuilder('u');
		$queryBuilder
			->where('u.email = :email')
				->setParameter('email', $email);
		
		return $queryBuilder->getQuery()->getResult();
	}
}
