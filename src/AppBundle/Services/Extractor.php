<?php
/**
 * Created by PhpStorm.
 * User: dg_mac
 * Date: 7/28/17
 * Time: 12:02 PM
 */

namespace AppBundle\Services;


use AppBundle\Model\Feed;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Extractor
{

    /** @var  PJStreamer */
    private $pjStreamer;

    /**
     * Extractor constructor.
     * @param PJStreamer $pjStreamer
     */
    public function __construct(PJStreamer $pjStreamer)
    {
        $this->pjStreamer = $pjStreamer;
    }

    public function extract(Feed $feed)
    {
        $xmlReader = new \XMLReader();
        $xmlReader->open($feed->getUrl());

        $doc = new \DOMDocument();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'application/json');
        $streamer = $this->pjStreamer;
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


}