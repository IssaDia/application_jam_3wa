<?php

namespace App\Controller;

use App\Entity\LineOrder;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class CheckoutController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/checkout_success', name: 'checkout_success')]
    public function checkout(EntityManagerInterface $manager, SessionInterface $session, OrderRepository $orderRepo, string $token)
    {
       
            $order = $orderRepo->find($session->get("order_waiting"));
            $order->setStatus("PAYMENT_OK");
            $manager->flush();
            return $this->render('checkout/success.html.twig', [
                "order" => $order
            ]);
       
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/checkout_error', name: 'checkout_error')]
    public function error()
    {
        return $this->render('checkout/error.html.twig', []);

    }

    #[IsGranted("ROLE_USER")]
    #[Route('/checkout', name: 'checkout')]
    public function checkout_check(EntityManagerInterface $manager, ProductRepository $productRepo, SessionInterface $session, Request $request)
    {
       
        $stripe_items = [];
        $cart = json_decode($request->getContent(), true)['cart'];
        if (empty($cart)) {
            return $this->redirectToRoute("home");
        }
        $order = new Order;
        $order->setDatetime(new DateTime);
        $order->setStatus("PAYMENT_WAITING");
        $total = 0;

        foreach ($cart as $item) {
            $product = $productRepo->find($item["id"]);
            $line = new LineOrder;
            $line->setProduct($product);
            $line->setQuantity($item["quantity"]);
            $line->setSubtotal($item["quantity"] * $product->getPrice());
            $total += $item["quantity"] * $product->getPrice();
            $order->addLineOrder($line);
          
            $stripe_items[] =
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->getName(),
                        ],
                        'unit_amount' => $product->getPrice(),
                    ],
                    'quantity' => $item["quantity"],
                ];
        }
        $order->setTotal($total);
        $manager->persist($order);
        $manager->flush();
        $session->set("order_waiting", $order->getId());

        \Stripe\Stripe::setApiKey($_ENV["STRIPE_API_KEY"]);
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $stripe_items,
            'mode' => 'payment',
            'success_url' => 'http://localhost:5173/checkout_success',
            'cancel_url' => 'http://localhost:8000/checkout_error'
        ]);

       
        return new JsonResponse($session->url);

    }
}
