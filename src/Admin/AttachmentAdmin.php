<?php

namespace App\Admin;

use App\Entity\Attachment;
use App\Entity\BlogPost;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

final class AttachmentAdmin extends AbstractAdmin
{

    // protected function configure(): void
    // {
    //     dump($this->getCode());
    // }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('filename', TextType::class, [
                'label' => 'Filename',
                'required' => true,
            ])
            ->add('blogPost', ModelAutocompleteType::class, [
                'property' => 'title', // The field from BlogPost entity to display
                'class' => BlogPost::class,
                'required' => false,
                'btn_add' => false,
                'minimum_input_length' => 2, // Start searching after 2 chars
                'to_string_callback' => function($entity, $property) {
                    return $entity->getTitle();
                },
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('filename', null, [
                'label' => 'Filename',
            ])
            ->add('_actions', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }
}