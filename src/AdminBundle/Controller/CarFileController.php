<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\CarFile;
use AdminBundle\Entity\CarFileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CarFileController
 *
 * @Route("/car-file")
 *
 * @package AdminBundle\Controller
 */
class CarFileController extends Controller
{
    /**
     * @var string
     */
    private $carFilesPath;

    /**
     * CarFileController constructor.
     *
     * @param string $carFilesPath
     */
    public function __construct(string $carFilesPath)
    {
        $this->carFilesPath = $carFilesPath;
    }

    /**
     * @Route("/upload", methods={ "POST" })
     *
     * @param Request $request User id.
     *
     * @return JsonResponse
     */
    public function uploadAction(Request $request): JsonResponse
    {
        /** @var UploadedFile $uploadFile */
        $file  = $request->files->get('file');
        $type  = $request->request->get('type');
        $carId = $request->request->get('carId');

        $this->saveFile($carId, $type, $file);

        return JsonResponse::create([]);
    }

    /**
     * @Route("/delete", methods={ "GET" })
     *
     * @param Request $request User id.
     *
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        $fileId = $request->query->get('fileId', 0);
        $em     = $this->getDoctrine()->getManager();
        $file   = $em->getRepository(CarFile::class)->find($fileId);

        if ($file !== null) {
            $carId    = $file->getCar()->getId();
            $fileName = $file->getFileName();
            $filepath = $this->carFilesPath.'/'.$carId.'/'.$fileName;

            if (file_exists($filepath)) {
                unlink($filepath);
            }

            $em->remove($file);
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
        $carId      = $request->query->get('carId');
        $order      = $request->query->get('order');
        $columns    = $request->query->get('columns');
        $columnSort = $columns[$order[0]['column']]['name'];
        $sortType   = $order[0]['dir'];

        $user            = $this->getUser();
        $em              = $this->getDoctrine()->getManager();
        [$count, $files] = $em->getRepository(CarFile::class)
            ->getFiles($carId, $columnSort, $sortType, $user->getId());

        $data = [];
        foreach ($files as $file) {
            $data[] = [
                'fileId'    => $file->getId(),
                'type'      => $file->getType() !== null ? $file->getType()->getType() : '',
                'fileName'  => $file->getFileName() !== null ? $file->getFileName() : '',
                'admin'     => $file->getAdmin() !== null ? $file->getAdmin()->getFullName() : '',
                'createdAt' => $file->getCreatedAt() !== null ? $file->getCreatedAt()->format('d.m.Y H:i:s') : '',
                'carId'     => $file->getCar() !== null ? $file->getCar()->getId() : '',
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }

    /**
     * @param string       $carId
     * @param string       $type
     * @param UploadedFile $file
     *
     * @return void
     */
    private function saveFile(string $carId, string $type, UploadedFile $file): void
    {
        $em       = $this->getDoctrine()->getManager();
        $car      = $em->getRepository(Car::class)->find($carId);
        $fileType = $em->getRepository(CarFileType::class)->find($type);

        if ($car === null || $fileType === null) {
            return;
        }

        $fileName = $file->getClientOriginalName();

        $carFile = new CarFile();
        $carFile->setType($fileType);
        $carFile->setAdmin($this->getUser());
        $carFile->setCar($car);
        $carFile->setFileName($fileName);

        $saveFolder = $this->carFilesPath.'/'.$car->getId();
        if (!file_exists($saveFolder)) {
            mkdir($saveFolder);
        }

        $file->move($saveFolder, $fileName);

        $em->persist($carFile);
        $em->flush();
    }
}