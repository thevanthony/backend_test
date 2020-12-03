<?php
/*
    NOTES:
        - DO MUST RESPECT THE CLASS TOPICS
            - VARIABLES
            - METHODS
        - DO MUST RESPECT THE ALPHANUMERICAL ORDER IN TOPICS
        - DO MUST RESPECT INDENTATION
*/

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Fixture logic to apply on user instance
 */
class UserFixtures extends Fixture
{
    /*****************
     *** VARIABLES *** 
     *****************/

    private $passwordEncoder;


    /***************
     *** METHODS ***
     **************/

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /*
     * load user with encoded password
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'the_new_password'
        ));

        $manager->flush();
    }
}
