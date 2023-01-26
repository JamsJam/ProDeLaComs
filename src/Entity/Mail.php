<?php

namespace App\Entity;

use App\Repository\MailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailRepository::class)]
class Mail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sujet = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column(length: 255)]
    private ?string $expeditaire = null;

    #[ORM\ManyToOne(inversedBy: 'mails')]
    private ?Membre $destinataire = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sendAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getExpeditaire(): ?string
    {
        return $this->expeditaire;
    }

    public function setExpeditaire(string $expeditaire): self
    {
        $this->expeditaire = $expeditaire;

        return $this;
    }

    public function getDestinataire(): ?Membre
    {
        return $this->destinataire;
    }

    public function setDestinataire(?Membre $destinataire): self
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    public function getSendAt(): ?\DateTimeImmutable
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTimeImmutable $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }
}
