<?php

namespace AppBundle\Controller;

use AppBundle\Form\FeedType;
use AppBundle\Model\Feed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductController extends Controller
{
    /**
     * @Route("/product", name="product")
     */
    public function renderProductsAction(Request $request)
    {
        $feed = new Feed();
        $form = $this->createForm(new FeedType(), $feed);
        $products = [];
        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {
                $xml = simplexml_load_file($feed->getUrl());

                $encoders = [new XmlEncoder(), new JsonEncoder()];
                $normalizers = [new ObjectNormalizer()];
                $serializer = new Serializer($normalizers, $encoders);

                foreach ($xml->children() as $productXML) {
                    $products[] = $serializer->deserialize($productXML->asXML(), 'AppBundle\Model\Product', 'xml');
                }
            }
        }
        return $this->render('feed/index.html.twig', [
            'form' => $form->createView(),
            'products' => $products,
        ]);
    }

}
