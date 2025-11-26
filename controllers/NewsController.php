<?php

namespace Controllers;

use Models\NewsModel;

class NewsController extends BaseController
{
    private $newsModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
    }

    /**
     * News listing page
     */
    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = $_GET['search'] ?? null;
        $perPage = ITEMS_PER_PAGE;

        if ($search) {
            $result = $this->newsModel->searchNews($search, $page, $perPage);
        } else {
            $result = $this->newsModel->paginate($page, $perPage, "is_published = 1", [], 'created_at DESC');
        }

        $this->view('client/news/index', [
            'pageTitle' => 'Tin tức',
            'newsList' => $result['data'],
            'pagination' => $result,
            'search' => $search
        ]);
    }

    /**
     * News detail page
     */
    public function detail($slug)
    {
        $news = $this->newsModel->getBySlug($slug);

        if (!$news) {
            $this->redirectWithMessage(BASE_URL . '/news', 'Tin tức không tồn tại', 'error');
            return;
        }

        // Increment views
        $this->newsModel->incrementViews($news['id']);

        // Get related news
        $relatedNews = $this->newsModel->getRelatedNews($news['id'], $news['category_id'], 4);

        $this->view('client/news/detail', [
            'pageTitle' => $news['title'],
            'metaDescription' => strip_tags($news['summary']),
            'news' => $news,
            'relatedNews' => $relatedNews
        ]);
    }
}
