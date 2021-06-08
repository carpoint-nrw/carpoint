<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\User\AbstractUser;
use AdminBundle\Entity\User\Admin;
use AdminBundle\Entity\User\User;
use AdminBundle\Enum\UserRoleEnum;
use AdminBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class BuyerUserController
 *
 *  @Route("/buyer-user")
 *
 * @package AdminBundle\Controller
 */
class BuyerUserController extends Controller
{
    private const COUNTRY_CODES = [
        'DE'  => 9,
        'ATU' => 8,
        'BE'  => 10,
        'PL'  => 10,
        'RO'  => 8,
        'IVA' => 11,
        'FR'  => 11,
        'CZ'  => 8,
    ];

    /**
     * @Route("")
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/new")
     * @Template
     *
     * @param Request                  $request A http Request instance.
     * @param EncoderFactoryInterface  $encoder Encoder Factory Interface.
     *
     * @return array|Response
     */
    public function newAction(Request $request, EncoderFactoryInterface $encoder)
    {
        $user = new User();
        $form = $this
            ->createForm(UserType::class, $user, [
                'attr' => ['type' => 'new']
            ])
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $email = $user->getEmail();
            if ($this->checkEmail($email)) {
                return ['form' => $form->addError(new FormError('User with this email already exist'))->createView()];
            }
            $firmNumber = $user->getUstIdNr();
            if ($this->checkFirmNumber($firmNumber)) {
                return ['form' => $form->addError(new FormError('This USt-IdNr incorrect'))->createView()];
            }

            $encoder = $encoder->getEncoder(AbstractUser::class);
            $user->setPassword($encoder->encodePassword($user->getPassword(), ''));
            $user->setRole(UserRoleEnum::ROLE_USER);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_buyeruser_index');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/edit/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request                 $request A http Request instance.
     * @param string                  $id      User id.
     * @param EncoderFactoryInterface $encoder Encoder Factory Interface.
     *
     * @return Response|array
     */
    public function editAction(Request $request, string $id, EncoderFactoryInterface $encoder)
    {
        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $password = $user->getPassword();
        $form     = $this
            ->createForm(UserType::class, $user, [
                'attr' => ['type' => 'edit']
            ])
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $email  = $user->getEmail();
            $userId = $user->getId();
            if ($this->checkEmail($email, $userId)) {
                return ['form' => $form->addError(new FormError('User with this email already exist'))->createView()];
            }
            $firmNumber = $user->getUstIdNr();
            if ($this->checkFirmNumber($firmNumber)) {
                return ['form' => $form->addError(new FormError('This USt-IdNr incorrect'))->createView()];
            }

            $user->setPassword(
                $user->getPassword() === null
                    ? $password
                    : $encoder
                    ->getEncoder(AbstractUser::class)
                    ->encodePassword($user->getPassword(), '')
            );

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('admin_buyeruser_index');
        }

        return [
            'form'  => $form->createView(),
        ];
    }

    /**
     * @Route("/delete", methods={ "GET" })
     * @Template
     *
     * @param Request $request User id.
     *
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        $userId = $request->query->get('userId', 0);
        $em     = $this->getDoctrine()->getManager();
        $user   = $em->getRepository(User::class)->find($userId);

        if ($user !== null) {
            $em->remove($user);
            $em->flush();
        }

        return $this->ajaxData($request);
    }

    /**
     * @Route("/ajax-data")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function ajaxData(
        Request $request
    ): JsonResponse {
        $start      = $request->query->get('start');
        $length     = $request->query->get('length');
        $order      = $request->query->get('order');
        $columns    = $request->query->get('columns');
        $search     = $request->query->get('search')['value'];
        $columnSort = $columns[$order[0]['column']]['name'] === 'edit'
            ? 'firstName'
            : $columns[$order[0]['column']]['name'];

        $sortType        = $order[0]['dir'];
        $em              = $this->getDoctrine()->getManager();
        [$count, $users] = $em->getRepository(User::class)
            ->getUsers($start, $length, $columnSort, $sortType, $search);
        $data            = [];

        foreach ($users as $user) {
            $data[] = [
                'userId'       => $user->getId(),
                'firstName'    => $user->getFirstName(),
                'lastName'     => $user->getLastName(),
                'firmNumber'   => $user->getFirmNumber(),
                'email'        => $user->getEmail(),
                'createdAt'    => $user->getCreatedAt() !== null ? $user->getCreatedAt()->format('d.m.Y') : null,
                'targetUnload' => $user->getTargetUnload() !== null ? $user->getTargetUnload()->getTitle() : '',
                'abbreviation' => $user->getAbbreviation(),
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }

    /**
     * @param string      $email
     * @param string|null $userId
     *
     * @return bool
     */
    private function checkEmail(string $email, $userId = null): bool
    {
        $em         = $this->getDoctrine()->getManager();
        $checkUser  = $em->getRepository(User::class)->checkEmail($email, $userId);
        $checkAdmin = $em->getRepository(Admin::class)->checkEmail($email, $userId);

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
        $countryCode  = preg_replace('/[^\\/\-a-z\s]/i', '', $firmNumber);
        $numbers      = str_replace($countryCode, '', $firmNumber);
        $numbersCount = mb_strlen($numbers);

        if (!isset(self::COUNTRY_CODES[$countryCode])) {
            return true;
        }

        $default = self::COUNTRY_CODES[$countryCode];
        if ($default !== $numbersCount) {
            return true;
        }

        return false;
    }
}