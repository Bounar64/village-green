<?php 

namespace App\Data;

class SearchData 
{
    /**
     * @var integer
     */
    public $page = 1;

    /**
     * @var string
     */
    public $url_label;

    /**
     * @var null|string
     */
    private $kw;

    /**
     * @var null|integer
     */
    private $max;

    /**
     * @var null|integer
     */
    private $min;

    /**
    * @var boolean
    */
    private $discount = false;


    public function getKw(): ?string
    {
        return $this->kw;
    }

    public function setKw(string $kw): self
    {
        $this->kw = $kw;

        return $this;
    }

    /**
     * Get the value of max
     *
     * @return  null|integer
     */ 
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set the value of max
     *
     * @param  null|integer  $max
     *
     * @return  self
     */ 
    public function setMax($max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get the value of min
     *
     * @return  null|integer
     */ 
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set the value of min
     *
     * @param  null|integer  $min
     *
     * @return  self
     */ 
    public function setMin($min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Get the value of discount
     *
     * @return  boolean
     */ 
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     *
     * @param  boolean  $discount
     *
     * @return  self
     */ 
    public function setDiscount($discount): self
    {
        $this->discount = $discount;

        return $this;
    }


    /**
     * Get the value of count
     *
     * @return  integer
     */ 
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set the value of count
     *
     * @param  integer  $count
     *
     * @return  self
     */ 
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }
}