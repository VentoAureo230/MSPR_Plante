<?php

namespace App\Controller\Admin;

use App\Entity\Hint;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HintCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hint::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextareaField::new('Text','Description'),
            ImageField::new('logo','Logo :')->setBasePath('public\uploads\images\hint')->setUploadDir('public\uploads\images\hint')->setFormTypeOption('allow_delete', false),
            TextField::new('logoFile','Prévisualisation')->onlyOnForms()->setFormType(VichImageType::class)->setFormTypeOption('allow_delete', false)->setFormTypeOption('allow_file_upload', false)->setFormTypeOption('disabled','disabled')
        ];
    }
    
}
