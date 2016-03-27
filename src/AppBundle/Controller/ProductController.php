<?php

namespace AppBundle\Controller;

use AppBundle\Form\FeedType;
use AppBundle\Model\Feed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductController extends Controller
{
    /**
     * @Route("/product", name="product",options={"expose" = true})
     */
    public function renderProductsAction(Request $request)
    {
        $feed = new Feed();
        $form = $this->createForm(FeedType::class, $feed);
        $products = [];
        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {

                $xmlReader = new \XMLReader();
                $xmlReader->open($feed->getUrl());

                $doc = new \DOMDocument();

                $encoders = [new XmlEncoder(), new JsonEncoder()];
                $normalizers = [new ObjectNormalizer()];
                $serializer = new Serializer($normalizers, $encoders);

                $response = new StreamedResponse();
                $response->headers->set('Content-Type', 'application/json');
                $streamer = $this->get('pj_streamer');
                ob_implicit_flush(true);
                ob_end_flush();

                $response->setCallback(function () use ($xmlReader, $serializer, $doc, $streamer) {
                    while ($xmlReader->read()) {
                        // move to the first <product /> node
                        while ($xmlReader->name === 'product') {
                            $node = simplexml_import_dom($doc->importNode($xmlReader->expand(), true));
                            $product = $serializer->deserialize($node->asXML(), 'AppBundle\Model\Product', 'xml');
                            $product = $serializer->serialize($product, 'json');
                            $streamer->sendStream($product);
                            // go to next <product />
                            $xmlReader->next('product');
                        }

                    }
                }
                );
                return $response;
            }
        } else {
            return $this->render('feed/index.html.twig', ['form' => $form->createView(), 'products' => $products]);
        }
    }
}
