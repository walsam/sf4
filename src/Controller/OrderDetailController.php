<?php

namespace App\Controller;

use App\Entity\OrderDetail;
use App\Form\OrderDetailType;
use App\Repository\OrderDetailRepository;
use App\Repository\ProductRepository;
use phpDocumentor\Reflection\Types\Null_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orderdetail")
 */
class OrderDetailController extends AbstractController
{
    private $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("AddOrderDetail" ,name="AddOrderDetail")
     * @Method({"GET", "POST"})
     */
    public function addOrderDetail(Request $request)
    {
        $orderDetail = new OrderDetail();
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('App:Product')->findOneBy([
            'id' => $request->request->get("productID")
        ]);
        if ($this->session->get("orderId")==null) {
            $this->session->set('orderId',1);
        }
        $order = $em->getRepository('App:Order')->findOneBy([
            'id' => $this->session->get("orderId")
        ]);
        $orderDetail->setOrder($order);
        $orderDetail->setProduct($product);
        $orderDetail->setQuantity($request->request->get("CommandQuantity"));
        $em->persist($orderDetail);
        $em->flush();
        $stock= $product->getQuantity() - $request->request->get("CommandQuantity");
        $em->getRepository('App:Product')->updateStock($request->request->get("productID"),$stock);
        return $this->redirectToRoute('product_index');

    }
    /**
     * @Route("/{id}", name="order_detail_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OrderDetail $orderDetail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderDetail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orderDetail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_detail_index');
    }
}
