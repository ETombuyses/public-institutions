<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $institutionType = ['accompagnement_personnes_agees', 'adil', 'afpa', 'anah', 'apec', 'apecita', 'ars', 'ars_antenne', 'banque_de_france', 'bav', 'bsn', 'caa', 'caf', 'carsat', 'ccas', 'cci', 'cdas', 'cddp', 'cdg', 'centre_detention', 'centre_impots_fonciers', 'centre_penitentiaire', 'centre_social', 'cesr', 'cg', 'chambre_agriculture', 'chambre_metier', 'cicas', 'cidf', 'cij', 'cio', 'civi', 'clic', 'cnfpt', 'cnra', 'commissariat_police', 'commission_conciliation', 'conciliateur_fiscal', 'conseil_culture', 'cour_appel', 'cpam', 'cr', 'crc', 'crdp', 'creps', 'crfpn', 'crib', 'crous', 'csl', 'dac', 'dd_femmes', 'dd_fip', 'ddcs', 'ddcspp', 'ddpjj', 'ddpp', 'ddsp', 'ddt', 'defenseur_droits', 'did_routes', 'dir_mer', 'dir_meteo', 'dir_pj', 'direccte', 'direccte_ut', 'dml', 'dr_femmes', 'dr_fip', 'dr_insee', 'drac', 'draf', 'drddi', 'dreal', 'dreal_ut', 'driea', 'driea_ut', 'driee', 'driee_ut', 'drihl', 'drihl_ut', 'drjscs', 'dronisep', 'drpjj', 'drrt', 'drsp', 'dz_paf', 'edas', 'epci', 'esm', 'fdapp', 'fdc', 'fongecif', 'gendarmerie', 'greta', 'hypotheque', 'inspection_academique', 'maia', 'mairie', 'mairie_com', 'mairie_mobile', 'maison_arret', 'maison_centrale', 'maison_handicapees', 'mds', 'mission_locale', 'mjd', 'msa', 'ofii', 'onac', 'onf', 'paris_mairie', 'paris_mairie_arrondissement', 'paris_ppp', 'paris_ppp_antenne', 'paris_ppp_certificat_immatriculation', 'paris_ppp_gesvres', 'paris_ppp_permis_conduire', 'permanence_juridique', 'pif', 'pmi', 'pole_emploi', 'pp_marseille', 'prefecture', 'prefecture_greffe_associations', 'prefecture_region', 'prudhommes', 'rectorat', 'sdac', 'sdsei', 'service_navigation', 'sgami', 'sie', 'sip', 'sous_pref', 'spip', 'suio', 'ta', 'te', 'tgi', 'ti', 'tresorerie', 'tribunal_commerce', 'urssaf'];
        $institutionChoice = [];

        foreach ($institutionType as $type) {
           $institutionChoice[$type] = $type;
        }

        $builder
            ->add('commune', SearchType::class, [
                'label' => 'Commune',
                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'Ce champ doit comporter au minimum 3 caractères',
                        'allowEmptyString' => true
                    ]),
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'Ce champ doit être un texte'
                    ])
                ],
                'required' => false
            ])
            ->add('postal_code', SearchType::class, [
                'label' => 'Code Postal',
                'constraints' => [
                    new Assert\Length([
                        'min' => 5,
                        'max' => 5,
                        'exactMessage' => 'Ce champ doit être un code postal de 5 chiffres',
                        'allowEmptyString' => true
                    ]),
                    new Assert\Type([
                        'type' => 'numeric',
                        'message' => 'Ce champ doit être un nombre'
                    ])
                ],
                'required' => false
            ])

            ->add('institution', ChoiceType::class, [
                'label' => "Type d'établissement",
                'choices' => $institutionChoice,
                'preferred_choices' => ['mairie']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
