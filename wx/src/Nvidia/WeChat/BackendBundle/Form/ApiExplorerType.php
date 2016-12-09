<?php

namespace Nvidia\WeChat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApiExplorerType extends AbstractType
{
    const WECHAT_APIS = [
        'getusersummary'           => 'getusersummary',
        'getusercumulate'          => 'getusercumulate',
        'getarticlesummary'        => 'getarticlesummary',
        'getarticletotal'          => 'getarticletotal',
        'getuserread'              => 'getuserread',
        'getuserreadhour'          => 'getuserreadhour',
        'getusershare'             => 'getusershare',
        'getusersharehour'         => 'getusersharehour',
        'getupstreammsg'           => 'getupstreammsg',
        'getupstreammsghour'       => 'getupstreammsghour',
        'getupstreammsgweek'       => 'getupstreammsgweek',
        'getupstreammsgmonth'      => 'getupstreammsgmonth',
        'getupstreammsgdist'       => 'getupstreammsgdist',
        'getupstreammsgdistweek'   => 'getupstreammsgdistweek',
        'getupstreammsgdistmonth?' => 'getupstreammsgdistmonth?',
        'getinterfacesummary'      => 'getinterfacesummary',
        'getinterfacesummaryhour'  => 'getinterfacesummaryhour',
    ];

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'api_explorer_e8863303',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('api', ChoiceType::class, [
                'label'   => 'API: https://api.weixin.qq.com/datacube/',
                'choices' => self::WECHAT_APIS,
            ])
            ->add('beginDate', DateType::class, [
                'years' => [
                    '2016',
                    '2015',
                ],
            ])
            ->add('endDate', DateType::class, [
                'years' => [
                    '2016',
                    '2015',
                ],
            ])
            ->add('run', SubmitType::class);
    }
}
