<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class Stats
{
  private $manager;

  public function __construct(ObjectManager $manager) {
    $this->manager = $manager;
  }

  /**
   * Get all stats from DB
   *
   * @return Array
   */
  public function getStats() {
    $users    = $this->getUsersCount();
    $ads      = $this->getAdsCount();
    $bookings = $this->getBookingsCount();
    $comments = $this->getCommentsCount();

    return compact('users', 'ads', 'bookings', 'comments');
  }

  /**
   * Get best or worst ads based on average rating
   *
   * @param String $order (ASC for best, DESC for worst)
   * @return Array
   */
  public function getAdsStats($order) {
    return $this->manager->createQuery(
      'SELECT AVG(c.rating) as rating, a.title, a.id, u.firstName, u.lastName, u.avatar 
      FROM App\Entity\Comment c 
      JOIN c.ad a 
      JOIN a.author u 
      GROUP BY a
      ORDER BY rating ' . $order)
      ->setMaxResults(5)
      ->getResult()
    ;
  }

  public function getUsersCount() {
    return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
  }

  public function getAdsCount() {
    return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a')->getSingleScalarResult();
  }

  public function getBookingsCount() {
    return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking b')->getSingleScalarResult();
  }

  public function getCommentsCount() {
    return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();
  }
}