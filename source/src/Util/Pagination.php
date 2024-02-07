<?php declare(strict_types=1);

namespace App\Util;

use Doctrine\ORM\Tools\Pagination\Paginator;

class Pagination
{
    public function __construct(
        private Paginator $paginator,
        private int $page,
        private int $itemsPerPage,
        private int $maximumPagesVisible = 6
    ) {
    }

    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }

    public function getCurrentPage(): int
    {
        return $this->page;
    }

    public function getTotalItems(): int
    {
        return count($this->paginator);
    }

    public function getTotalPages(): int
    {
        return (int) ceil($this->getTotalItems() / $this->getItemsPerPage());
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getCurrentPages(): array
    {
        $currentPages = [];
        $firstPage = 1;

        if ($this->getCurrentPage() > 6) {
            $firstPage = $this->getCurrentPage() - floor($this->maximumPagesVisible / 2);
        }

        $lastPage = $firstPage + $this->maximumPagesVisible;
        if ($lastPage > $this->getTotalPages()) {
            $lastPage = $this->getTotalPages();
            $firstPage = $this->getTotalPages() - $this->maximumPagesVisible;
        }

        for ($i = $firstPage; $i <= $lastPage; $i++) {
            $currentPages[] = $i;
        }

        return $currentPages;
    }
}
