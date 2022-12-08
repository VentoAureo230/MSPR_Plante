<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use Vich\UploaderBundle\Form\Type\VichImageType;
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
            //TextField::new('logoFile')->setFormType(VichImageType::class),
            ImageField::new('file_name')->setBasePath('public\uploads\images\plant')->setUploadDir('public\uploads\images\plant')->setFormTypeOption('allow_delete', false),
            TextField::new('file',':')->onlyWhenUpdating()->setFormType(VichImageType::class)->setFormTypeOption('allow_delete', false)->setFormTypeOption('allow_file_upload', false)->setFormTypeOption('disabled','disabled')
        ];
    }
    
}
