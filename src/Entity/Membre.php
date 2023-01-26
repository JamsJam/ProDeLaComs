<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $marque = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[ORM\Column(nullable: true)]
    private array $site = [];

    #[ORM\Column(length: 255)]
    private ?string $poste = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private array $competence = [];

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'destinataire', targetEntity: Mail::class)]
    private Collection $mails;

    #[ORM\OneToMany(mappedBy: 'provider', targetEntity: RegisterLogs::class, orphanRemoval: true)]
    private Collection $registerLogs;

    #[ORM\OneToMany(mappedBy: 'new', targetEntity: RegisterLogs::class)]
    private Collection $addLog;

    public function __construct()
    {
        $this->mails = new ArrayCollection();
        $this->registerLogs = new ArrayCollection();
        $this->addLog = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSite(): array
    {
        return $this->site;
    }

    public function setSite(?array $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }



    public function getCompetence(): array
    {
        return $this->competence;
    }

    public function setCompetence(array $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Mail>
     */
    public function getMails(): Collection
    {
        return $this->mails;
    }

    public function addMail(Mail $mail): self
    {
        if (!$this->mails->contains($mail)) {
            $this->mails->add($mail);
            $mail->setDestinataire($this);
        }

        return $this;
    }

    public function removeMail(Mail $mail): self
    {
        if ($this->mails->removeElement($mail)) {
            // set the owning side to null (unless already changed)
            if ($mail->getDestinataire() === $this) {
                $mail->setDestinataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RegisterLogs>
     */
    public function getRegisterLogs(): Collection
    {
        return $this->registerLogs;
    }

    public function addRegisterLog(RegisterLogs $registerLog): self
    {
        if (!$this->registerLogs->contains($registerLog)) {
            $this->registerLogs->add($registerLog);
            $registerLog->setProvider($this);
        }

        return $this;
    }

    public function removeRegisterLog(RegisterLogs $registerLog): self
    {
        if ($this->registerLogs->removeElement($registerLog)) {
            // set the owning side to null (unless already changed)
            if ($registerLog->getProvider() === $this) {
                $registerLog->setProvider(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RegisterLogs>
     */
    public function getAddLog(): Collection
    {
        return $this->addLog;
    }

    public function addAddLog(RegisterLogs $addLog): self
    {
        if (!$this->addLog->contains($addLog)) {
            $this->addLog->add($addLog);
            $addLog->setNew($this);
        }

        return $this;
    }

    public function removeAddLog(RegisterLogs $addLog): self
    {
        if ($this->addLog->removeElement($addLog)) {
            // set the owning side to null (unless already changed)
            if ($addLog->getNew() === $this) {
                $addLog->setNew(null);
            }
        }

        return $this;
    }
}
