<?php

namespace App\Http\Controllers;


use App\Shared\Domain\Bus\CommandBus;
use Illuminate\View\View;

final class BlogController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    ) {}

    public function home(): View
    {
        return view('blog.home');
    }
}    