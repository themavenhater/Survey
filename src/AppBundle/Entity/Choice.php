<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Choice
 * @ORM\Table(name="choice")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChoiceRepository")
 */
class Choice
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
     * @ORM\Column(name="choice", type="string", length=255)
     */
    private $choice;

    /**
     * @var \AppBundle\Entity\Survey $survey
     * @ORM\ManyToOne(targetEntity="Survey",inversedBy="choices")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id",onDelete="SET NULL")
     */
    private $Survey;

    /**
     * @var Answer $Answers
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Answer", mappedBy="answerId")
     * @ORM\JoinColumn(nullable=true,referencedColumnName="id",onDelete="SET NULL")
     */
    private $Answers;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set choice
     *
     * @param string $choice
     *
     * @return Choice
     */
    public function setChoice($choice)
    {
        $this->choice = $choice;

        return $this;
    }

    /**
     * Get choice
     *
     * @return string
     */
    public function getChoice()
    {
        return $this->choice;
    }

    /**
     * Set survey
     *
     * @param \AppBundle\Entity\Survey $survey
     *
     * @return Choice
     */
    public function setSurvey(Survey $survey)
    {
        $this->Survey = $survey;
        return $this;
    }

    /**
     * Get survey
     *
     * @return Survey
     */
    public function getSurvey()
    {
        return $this->Survey;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Answers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return Choice
     */
    public function addAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->Answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \AppBundle\Entity\Answer $answer
     */
    public function removeAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->Answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->Answers;
    }

    function __toString()
    {
        return $this->choice;
    }

}
