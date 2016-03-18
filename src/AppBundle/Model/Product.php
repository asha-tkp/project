<?php

namespace AppBundle\Model;

Class Product
{

    private $productID;

    private $name;

    private $description;

    private $price;

    private $categories;

    private $productURL;

    private $imageURL;

    /**
     * @return mixed
     */
    public function getProductID()
    {
        return $this->productID;
    }

    /**
     * @param mixed $productID
     */
    public function setProductID($productID)
    {
        $this->productID = $productID;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getProductURL()
    {
        return $this->productURL;
    }

    /**
     * @param mixed $productURL
     */
    public function setProductURL($productURL)
    {
        $this->productURL = $productURL;
    }

    /**
     * @return mixed
     */
    public function getImageURL()
    {
        return $this->imageURL;
    }

    /**
     * @param mixed $imageURL
     */
    public function setImageURL($imageURL)
    {
        $this->imageURL = $imageURL;
    }

    public function categoryNames()
    {
        $names = [];
        if (count($this->categories))
            foreach ($this->categories as $category) {
                $names[] = $category['@path'];
            }
        return implode(',', $names);

    }
}