<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @ORM\Column(name="ipAdress", type="string", length=16)
     */
    private $ipAdress;

    /**
     * @var string
     *
     * @ORM\Column(name="session", type="text")
     */
    private $session;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="answerDate", type="date")
     */
    private $answerDate;


    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Choice", inversedBy="Answers")
     * @ORM\JoinColumn(nullable=true,onDelete="CASCADE")
     */
    private $answerId;

    /**
     * @var int
     * @ORM\Column(name="last_survey", type="integer")
     */
    private $lastSurvey;


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
     * Set ipAdress
     *
     * @param string $ipAdress
     *
     * @return Answer
     */


    public function setIpAdress($ipAdress)
    {
        $this->ipAdress = $ipAdress;

        return $this;
    }

    /**
     * Get ipAdress
     *
     * @return string
     */
    public function getIpAdress()
    {
        return $this->ipAdress;
    }

    /**
     * Set session
     *
     * @param string $session
     *
     * @return Answer
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set answerDate
     *
     * @param \DateTime $answerDate
     *
     * @return Answer
     */
    public function setAnswerDate($answerDate)
    {
        $this->answerDate = $answerDate;

        return $this;
    }

    /**
     * Get answerDate
     *
     * @return \DateTime
     */
    public function getAnswerDate()
    {
        return $this->answerDate;
    }

    public function getAnswerId()
    {
        return $this->answerId;
    }

    public function setAnswerId($answerId)
    {
        $this->answerId = $answerId;
    }

    /**
     * Set lastSurvey
     *
     * @param integer $lastSurvey
     *
     * @return Answer
     */
    public function setLastSurvey($lastSurvey)
    {
        $this->lastSurvey = $lastSurvey;

        return $this;
    }

    /**
     * Get lastSurvey
     *
     * @return integer
     */
    public function getLastSurvey()
    {
        return $this->lastSurvey;
    }


}
