<?php

namespace App\Controller\Admin;

use App\Entity\Hint;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
            TextField::new('Text'),
            //TextField::new('logoFile')->setFormType(VichImageType::class),
            ImageField::new('logo')->setBasePath('public\uploads\images\logo')->setUploadDir('public\uploads\images\logo'),
            TextField::new('logoFile',':')->onlyOnForms()->setFormType(VichImageType::class)->setFormTypeOption('allow_delete', false)->setFormTypeOption('allow_file_upload', false)
        ];
    }
    
}
