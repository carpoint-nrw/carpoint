<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\User\AbstractUser;
use AdminBundle\Entity\User\Admin;
use AdminBundle\Form\User\ProfileType;
use AdminBundle\Form\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class UserController
 *
 * @Route("/users")
 *
 * @package AdminBundle\Controller
 */
class UserController extends Controller
{
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
        $user = new Admin();
        $form = $this
            ->createForm(UserType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $encoder->getEncoder(AbstractUser::class);
            $user->setPassword($encoder->encodePassword($user->getPassword(), ''));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/edit/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request                  $request A http Request instance.
     * @param string                   $id      User id.
     * @param EncoderFactoryInterface  $encoder Encoder Factory Interface.
     *
     * @return Response|array
     */
    public function editAction(Request $request, string $id, EncoderFactoryInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(Admin::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        $password = $user->getPassword();

        $form = $this
            ->createForm(UserType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $user->getPassword() === null
                    ? $password
                    : $encoder
                        ->getEncoder(AbstractUser::class)
                        ->encodePassword($user->getPassword(), '')
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return [
            'form'  => $form->createView(),
        ];
    }

    /**
     * @Route("/edit-profile")
     * @Template
     *
     * @param Request                  $request A http Request instance.
     * @param EncoderFactoryInterface  $encoder Encoder Factory Interface.
     *
     * @return Response|array
     */
    public function editProfileAction(Request $request, EncoderFactoryInterface $encoder)
    {
        $currentUser = $this->getUser();
        $password = $currentUser->getPassword();

        $form = $this
            ->createForm(ProfileType::class, $currentUser)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser->setPassword(
                $currentUser->getPassword() === null
                    ? $password
                    : $encoder
                    ->getEncoder(AbstractUser::class)
                    ->encodePassword($currentUser->getPassword(), '')
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($currentUser);
            $em->flush();

            return $this->redirect($request->headers->get('referer'));
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
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Admin::class)->find($userId);

        if ($user !== null) {
            $em->remove($user);
            $em->flush();
        }

        return $this->ajaxDataForUser($request);
    }

    /**
     * @Route("/ajax-data")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function ajaxDataForUser(
        Request $request
    ): JsonResponse {
        $start = $request->query->get('start');
        $length = $request->query->get('length');
        $order = $request->query->get('order');
        $columns = $request->query->get('columns');
        $search = $request->query->get('search')['value'];
        $columnSort = $columns[$order[0]['column']]['name'] === 'edit'
            ? 'firstName'
            : $columns[$order[0]['column']]['name'];
        $sortType = $order[0]['dir'];

        $em = $this->getDoctrine()->getManager();

        [$count, $users] = $em->getRepository(Admin::class)
            ->getAdmins($start, $length, $columnSort, $sortType, $search);

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'userId'      => $user->getId(),
                'firstName'   => $user->getFirstName(),
                'lastName'    => $user->getLastName(),
                'email'       => $user->getEmail(),
                'role'        => $user->getRole(),
                'phoneNumber' => $user->getPhoneNumber(),
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}