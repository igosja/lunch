<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Meal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\StrictException;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the menu';

    /**
     * @var Dom $dom
     */
    private $dom;

    /**
     * @var array $categories
     */
    private array $categories;

    /**
     * Execute the console command.
     *
     * @return int
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws NotLoadedException
     * @throws StrictException
     */
    public function handle(): int
    {
        $this->info('Start command');

        $this->loadFile();
        $this->processCategories();
        $this->processMeals();

        $this->info('All done');

        return CommandAlias::SUCCESS;
    }

    /**
     * @return void
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws StrictException
     */
    private function loadFile(): void
    {
        $this->info('Start file loading');

        $this->dom = new Dom;
        $this->dom->loadFromFile(storage_path('1.html'));

        $this->info('File loading done');
    }

    /**
     * @return void
     * @throws ChildNotFoundException
     * @throws NotLoadedException
     */
    private function processCategories(): void
    {
        $this->info('Start categories');

        $navTabs = $this->dom->find('.nav-tabs')[0];
        $aList = $navTabs->find('a');
        foreach ($aList as $a) {
            $text = $a->text;

            $category = Category::query()
                ->where('name', $text)
                ->first();
            if (!$category) {
                $category = new Category();
                $category->name = $text;
                $category->is_active = true;
                $category->save();
            }

            $this->categories[$a->href] = $category->id;
        }

        $this->info('Categories done');
    }

    /**
     * @return void
     * @throws ChildNotFoundException
     * @throws NotLoadedException
     */
    private function processMeals(): void
    {
        $this->info('Start meals');

        Meal::query()->update(['is_active' => false]);

        $tabList = $this->dom->find('.tab-pane');
        foreach ($tabList as $tab) {
            $categoryId = '#' . $tab->id;

            $headingList = $tab->find('.media-heading');
            foreach ($headingList as $heading) {
                $text = $heading->text;

                $meal = Meal::query()
                    ->where('name', $text)
                    ->first();
                if (!$meal) {
                    $meal = new Meal();
                    $meal->name = $text;
                    $meal->category_id = $this->categories[$categoryId];
                    $meal->is_ordered = false;
                    $meal->is_favorite = false;
                    $meal->is_unsuitable = false;
                }

                $meal->is_active = true;
                $meal->save();
            }
        }

        $this->info('Meals done');
    }
}
