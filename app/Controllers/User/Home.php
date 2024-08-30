<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\Admin\WisataModel;
use App\Models\Admin\ArtikelModel;

class Home extends BaseController
{
    public function index()
    {
        $wisataModel = new WisataModel();
        $artikelModel = new ArtikelModel();
        helper('text');

        // Fetch data untuk Pantai Mlarangan Asri and Sawah Surjan
        $pantai = $wisataModel->getWisataByName('Pantai Mlarangan Asri');
        $sawah = $wisataModel->getWisataByName('Sawah Surjan');

        // Fetch articles terbaru
        $articles = $artikelModel->getLatestArticles(3);

        $data = [
            'title' => 'Beranda',
            'activePage' => '/',
            'pantai' => $pantai,
            'sawah' => $sawah,
            'articles' => $articles
        ];
        return view('user/index', $data);
    }
}
