<?php
// src/BaseBundle/Entity/User.php
namespace BaseBundle\Entity;

//use Doctrine\ORM\Mapping as ORM; // Seulement si annotation
use Symfony\Component\Security\Core\User\UserInterface;

//class User implements Symfony\Component\Security\Core\User\UserInterface
class User implements UserInterface, \Serializable //CustomUserInterface
{
    private $id;
    private $mail;
    private $isActive;
    
    private $username;
    private $roles;
    private $password;
    //private $salt;

    private $emailConfirmationToken; //T

    public function __construct()
    {
        //$this->isActive = true;
        // De base, on va attribuer au nouveau utilisateur, le rôle « ROLE_USER »
        //$this->roles = array("ROLE_USER");

        // Chaque utilisateur va se voir attribuer une clé permettant de saler son mot de passe.
        //Cela n'est pas obligatoire, on pourrait mettre $salt à null, dépends de l'encodeur
        //$this->salt = md5(uniqid(null, true));
    }

    /********************* Implémentation de UserInterface ****************************************/
    public function getUsername()
    {
        return $this->username;
    }

    public function getRoles()
    {
        return $this->roles; //Nope, need an array, $this->roles->toArray();
        //return array("ROLE_USER");
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        //return $this->salt;

        // The bcrypt algorithm doesn't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function eraseCredentials()
    {
        // util si mot de passe en clair...
    }
    /********************* Fin Implémentation de UserInterface *************************************/

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getMail()
    {
        return $this->mail;
    }
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    public function getEmailConfirmationToken()
    {
        return $this->emailConfirmationToken;
    }
    public function setEmailConfirmationToken($emailConfirmationToken)
    {
        $this->emailConfirmationToken = $emailConfirmationToken;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
}