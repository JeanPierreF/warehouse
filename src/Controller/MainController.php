<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class MainController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'main')]
    public function index(): Response
    {
        
        $qb = $this->em->createQueryBuilder();

        $qb->select('o.id AS cmdId', 'o.quantity_order AS orderQty', 'p.name AS pdtName', 'pa.reference AS refParcel', 'pa.occupancy AS occupancy', 'pa.storage AS storage','pack.id AS packId' ,'pack.quantity_max AS qtyMax')
           ->from('App\Entity\Orders', 'o')
           ->leftJoin('App\Entity\Products', 'p', 'WITH', 'o.id_products = p.id')
           ->leftJoin('App\Entity\Packages', 'pa', 'WITH', 'p.id_packages = pa.id')
           ->leftJoin('App\Entity\Packagings', 'pack', 'WITH', 'pack.id_packages = pa.id')
           ->where('o.id = :orderId')
           ->andWhere('pack.id_product = o.id_products');

        $query = $qb->getQuery();
        $query->setParameter('orderId', 356);

        //$results = $query->getArrayResult();
        $results = $query->getSingleResult();

               
        
       
        return $this->render('main/index.html.twig', ['results' => $results]);
    }
}
