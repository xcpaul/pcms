<?php

namespace Fully\Composers;

use Menu;
use Fully\Repositories\Tag\TagInterface;
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
    protected $tag;
    /**
     * @param MenuInterface $menu
     */
    public function __construct(PageInterface $page, TagInterface $tag)
    {
        $this->page = $page;
        $this->tag = $tag;
    }

    /**
     * @param $view
     */
    public function compose($view)
    {
        $footer_about_us = $this->page->pairing_page(1);
        $footer_address = $this->page->pairing_page(2);
        $tags = $this->tag->all();
        $view->with(compact('footer_about_us','footer_address','tags'));
    }
}
