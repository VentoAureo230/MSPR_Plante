<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PictureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Text'),
            //TextField::new('logoFile')->setFormType(VichImageType::class),
            ImageField::new('logo')->setBasePath('public\uploads\images\logo')->setUploadDir('public\uploads\images\logo'),
            TextField::new('logoFile',':')->onlyOnForms()->setFormType(VichImageType::class)
        ];
    }
    
}
