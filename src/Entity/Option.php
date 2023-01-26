<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $affnommarque = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $mailnomparque = null;

    #[ORM\Column]
    private ?bool $mailtelephone = null;

    #[ORM\OneToOne(mappedBy: 'options', cascade: ['persist', 'remove'])]
    private ?Membre $membre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAffnommarque(): ?int
    {
        return $this->affnommarque;
    }

    public function setAffnommarque(int $affnommarque): self
    {
        $this->affnommarque = $affnommarque;

        return $this;
    }

    public function getMailnomparque(): ?int
    {
        return $this->mailnomparque;
    }

    public function setMailnomparque(int $mailnomparque): self
    {
        $this->mailnomparque = $mailnomparque;

        return $this;
    }

    public function isMailtelephone(): ?bool
    {
        return $this->mailtelephone;
    }

    public function setMailtelephone(bool $mailtelephone): self
    {
        $this->mailtelephone = $mailtelephone;

        return $this;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): self
    {
        // unset the owning side of the relation if necessary
        if ($membre === null && $this->membre !== null) {
            $this->membre->setOptions(null);
        }

        // set the owning side of the relation if necessary
        if ($membre !== null && $membre->getOptions() !== $this) {
            $membre->setOptions($this);
        }

        $this->membre = $membre;

        return $this;
    }
}
