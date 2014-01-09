<?php

namespace ChessyWeb\GuestBookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GuestMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', 'text', array('label' => 'Entrez ici votre nom :'))
            ->add('message', 'textarea', array('label' => 'Entrez ici votre message :'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChessyWeb\GuestBookBundle\Entity\GuestMessage'
        ));
    }

    public function getName()
    {
        return 'chessyweb_guestbookbundle_guestmessagetype';
    }
}
