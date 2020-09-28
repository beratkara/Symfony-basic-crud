<?php


namespace App\Entity;


use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use JsonSerializable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table("`user`")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements JsonSerializable, UserInterface
{
    public function __construct($email)
    {
        $this->setEmail($email);
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     *
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=60)
     *
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=20)
     *
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $information;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_time;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_time;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return array|null
     */
    public function getInformation(): ?array
    {
        return $this->information;
    }

    /**
     * @param array $information
     * @return $this
     */
    public function setInformation(array $information): self
    {
        $this->information = $information;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreateTime(): ?DateTime
    {
        return $this->create_time;
    }

    /**
     * @param DateTime $create_time
     * @return $this
     */
    public function setCreateTime(DateTime $create_time): self
    {
        $this->create_time = $create_time;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdateTime(): ?DateTime
    {
        return $this->update_time;
    }

    /**
     * @param DateTime $update_time
     * @return $this
     */
    public function setUpdateTime(DateTime $update_time): self
    {
        $this->update_time = $update_time;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }


    /**
     * @throws Exception
     * @ORM\PrePersist()
     */
    public function beforeSave(): void
    {
        $this->create_time = new DateTime('now', new DateTimeZone('Europe/Istanbul'));
        $this->update_time = new DateTime('now', new DateTimeZone('Europe/Istanbul'));
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize(): ?array
    {
        return [
            "name" => $this->getName(),
            "surname" => $this->getSurname(),
            "phone" => $this->getPhone(),
            "email" => $this->getEmail(),
            "information" => $this->getInformation(),
            "create_time" => $this->getCreateTime(),
            "update_time" => $this->getUpdateTime()
        ];
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}