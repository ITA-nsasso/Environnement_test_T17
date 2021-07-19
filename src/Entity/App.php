<?php

namespace App\Entity;

use App\Repository\AppRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppRepository::class)
 */
class App
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $app_pk;

    /**
     * @ORM\Column(type="text")
     */
    private $app_GitLink;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $app_TestDate;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $app_PhpVer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppGitLink(): ?string
    {
        return $this->app_GitLink;
    }

    public function setAppGitLink(string $app_GitLink): self
    {
        $this->app_GitLink = $app_GitLink;

        return $this;
    }

    public function getAppTestDate(): ?\DateTimeInterface
    {
        return $this->app_TestDate;
    }

    public function setAppTestDate(?\DateTimeInterface $app_TestDate): self
    {
        $this->app_TestDate = $app_TestDate;

        return $this;
    }

    public function getAppPhpVer(): ?string
    {
        return $this->app_PhpVer;
    }

    public function setAppPhpVer(?string $app_PhpVer): self
    {
        $this->app_PhpVer = $app_PhpVer;

        return $this;
    }
}
