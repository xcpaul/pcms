<?php

namespace Fully\Composers;

use Menu;
use Fully\Repositories\Page\PageInterface;

/**
 * Class MenuComposer.
 *
 * @author Sefa Karagöz <karagozsefa@gmail.com>
 */
class FooterComposer
{
    /**
     * @var \Fully\Repositories\Menu\MenuInterface
     */
    protected $page;

    /**
     * @param MenuInterface $menu
     */
    public function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {
        $footer_about_us = $this->page->pairing_page(1);
        $footer_address = $this->page->pairing_page(2);
        $view->with(compact('footer_about_us','footer_address'));
    }
}
