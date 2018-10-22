<?php

namespace App\Service;

use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;

class Pagination
{
  # Represents the entity to paginate (Comment / Booking)
  private $entityClass;
  private $limit = 10;
  private $currentPage = 1;
  private $manager;
  private $twig;
  private $route;
  private $templatePath;

  public function __construct(ObjectManager $manager, Environment $twig, RequestStack $request, $templatePath) {
    $this->route        = $request->getCurrentRequest()->attributes->get('_route');
    $this->manager      = $manager;
    $this->twig         = $twig;
    $this->templatePath = $templatePath;
  }

  /**
   * Display the HTML template of pagination
   *
   * @return Response
   */
  public function display() {
    $this->twig->display($this->templatePath, [
      'page'  => $this->currentPage,
      'pages' => $this->getPages(),
      'route' => $this->route
    ]);
  }

  /**
   * Get a number of entries based on the limit
   *
   * @return Array $data
   */
  public function getData() {
    if(empty($this->entityClass)) {
      throw new \Exception("Entity Class Name not found. Use setEntityClass() from your Pagination object.");
    }
    # get offset
    $offset = $this->currentPage * $this->limit - $this->limit;

    # get repository
    $repo = $this->manager->getRepository($this->entityClass);
    $data = $repo->findBy([], [], $this->limit, $offset);

    # send data
    return $data;
  }

  /**
   * Get the number of pages needed for pagination
   *
   * @return Integer $pages
   */
  public function getPages() {
    if(empty($this->entityClass)) {
      throw new \Exception("Entity Class Name not found. Use setEntityClass() from your Pagination object.");
    }
    #total of entries of X Entity
    $repo = $this->manager->getRepository($this->entityClass);
    $total = count($repo->findAll());

    $pages = ceil($total / $this->limit);

    return $pages;
  }

  public function setEntityClass($entityClass) {
    $this->entityClass = $entityClass;
    return $this;
  }

  public function getEntityClass() {
    return $this->entityClass;
  }

  public function setLimit($limit) {
    $this->limit = $limit;
    return $this;
  }

  public function getLimit() {
    return $this->limit;
  }

  public function setCurrentPage($currentPage) {
    $this->currentPage = $currentPage;
    return $this;
  }

  public function getCurrentPage() {
    return $this->currentPage;
  }

  public function setRoute($route) {
    $this->route = $route;
    return $this;
  }

  public function getRoute() {
    return $this->route;
  }

  public function setTemplatePath($templatePath) {
    $this->templatePath = $templatePath;
    return $this;
  }

  public function getTemplatePath() {
    return $this->templatePath;
  }
}