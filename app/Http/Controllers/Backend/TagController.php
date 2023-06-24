<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TagRequest;
use App\Enums\AppEnum;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Tag;

class TagController extends Controller
{
    public function index(): Response
    {
        $items = Tag::isUser()->latest()->paginate(AppEnum::PAGINATION);

        return Inertia::render('Backend/Tag/Index', ['items' => $items]);
    }

    public function create(): Response
    {
        return Inertia::render('Backend/Tag/Create');
    }

    public function store($tenantName, TagRequest $request): RedirectResponse
    {
        try {
            $data = $request->all();
            $data['user_id'] = Auth::id();

            Tag::create($data);

            return redirect()->route('backend.tags.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function edit($tenantName, Tag $tag):Response
    {
        return Inertia::render('Backend/Tag/Edit', ['tag' => $tag]);
    }

    public function update(TagRequest $request, $tenantName, Tag $tag): RedirectResponse
    {
        try {
            $tag->update($request->all());

            return redirect()->route('backend.tags.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }

    public function destroy($tenantName, Tag $tag): RedirectResponse
    {
        try {
            $tag->delete();

            return redirect()->route('backend.tags.index', $tenantName);
        } catch (\Exception $e) {
            Log::error($e);

            return back()->withErrors(AppEnum::ERROR);
        }
    }
}

