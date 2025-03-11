<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    // Middleware para restringir acesso somente a administradores
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->isAdmin()) {
                abort(403, 'Acesso negado.');
            }
            return $next($request);
        });
    }

    // Painel principal
    public function dashboard()
    {
        $users = User::all();
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('users', 'posts'));
    }

    // Outros métodos para gerenciar usuários e postagens (edição, exclusão, etc) podem ser adicionados aqui.
}