<?php

/*
 * Handler the webservice endpoint related to entity User
 */

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     * 
     * create user token in database and return it
     */
    public function login(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        
        # Create the user token and save it in database
        $user->generateToken();
        $em->flush();

        return $this->json([
            'token' => $user->getToken()
        ]);
    }

    /**
     * @Route("/logout", name="api_logout", methods={"POST"})
     * // limited access to connected user
     * @IsGranted("ROLE_USER")
     * 
     * delete user token in database and return if is ok
     */
    public function logout(Request $request, EntityManagerInterface $em)
    {
        $json_returned = $this->json(
            [
                'success' => true
            ],
            200
        );

        $user = $this->getUser();

        if (null === $user) {
            $json_returned = $this->json(
                [
                    'success' => false
                ],
                404
            );
        }
        else {
            # Erase the user token and save it in database
            $user->eraseToken();
            $em->flush();
        }

        return $json_returned;
    }

    /**
     * @Route("/profile", name="api_profile", methods={"GET"})
     * // limited access to connected user
     * @IsGranted("ROLE_USER")
     * 
     * return user first name and last name
     */
    public function profile()
    {
        $user = $this->getUser();

        return $this->json(
            [
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
            ], 
            200
            );
    }
}
