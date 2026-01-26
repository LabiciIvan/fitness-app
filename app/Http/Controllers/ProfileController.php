<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreProfile;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function create() {
        return view('profile.create');
    }

    public function show(Profile $profile) {

        return view('profile.show', [
            'user' => $this->user,
            'profile' => $profile
        ]);
    }

    public function storeOrUpdate(RequestStoreProfile $request) {
        $user = Auth::user();

        $logoName = null;

        if (Storage::disk('public')->get($user->profile->logo)) {
            Storage::disk('public')->delete($user->profile->logo);
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            $logoName = uniqid($user->id .  '_') . '_LOCAL_STORAGE.' . $file->extension();

            Storage::disk('public')->putFileAs(
                "logos",
                $file,
                $logoName
            );
        }

        Profile::updateOrCreate(
            [
                'user_id'       => $user->id,
            ],
            array_merge(
                $request->onlyData(['sex', 'description', 'country', 'city']),
                ['logo' => "logos/" . $logoName, 'complete' => true]
            )
        );

        return redirect()->route('dashboard.index');
    }
}
