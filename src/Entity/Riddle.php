<?php

namespace App\Entity;

use App\Repository\RiddleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RiddleRepository::class)
 */
class Riddle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $question;

    /**
     * @ORM\Column(type="text")
     */
    private $answer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $hint1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $hint2;

    /**
     * @ORM\Column(type="boolean")
     */
    private $solved = false;

    /**
    * @ORM\ManyToOne(targetEntity=User::class, inversedBy="riddles", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="riddle")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="riddle")
     */
    private $votes;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getHint1(): ?string
    {
        return $this->hint1;
    }

    public function setHint1(?string $hint1): self
    {
        $this->hint1 = $hint1;

        return $this;
    }

    public function getHint2(): ?string
    {
        return $this->hint2;
    }

    public function setHint2(?string $hint2): self
    {
        $this->hint2 = $hint2;

        return $this;
    }

    public function isSolved(): ?bool
    {
        return $this->solved;
    }


    /**
     * @param string $userAnswer
     * @return bool true if the answer is correct, false otherwise
     */
    public function checkAnswer(string $userAnswer): bool
    {
        $correctAnswer = strtolower($this->answer);
        $userInput = strtolower($userAnswer);

        if ($correctAnswer === $userInput) {
            $this->solved = true;
            return true;
        }

        return false;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRiddle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRiddle() === $this) {
                $comment->setRiddle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setRiddle($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getRiddle() === $this) {
                $vote->setRiddle(null);
            }
        }

        return $this;
    }
}
