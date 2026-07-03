<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function __construct(protected ImageUploadService $imageService)
    {
    }

    public function index(): View
    {
        $team = TeamMember::orderBy('sort_order')->get();

        return view('admin.team', compact('team'));
    }

    protected function rules(): array
    {
        return [
            'member_name' => 'required|string|max:255',
            'member_role' => 'required|string|max:255',
            'member_bio' => 'nullable|string',
            'member_social' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $data = [
            'name' => $validated['member_name'],
            'role' => $validated['member_role'],
            'bio' => $validated['member_bio'] ?? null,
            'social_url' => $validated['member_social'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->imageService->uploadToWebp($request->file('avatar'), 'team');
        }

        TeamMember::create($data);

        return redirect('/admin/team')->with('success', 'Team member added.');
    }

    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $data = [
            'name' => $validated['member_name'],
            'role' => $validated['member_role'],
            'bio' => $validated['member_bio'] ?? null,
            'social_url' => $validated['member_social'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->imageService->uploadToWebp($request->file('avatar'), 'team');
        }

        $team->update($data);

        return redirect('/admin/team')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $team): RedirectResponse
    {
        $team->delete();

        return redirect('/admin/team')->with('success', 'Team member removed.');
    }
}
