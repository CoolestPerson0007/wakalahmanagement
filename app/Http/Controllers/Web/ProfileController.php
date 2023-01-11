<?php

namespace App\Http\Controllers\Web;

use App\Events\User\ChangedAvatar;
use App\Events\User\UpdatedProfileDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileDetailsRequest;
use App\Http\Requests\User\UpdateProfileLoginDetailsRequest;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Session\SessionRepository;
use App\Repositories\User\UserRepository;
use App\Services\Upload\UserAvatarManager;
use App\Support\Enum\UserStatus;
use App\User;
use Auth;
use Illuminate\Http\Request;

/**
 * Class ProfileController
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * @var User
     */
    protected $theUser;

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * UsersController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware('auth');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);

        $this->users = $users;

        $this->middleware(function ($request, $next) {
            $this->theUser = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display user's profile page.
     *
     * @param RoleRepository $rolesRepo
     * @param CountryRepository $countryRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(RoleRepository $rolesRepo, CountryRepository $countryRepository)
    {
        $user = $this->theUser;
        $edit = true;
        $roles = $rolesRepo->lists();
        $countries = [0 => 'Select a Country'] + $countryRepository->lists()->toArray();
        $socialLogins = $this->users->getUserSocialLogins($this->theUser->id);
        $statuses = UserStatus::lists();

        return view(
            'user/profile',
            compact('user', 'edit', 'roles', 'countries', 'socialLogins', 'statuses')
        );
    }

    /**
     * Update profile details.
     *
     * @param UpdateProfileDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(UpdateProfileDetailsRequest $request)
    {
        $this->users->update($this->theUser->id, $request->except('role_id', 'status'));

        event(new UpdatedProfileDetails);

        return redirect()->back()
            ->withSuccess(trans('app.profile_updated_successfully'));
    }

    /**
     * Upload and update user's avatar.
     *
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateAvatar(Request $request, UserAvatarManager $avatarManager)
    {
        $request->validate(['avatar' => 'image']);

        $name = $avatarManager->uploadAndCropAvatar(
            $this->theUser,
            $request->file('avatar'),
            $request->get('points')
        );

        if ($name) {
            return $this->handleAvatarUpdate($name);
        }

        return redirect()->route('profile')
            ->withErrors(trans('app.avatar_not_changed'));
    }

    /**
     * Update avatar for currently logged in user
     * and fire appropriate event.
     *
     * @param $avatar
     * @return mixed
     */
    private function handleAvatarUpdate($avatar)
    {
        $this->users->update($this->theUser->id, ['avatar' => $avatar]);

        event(new ChangedAvatar);

        return redirect()->route('profile')
            ->withSuccess(trans('app.avatar_changed'));
    }

    /**
     * Update user's avatar from external location/url.
     *
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateAvatarExternal(Request $request, UserAvatarManager $avatarManager)
    {
        $avatarManager->deleteAvatarIfUploaded($this->theUser);

        return $this->handleAvatarUpdate($request->get('url'));
    }

    /**
     * Update user's login details.
     *
     * @param UpdateProfileLoginDetailsRequest $request
     * @return mixed
     */
    public function updateLoginDetails(UpdateProfileLoginDetailsRequest $request)
    {
        $data = $request->except('role', 'status');

        // If password is not provided, then we will
        // just remove it from $data array and do not change it
        if (trim($data['password']) == '') {
            unset($data['password']);

            unset($data['password_confirmation']);
        }

        $this->users->update($this->theUser->id, $data);

        return redirect()->route('profile')
            ->withSuccess(trans('app.login_updated'));
    }

    /**
     * Display user activity log.
     *
     * @param ActivityRepository $activitiesRepo
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activity(ActivityRepository $activitiesRepo, Request $request)
    {
        $user = $this->theUser;

        $activities = $activitiesRepo->paginateActivitiesForUser(
            $user->id,
            $perPage = 20,
            $request->get('search')
        );

        return view('activity.index', compact('activities', 'user'));
    }


    /**
     * Display active sessions for current user.
     *
     * @param SessionRepository $sessionRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sessions(SessionRepository $sessionRepository)
    {
        $profile = true;
        $user = $this->theUser;
        $sessions = $sessionRepository->getUserSessions($user->id);

        return view('user.sessions', compact('sessions', 'user', 'profile'));
    }

    /**
     * Invalidate user's session.
     *
     * @param $session \stdClass Session object.
     * @param SessionRepository $sessionRepository
     * @return mixed
     */
    public function invalidateSession($session, SessionRepository $sessionRepository)
    {
        $sessionRepository->invalidateSession($session->id);

        return redirect()->route('profile.sessions')
            ->withSuccess(trans('app.session_invalidated'));
    }
}
