<?php

namespace AppBundle\Controller;

use AppBundle\Form\FeedType;
use AppBundle\Model\Feed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/product", name="product",options={"expose" = true})
     */
    public function renderProductsAction(Request $request)
    {
        ini_set("memory_limit","32M");
        $feed = new Feed();
        $form = $this->createForm(FeedType::class, $feed);
        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {
                return $this->get('extractor')->extract($feed);
            }
        }
        return $this->render('feed/index.html.twig', ['form' => $form->createView()]);
    }
}
