<?php

namespace AdminBundle\Controller\Ajax;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\CarFileType;
use AdminBundle\Entity\References\Color;
use AdminBundle\Entity\References\Model;
use AdminBundle\Entity\References\Place;
use AdminBundle\Entity\References\StandartComplectation;
use AdminBundle\Entity\References\Vendor;
use AdminBundle\Entity\References\Version;
use AdminBundle\Entity\User\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AjaxController
 *
 * @Route("/ajax")
 *
 * @package AdminBundle\Controller\Ajax
 */
class AjaxController extends Controller
{
    private const CLEAR_CAR_SETTERS = [
        'setDischarge', 'setSeller', 'setPlaceOfIssue', 'setSellingPrice', 'setTaxType', 'setDeposit', 'setRestsumme',
        'setPaymentType', 'setPaymentCondition', 'setFirstName', 'setLastName', 'setStreet', 'setCity', 'setPlaceIndex',
        'setFirmNumber', 'setEmail', 'setPhoneNumber', 'setMobileNumber', 'setFax', 'setClientStatus', 'setBodyType',
        'setCarStatus', 'setFuel', 'setPtsNumber', 'setDate', 'setOrt', 'setDatum', 'setAdditionalWork', 'setNotes'
    ];


    /**
     * @Route("/get-model")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getModel(Request $request): JsonResponse
    {
        $brand = $request->query->get('brand');
        $em = $this->getDoctrine()->getManager();
        $models = $em->getRepository(Model::class)->findBy(
            ['brand' => $brand],
            ['title' => 'asc']
        );

        $data = [];
        foreach ($models as $model) {
            $oneModel = [
                'id' => $model->getId(),
                'title' => $model->getTitle(),
            ];
            $data[] = $oneModel;
        }


        return JsonResponse::create($data);
    }

    /**
     * @Route("/get-version")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getVersion(Request $request): JsonResponse
    {
        $model = $request->query->get('model');
        $version = $request->query->get('version', '');
        $em = $this->getDoctrine()->getManager();

        $versions = $em->getRepository(Version::class)->getVersions($model, $version);

        $data = [];
        foreach ($versions as $version) {
            $oneModel = [
                'id' => $version->getId(),
                'polish' => $version->getPolish(),
                'german' => $version->getGerman(),
            ];
            $data[] = $oneModel;
        }


        return JsonResponse::create($data);
    }
        
    /**
     * @Route("/get-color-description")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getColorDescription(Request $request): JsonResponse
    {
        $baseColor = $request->query->get('baseColor');
        $em = $this->getDoctrine()->getManager();

        $colors = $em->getRepository(Color::class)->getByBaseColor($baseColor);

        $data = [];
        foreach ($colors as $color) {
            $oneModel = [
                'id' => $color->getId(),
                'polish' => $color->getPolish(),
                'german' => $color->getGerman(),
                'title' => $color->getTitle(),
            ];
            $data[] = $oneModel;
        }


        return JsonResponse::create($data);
    }

    /**
     * @Route("/get-standart-complectation")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getStandartComplectation(
        Request $request
    ): JsonResponse {
        $version = $request->query->get('version');
        $em = $this->getDoctrine()->getManager();
        $complectation = $em->getRepository(StandartComplectation::class)->findOneBy([
            'version' => $version,
        ]);

        $data = $complectation !== null
            ? [
                'polish' => [
                    'id' => $complectation->getId(),
                    'title' => $complectation->getPolish(),
                ],
                'german' => [
                    'id' => $complectation->getId(),
                    'title' => $complectation->getGerman(),
                ],
            ]
            : '';

        return JsonResponse::create($data);
    }

    /**
     * @Route("/get-place-by-vendor")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getPlaceByVendor(Request $request): JsonResponse
    {
        $vendorId = $request->query->get('vendor');
        $em = $this->getDoctrine()->getManager();
        $vendor = $em->getRepository(Vendor::class)->find($vendorId);

        $data = '';
        if ($vendor !== null) {
            $data = $vendor->getPlace()->getId();
        }

        return JsonResponse::create($data);
    }

    /**
     * @Route("/change-sidebar")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function changeSidebar(Request $request): JsonResponse
    {
        $userId = $request->query->get('userId');
        $type = $request->query->get('type');
        $type = $type === 'true' ? true : false;
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(Admin::class)->find($userId);
        if ($user === null) {
            return JsonResponse::create([], 400);
        }
        $user->setSidebar($type);
        $em->persist($user);
        $em->flush();

        return JsonResponse::create([]);
    }

    /**
     * @Route("/check-vin-number")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function checkVinNumber(Request $request): JsonResponse
    {
        $vinNumber = $request->query->get('vinNumber');
        if ($vinNumber === '') {
            return JsonResponse::create([]);
        }
        $carId = $request->query->get('carId');
        $em = $this->getDoctrine()->getManager();

        $car = $em->getRepository(Car::class)->checkVinNumber((string) $carId, $vinNumber);
        if (!empty($car)) {
            return JsonResponse::create([], 400);
        }

        return JsonResponse::create([]);
    }

    /**
     * @Route("/get-file-types")
     *
     * @return JsonResponse
     */
    public function getFileTypes(): JsonResponse
    {
        $em     = $this->getDoctrine()->getManager();
        $types  = $em->getRepository(CarFileType::class)->findAll();
        $result = [];
        foreach ($types as $type) {
            $result[$type->getId()] = $type->getType();
        }

        return JsonResponse::create($result);
    }

    /**
     * @Route("/clear-car-data")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function clearCarData(Request $request): JsonResponse
    {
        $carId = $request->query->get('carId', 0);
        $em    = $this->getDoctrine()->getManager();
        $car   = $em->getRepository(Car::class)->find($carId);

        if ($car === null) {
            return JsonResponse::create([], 400);
        }

        foreach (self::CLEAR_CAR_SETTERS as $setter) {
            $car->$setter(null);
        }

        $em->persist($car);
        $em->flush();

        return JsonResponse::create([]);
    }

    /**
     * @Route("/car-user-data")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getCarUserData(Request $request): JsonResponse
    {
        $carId = $request->query->get('carId', 0);
        $em    = $this->getDoctrine()->getManager();
        $car   = $em->getRepository(Car::class)->find($carId);

        $result = [
            'firstName'    => $car->getFirstName() ?? '',
            'lastName'     => $car->getLastName() ?? '',
            'street'       => $car->getStreet() ?? '',
            'city'         => $car->getCity() ?? '',
            'placeIndex'   => $car->getPlaceIndex() ?? '',
            'firmNumber'   => $car->getFirmNumber() ?? '',
            'email'        => $car->getEmail() ?? '',
            'phoneNumber'  => $car->getPhoneNumber() ?? '',
            'mobileNumber' => $car->getMobileNumber() ?? '',
            'fax'          => $car->getFax() ?? '',
        ];

        return JsonResponse::create($result);
    }
}