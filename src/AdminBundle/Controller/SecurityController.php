<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\User\User;
use AdminBundle\Enum\UserRoleEnum;
use AdminBundle\Form\SecurityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class SecurityController
 *
 * @Route("/")
 *
 * @package AdminBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * @Route("login")
     * @Template
     *
     * @param AuthenticationUtils $authUtils A AuthenticationUtils instance.
     * @param Request             $request
     *
     * @return array|Response
     */
    public function loginAction(AuthenticationUtils $authUtils, Request $request)
    {
        $username = $authUtils->getLastUsername();

        $form = $this->createForm(SecurityType::class, [
            'email' => $username,
        ], [
            'action' => $this->generateUrl('admin_security_logincheck'),
        ]);

        $error = $authUtils->getLastAuthenticationError();
        if ($error !== null) {
            $error = $error->getMessage();

            $ref = str_replace("app_dev.php/", "", parse_url($request->headers->get('referer'),PHP_URL_PATH ));
            $lastRoute = $this->container->get('router')->match($ref)['_route'];

            if ($lastRoute === 'app_login_index') {
                return $this->redirectToRoute('app_login_index', ['error' => $error]);
            }
        }

        return [
            'form' => $form->createView(),
            'error' => $error,
        ];
    }

    /**
     * @Route("login-redirect")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function loginRedirectAction(Request $request)
    {
        $ref = str_replace("app_dev.php/", "", parse_url($request->headers->get('referer'),PHP_URL_PATH ));
        $lastRoute = $this->container->get('router')->match($ref)['_route'];
        if ($lastRoute === 'admin_security_login') {
            $userRole = $this->getUser()->getRole();
            if ($userRole === UserRoleEnum::ROLE_ADMIN_15) {
                return $this->redirectToRoute('admin_statistics_index');
            }
            return $this->redirectToRoute('admin_car_index');
        } else {
            return $this->redirectToRoute('app_homepage_index');
        }
    }

    /**
     * @Route("check")
     *
     * @return void
     */
    public function loginCheckAction(): void
    {
        throw new \LogicException('Should not be called, check your security configuration');
    }

    /**
     * @Route("logout")
     *
     * @return void
     */
    public function logoutAction(): void
    {
        throw new \LogicException('Should not be called, check your security configuration');
    }
}