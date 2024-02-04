<?php declare(strict_types=1);

namespace App\PageLoader;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;

class GenericPageLoader
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function mergeParameters(array $parameters): array
    {
        return array_merge($parameters, [
            'search' => $this->getSearch(),
            'categories' => $this->getCategoryTree()
        ]);
    }

    private function getSearch(): string
    {
        $request = Request::createFromGlobals();
        $search = (string)$request->query->get('search');
        return $search;
    }

    private function getCategoryTree(): array
    {
        $categories = $this->categoryRepository->findAll();
        $tree = [];
        foreach ($categories as $category) {
            if ($category->getParentId()) {
                continue;
            }

            $tree[] = $category;
        }

        return $tree;
    }
}
