<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AnswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Answer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title','Titre :'),
            TextareaField::new('text','Description :'),
            //TextField::new('logoFile')->setFormType(VichImageType::class),
            ImageField::new('logo','Logo :')->setBasePath('public\uploads\images\answer')->setUploadDir('public\uploads\images\answer')->setFormTypeOption('allow_delete', false),
            TextField::new('logoFile','Prévisualisation')->onlyOnForms()->setFormType(VichImageType::class)->setFormTypeOption('allow_delete', false)->setFormTypeOption('allow_file_upload', false)->setFormTypeOption('disabled','disabled')
        ];
    }
}
