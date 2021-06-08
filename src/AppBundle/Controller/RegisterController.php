<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\User\AbstractUser;
use AdminBundle\Entity\User\Admin;
use AdminBundle\Entity\User\User;
use AdminBundle\Enum\UserRoleEnum;
use AppBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class RegisterController
 *
 * @Route("/")
 *
 * @package AppBundle\Controller
 */
class RegisterController extends Controller
{
    /**
     * @Route("register")
     * @Template
     *
     * @param Request                  $request A http Request instance.
     * @param EncoderFactoryInterface  $encoder Encoder Factory Interface.
     *
     * @return Response|array
     */
    public function indexAction(Request $request, EncoderFactoryInterface $encoder)
    {
        $user = new User();
        $form = $this
            ->createForm(RegistrationType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $email = $user->getEmail();
            if ($this->checkEmail($email)) {
                return ['form' => $form->addError(new FormError('Benutzer mit dieser E-Mail existiert bereits'))->createView()];
            }
            $firmNumber = $user->getUstIdNr();
            if ($this->checkFirmNumber($firmNumber)) {
                return ['form' => $form->addError(new FormError('Die angegebene ID Nummer ist nicht korrekt'))->createView()];
            }

            $encoder = $encoder->getEncoder(AbstractUser::class);
            $user->setPassword($encoder->encodePassword($user->getPassword(), ''));
            $user->setRole(UserRoleEnum::ROLE_USER);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login_index');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    private function checkEmail(string $email): bool
    {
        $em = $this->getDoctrine()->getManager();
        $checkUser = $em->getRepository(User::class)->checkEmail($email);
        $checkAdmin = $em->getRepository(Admin::class)->checkEmail($email);

        if ($checkUser !== null || $checkAdmin !== null) {

            return true;
        }

        return false;
    }

    /**
     * @param string $firmNumber
     *
     * @return bool
     */
    private function checkFirmNumber(string $firmNumber): bool
    {
        $letters = substr($firmNumber, 0, 2);
        $numbers = substr($firmNumber, 2);

        if (mb_strtoupper($letters) !== 'DE') {

            return true;
        }
        if ($numbers === false) {

            return true;
        }
        if (!is_numeric($numbers) || mb_strlen($numbers) !== 9) {

            return true;
        }

        return false;
    }
}