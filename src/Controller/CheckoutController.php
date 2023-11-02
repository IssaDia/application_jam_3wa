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
use Psr\Log\LoggerInterface;


class CheckoutController extends AbstractController
{
    
    #[IsGranted("ROLE_USER")]
    #[Route('/checkout_success/{token}', name: 'checkout_success')]
    public function checkout(EntityManagerInterface $manager, SessionInterface $session, OrderRepository $orderRepo, string $token, LoggerInterface $logger)
    {
        if ($this->isCsrfTokenValid('stripe_token', $token)) {
            $order = $orderRepo->find($session->get("order_waiting"));
            $order->setStatus("PAYMENT_OK");
            $manager->flush();
            return $this->render('checkout/success.html.twig', [
                "order" => $order
            ]);
        } else {
            return $this->render('checkout/error.html.twig', []);
        }
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/checkout_error', name: 'checkout_error')]
    public function error()
    {
        return $this->render('checkout/error.html.twig', []);

    }

    #[IsGranted("ROLE_USER")]
    #[Route('/api/checkout', name: 'api_checkout')]
    public function checkout_check(EntityManagerInterface $manager, ProductRepository $productRepo, SessionInterface $session, Request $request, LoggerInterface $logger)
    {
        // $tokenProvider = $this->container->get('security.csrf.token_manager');
        // $token = $tokenProvider->getToken('stripe_token')->getValue();
        $stripe_items = [];
        // $cart = $session->get("cart", []);
        $cart = $request->request->get('cart');
        $logger->info('Cart data: ' . print_r($cart, true));
        if (empty($cart)) {
            return $this->redirectToRoute("home");
        }
        $order = new Order;
        $order->setDatetime(new DateTime);
        $order->setStatus("PAYMENT_WAITING");
        $total = 0;

        foreach ($cart as $key => $quantity) {
            $product = $productRepo->find($key);
            $line = new LineOrder;
            $line->setProduct($product);
            $line->setQuantity($quantity);
            $line->setSubtotal($quantity * $product->getPrice());
            $total += $quantity * $product->getPrice();
            $order->addLineOrder($line);
            //equivalent
            // $line->setOrderAssociated($order);
            $stripe_items[] =
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->getName(),
                        ],
                        'unit_amount' => $product->getPrice(),
                    ],
                    'quantity' => $quantity,
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
            'cancel_url' => 'http://localhost:5173/checkout_error'
        ]);

        return "success";
    }
}
