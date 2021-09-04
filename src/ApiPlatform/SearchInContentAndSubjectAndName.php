<?php

namespace App\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

class SearchInContentAndSubjectAndName extends AbstractFilter {
  protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null) {
    if ($property !== 'searchText'){
      return;
    }

    $alias = $queryBuilder->getRootAliases()[0];
    $queryBuilder
      ->andWhere(sprintf('%s.name LIKE :searchText OR %s.subject LIKE :searchText OR %s.content LIKE :searchText', $alias, $alias, $alias))
      ->setParameter('searchText', '%'.$value.'%')
    ;
  }

  public function getDescription(string $resourceClass): array {
    return [
      'searchText' => [
        'property' => null,
        'type' => 'string',
        'required' => false,
        'openapi' => [
          'description' => 'search across name, subject or content',
        ]
      ]
    ];
  }

}