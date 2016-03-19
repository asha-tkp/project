<?php

namespace AppBundle\Services;

use AppBundle\Model\Feed;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductExtractor
{

    public function extractProducts(Feed $feed)
    {
        $products =[];
        $xml = simplexml_load_file($feed->getUrl());

        $encoders = [new XmlEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        foreach ($xml->children() as $productXML) {
            $products[] = $serializer->deserialize($productXML->asXML(), 'AppBundle\Model\Product', 'xml');
        }

        return $products;
    }
}