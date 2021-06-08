<?php


namespace AdminBundle\Entity\User;

use AdminBundle\Enum\UserRoleEnum;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractUser
 *
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "admin"="Admin",
 *     "user"="User"
 * })
 * @ORM\Table(name="user")
 *
 * @package AdminBundle\Entity\User
 */
abstract class AbstractUser implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column
     */
    protected $password;

    /**
     * @var UserRoleEnum
     *
     * @ORM\Column
     */
    protected $role;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $locale;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $phoneNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * AbstractUser constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail():? string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return static
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword():? string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return static
     */
    public function setPassword(string $password = null)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRole():? string
    {
        return $this->role;
    }

    /**
     * @param string $role
     *
     * @return static
     */
    public function setRole(string $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName():? string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return static
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName():? string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return static
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getFullNameOrNull():? string
    {
        if ($this->getFirstName() === null && $this->getLastName() === null) {
            return null;
        }

        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getLocale():? string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return static
     */
    public function setLocale(string $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber():? string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return static
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return '';
    }

    /**
     * do nothing
     */
    public function eraseCredentials(): void
    {
        // do nothing;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt():? \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     *
     * @return static
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}