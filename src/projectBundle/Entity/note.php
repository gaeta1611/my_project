<?php

namespace projectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * note
 *
 * @ORM\Table(name="note")
 * @ORM\Entity(repositoryClass="projectBundle\Repository\noteRepository")
 */
class note
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=3000)
     */
    private $content;

    /**
     *
     * @ORM\ManyToOne(targetEntity="categorie", inversedBy="note")
     * @ORM\JoinColumn,(name="categorie_id", referencedColumn="id")
     */
    private $categorie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct() {
        $this->date = new \DateTime();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return note
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    //nouvelle ajout
    /**
     * @Assert\IsTrue(message="The content is not valid!")
     */
    public function isValidContent() {
        // http://stackoverflow.com/a/31387538
        $xml = new \DOMDocument();
        $implementation = new \DOMImplementation();
        $xml->appendChild($implementation->createDocumentType('content'));
        $content_elem = $xml->createElement('content');
        $content_xml = $xml->createDocumentFragment();


        try {
            $content_xml->appendXML($this->content);
            $content_elem->appendChild($content_xml);
            $xml->appendChild($content_elem);
            return $xml->schemaValidate('Schema_xml.xsd');
        } catch (\ErrorException $e) {
            return false;
        }
        return true;
    }


    /**
     * Set content
     *
     * @param string $content
     *
     * @return note
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return note
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set categorie
     *
     * @param \projectBundle\Entity\categorie $categorie
     *
     * @return note
     */
    public function setCategorie(\projectBundle\Entity\categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \projectBundle\Entity\categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
