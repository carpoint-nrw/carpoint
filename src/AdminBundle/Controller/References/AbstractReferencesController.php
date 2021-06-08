<?php

namespace AdminBundle\Controller\References;

use AdminBundle\Entity\References\Model;
use AdminBundle\Entity\References\StandartComplectation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AbstractReferencesController
 *
 * @package AdminBundle\Controller\References
 */
abstract class AbstractReferencesController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var string
     */
    protected $entityForm;

    /**
     * @var string
     */
    protected $entityReadableName;

    /**
     * @var string
     */
    protected $indexRoute;

    /**
     * @var string
     */
    protected $newRoute;

    /**
     * @var string
     */
    protected $editRoute;

    /**
     * @var string
     */
    protected $ajaxRoute;

    /**
     * @var string
     */
    protected $deleteRoute;

    /**
     * AbstractReferences constructor.
     *
     * @param EntityManagerInterface $em EntityManagerInterface instance.
     */
    public function __construct(EntityManagerInterface $em) {
        $this->em                 = $em;
        $this->entityName         = basename(strtr(static::class, ['\\' => '/', 'Controller' => '']));
        $this->entity             = 'AdminBundle\Entity\References\\'.$this->entityName;
        $this->entityForm         = 'AdminBundle\Form\References\\'.$this->entityName.'Type';
        $this->entityReadableName = mb_strtolower(implode(
            ' ',
            preg_split('~(?=[A-Z])~', $this->entityName, -1, PREG_SPLIT_NO_EMPTY)
        ));
        $this->indexRoute         = 'admin_references_'.mb_strtolower($this->entityName).'_index';
        $this->newRoute           = 'admin_references_'.mb_strtolower($this->entityName).'_new';
        $this->editRoute          = 'admin_references_'.mb_strtolower($this->entityName).'_edit';
        $this->ajaxRoute          = 'admin_references_'.mb_strtolower($this->entityName).'_ajaxdata';
        $this->deleteRoute        = 'admin_references_'.mb_strtolower($this->entityName).'_delete';
    }

    /**
     * @Route("", methods={ "GET", "POST" })
     * @Template
     *
     * @return array|Response
     */
    public function indexAction()
    {
        return [
            'entity'      => $this->entityReadableName,
            'newRoute'    => $this->newRoute,
            'editRoute'   => $this->editRoute,
            'ajaxRoute'   => $this->ajaxRoute,
            'deleteRoute' => $this->deleteRoute,
        ];
    }

    /**
     * @Route("/new")
     * @Template
     *
     * @param Request $request A http Request instance.
     *
     * @return array|Response
     */
    public function newAction(Request $request)
    {
        return $this->newAndEditHandle($request, 'Create');
    }

    /**
     * @Route("/edit/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request $request A http Request instance.
     * @param integer $id      Entity id.
     *
     * @return array|Response
     */
    public function editAction(Request $request, int $id)
    {
        return $this->newAndEditHandle($request, 'Edit', $id);
    }

    /**
     * @param Request $request
     * @param string  $type
     * @param int     $id
     *
     * @return array|Response
     */
    protected function newAndEditHandle(Request $request, string $type, int $id = 0)
    {
        if ($id) {
            if (!$entity = $this->em->getRepository($this->entity)->find($id))
                throw $this->createNotFoundException();
        }else
            $entity = new $this->entity();

        $form = $this
            ->createForm($this->entityForm, $entity)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($entity);
            $this->em->flush();

            return $this->redirectToRoute($this->indexRoute);
        }

        return [
            'form'       => $form->createView(),
            'entity'     => $this->entityReadableName,
            'indexRoute' => $this->indexRoute,
            'type'       => $type,
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
        $entityId = $request->query->get('entityId', 0);
        $em       = $this->getDoctrine()->getManager();
        $entity   = $em->getRepository($this->entity)->find($entityId);

        if ($entity !== null) {
            $em->remove($entity);
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
            ? 'title'
            : $columns[$order[0]['column']]['name'];
        $sortType   = $order[0]['dir'];

        $em             = $this->getDoctrine()->getManager();
        [$count, $data] = $em->getRepository('AdminBundle\Entity\References\\' . $this->entityName)
            ->getData($start, $length, $columnSort, $sortType, $search);

        $result = [];
        foreach ($data as $elem) {
            $result[] = [
                'entityId' => $elem->getId(),
                'title'    => $elem->getTitle(),
            ];
        }

        return JsonResponse::create([
            'data'            => $result,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }
}