<?php

namespace App\Controller\Admin;

use App\Entity\Plant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plant::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        ->add('name')
        ->add('Level')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name','Nom de la plante :');
        yield IntegerField::new('Level','Niveau :');
        yield BooleanField::new('is_enable_for_user','Afficher pour les utilisateurs :')->renderAsSwitch(true);
        yield CollectionField::new('hints','Indices :')->useEntryCrudForm()->renderExpanded()->setEntryIsComplex();
        yield CollectionField::new('answers','Réponses :')->useEntryCrudForm()->renderExpanded()->setEntryIsComplex();
        yield CollectionField::new('pictures','Photos :')->useEntryCrudForm()->renderExpanded()->setEntryIsComplex();
    }
    
}
