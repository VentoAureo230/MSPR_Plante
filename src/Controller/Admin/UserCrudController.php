<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;



use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }
    
    public static function getEntityFqcn(): string
    {
        return User::class;
    }    



    /*
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        ->add('is_admin')
        ;
    }*/

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters):QueryBuilder 
    {   /*
        parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $response = $this->get_browser(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->where('entity.is_admin = 1');

        return $response;*/

        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere("entity.roles LIKE '%ADMIN%' ");
        //$response->andWhere('entity.is_admin = 1');

        return $response;
    }

    
    

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('lastname','Nom'),
            TextField::new('firstname','Prénom'),
            TextField::new('email','Mail')->setFormType(EmailType::class),
            TextField::new('password','Mot de passe')->setFormType(PasswordType::class)->onlyOnForms()->onlyWhenCreating(),
            //BooleanField::new('is_admin','Administrateur')->onlyOnForms(),
            
        ];
    }
    
    
}
