<?php

namespace AppBundle\Controller;

use AdminBundle\Form\SecurityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class LoginController
 *
 * @Route("/")
 *
 * @package AppBundle\Controller
 */
class LoginController extends Controller
{
    /**
     * @Route("login")
     * @Template
     *
     * @param AuthenticationUtils $authUtils A AuthenticationUtils instance.
     * @param Request             $request
     *
     * @return Response|array
     */
    public function indexAction(AuthenticationUtils $authUtils, Request $request)
    {
        $username = $authUtils->getLastUsername();

        $form = $this->createForm(SecurityType::class, [
            'email' => $username,
        ], [
            'action' => $this->generateUrl('admin_security_logincheck'),
        ]);

        $error = $request->query->get('error', null);
        if ($error !== null) {
            if ($error === 'Bad credentials.') {
                $error = 'E-Mail Adresse oder Passwort sind nicht korrekt.';
            }

            return [
                'form' => $form->createView(),
                'error' => $error,
            ];
        }

        $error = $authUtils->getLastAuthenticationError();
        if ($error !== null) {
            $error = $error->getMessage();
        }

        return [
            'form' => $form->createView(),
            'error' => $error,
        ];
    }

    /**
     * @Route("logout-redirect")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function logoutRedirectAction(Request $request)
    {
        $ref = str_replace("app_dev.php/", "", parse_url($request->headers->get('referer'),PHP_URL_PATH ));
        $lastRoute = $this->container->get('router')->match($ref)['_route'];
        if (mb_stristr($lastRoute, 'admin') !== false) {
            return $this->redirectToRoute('admin_security_login');
        } else {
            return $this->redirectToRoute('app_homepage_index');
        }
    }
}