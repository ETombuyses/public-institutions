<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Service\GeoApi;
use App\Service\EtablissementPublicApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeoApiController extends AbstractController
{
    /**
     * @Route("/geo/api", name="geo_api")
     * @param Request $request
     * @param GeoApi $geoApi
     * @param EtablissementPublicApi $etablissementPublicApi
     * @return Response
     */
    public function index(Request $request, GeoApi $geoApi, EtablissementPublicApi $etablissementPublicApi)
    {
        $institutions = [];
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);
        $empty_form = true;
        $sent = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $sent = true;


            if ($data['commune'] || $data['postal_code']) {

                $empty_form = false;
                $communes = $geoApi->getCommunes($data);

                if ($communes) $institutions = $etablissementPublicApi->getInstitution($communes, $data['institution']);

                // TODO : handle error if no commune or no institution found + display data

            }
        } else if($form->isSubmitted()) {
            $sent = true;
        }


        return $this->render('form.html.twig', [
            'search_form' => $form->createView(),
            'institutions' => $institutions,
            'emptyForm' => $empty_form,
            'formSent' => $sent
        ]);
    }
}
