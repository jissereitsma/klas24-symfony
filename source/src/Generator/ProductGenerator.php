<?php declare(strict_types=1);

namespace App\Generator;

use App\Entity\Category;
use App\Entity\Product;
use App\Kernel;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use joshtronic\LoremIpsum;
use StanDaniels\ImageGenerator\Canvas;
use StanDaniels\ImageGenerator\Color;
use StanDaniels\ImageGenerator\Image;
use StanDaniels\ImageGenerator\Shape\Shape;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpKernel\KernelInterface;

#[AutoconfigureTag(name: 'custom.generator')]

class ProductGenerator implements GeneratorInterface
{
    private LoremIpsum $loremIpsum;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private CategoryRepository $categoryRepository,
        private Kernel $kernel
    ) {
        $this->loremIpsum = new LoremIpsum();
    }

    public function generate(bool $flush = true)
    {
        $product = new Product();
        $product->setTitle($this->randomWords(rand(4, 7)));
        $product->setDescription($this->randomParagraphs(rand(1, 4)));
        $product->setImage($this->randomImage());
        $product->setPrice((float)(rand(100, 4200)) / 100);
        $product->setCategory($this->randomCategory());

        $this->entityManager->persist($product);

        if ($flush) {
            $this->flush();
        }
    }

    public function flush()
    {
        $this->entityManager->flush();
    }

    private function randomWords(int $words = 1): string
    {
        return $this->loremIpsum->words($words);
    }

    private function randomParagraphs(int $paragraphs = 1): string
    {
        $text = $this->loremIpsum->paragraphs($paragraphs);
        if ($paragraphs > 1) {
            $text = nl2br($text);
        }

        return $text;
    }

    private function randomImage(): string
    {
        $transparency = random_int(10, 100) / 100;
        $canvas = Canvas::create(400, 400, 2)
            ->background(Color::random($transparency));

        for ($i = random_int(100, 150); $i > 0; $i--) {
            $transparency = random_int(60, 80) / 100;
            Shape::random($canvas, Color::random($transparency))->draw();
        }

        $imageFolder = $this->kernel->getProjectDir().'/public/images/';
        @mkdir($imageFolder);

        $image = Image::create($canvas);

        $newImageName = $imageFolder.'/'.$image->getFilename().'.png';
        rename($image->getPath().'/'.$image->getFilename(), $newImageName);

        return basename($newImageName);
    }

    private function randomCategory(): Category
    {
        static $categories = null;
        if (is_null($categories)) {
            $categories = $this->categoryRepository->findAll();
        }

        return $categories[array_rand($categories)];
    }
}