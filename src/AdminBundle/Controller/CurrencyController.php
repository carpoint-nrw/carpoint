<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Currency;
use AdminBundle\Form\CurrencyType;
use AdminBundle\Traits\ParseCurrency;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CurrencyController
 *
 * @Route("/currency")
 *
 * @package AdminBundle\Controller
 */
class CurrencyController extends Controller
{
    use ParseCurrency;

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
     * @Route("/edit/{id}", requirements={"id"="\d+"}, defaults={ "id": "0" })
     * @Template
     *
     * @param Request $request A http Request instance.
     * @param string  $id      Currency id.
     *
     * @return Response|array
     */
    public function editAction(Request $request, string $id)
    {
        $em = $this->getDoctrine()->getManager();

        $currency = $em->getRepository(Currency::class)->find($id);
        if (!$currency) {
            throw $this->createNotFoundException('Currency not found');
        }

        $form = $this
            ->createForm(CurrencyType::class, $currency)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($currency);
            $em->flush();

            return $this->redirectToRoute('admin_currency_index');
        }

        return ['form'  => $form->createView()];
    }

    /**
     * @Route("/ajax-data")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function ajaxCurrency(
        Request $request
    ): JsonResponse {
        $start = $request->query->get('start');
        $length = $request->query->get('length');

        $em = $this->getDoctrine()->getManager();

        [$count, $currencies] = $em->getRepository(Currency::class)
            ->getCurrencies($start, $length);

        $data = [];
        foreach ($currencies as $currency) {
            $data[] = [
                'currencyId'   => $currency->getId(),
                'realCurrency' => $currency->getRealCurrency(),
                'ourCurrency'  => $currency->getOurCurrency(),
                'date'         => $currency->getDate() !== null ? $currency->getDate()->format('Y-m-d H:i:s') : '',
            ];
        }

        return JsonResponse::create([
            'data'            => $data,
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
        ]);
    }

    /**
     * @Route("/parse-currency")
     *
     * @return Response
     */
    public function parseCurrency(): Response {
        $em = $this->getDoctrine()->getManager();
        $this->getCurrencyRate($em);

        return $this->redirectToRoute('admin_currency_index');
    }
}