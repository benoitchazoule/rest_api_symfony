<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="places",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="places_name_unique",columns={"name"})}
 *  )
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $address;
    
    /**
     * @ORM\OneToMany(targetEntity="Price", mappedBy="place")
     * @var Price[]
     */
    protected $prices;
    
    /**
     * @ORM\OneToMany(targetEntity="Theme", mappedBy="place")
     * @var Theme[]
     */
    protected $themes;

    
    // Constructeur
    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }
    
    
    // getters et setters
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }
    
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
    
    public function getPrices()
    {
        return $this->prices;
    }
    
    public function getThemes()
    {
        return $this->themes;
    }

    public function setThemes($themes)
    {
        $this->themes = $themes;
    }
}