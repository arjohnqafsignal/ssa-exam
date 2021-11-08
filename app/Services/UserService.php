<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    /**
     * The model instance.
     *
     * @var App\User
     */
    protected $model;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Constructor to bind model to a repository.
     *
     * @param \App\User                $model
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(User $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * Define the validation rules for the model.
     *
     * @param  int $id
     * @return array
     */
    public function rules($user = null)
    {
        return [
            'prefixname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user],
            'password' => (!$user) ? ['required', 'string', 'min:8', 'confirmed'] : ['nullable', 'string', 'min:8', 'confirmed'],
            'photo' => ['mimes:png,jpg,jpeg', 'max:2048']
        ];
    }

    /**
     * Retrieve all resources and paginate.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list()
    {
        // Code goes brrrr.
        return $this->model->paginate(5);
    }

    /**
     * Create model resource.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $attributes)
    {
        // Code goes brrrr.
        return $this->model->create($attributes);
    }

    /**
     * Retrieve model resource details.
     * Abort to 404 if not found.
     *
     * @param  integer $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id):? Model
    {
        // Code goes brrrr.
        $record = $this->model->findOrFail($id);
        return $record;
    }

    /**
     * Update model resource.
     *
     * @param  integer $id
     * @param  array   $attributes
     * @return boolean
     */
    public function update(int $id, array $attributes): bool
    {
        // Code goes brrrr.
        return $this->model->find($id)->update($attributes);

    }

    /**
     * Soft delete model resource.
     *
     * @param  integer|array $id
     * @return void
     */
    public function destroy($id)
    {
        // Code goes brrrr.

        return $this->model->findOrFail($id)->delete();
    }

    /**
     * Include only soft deleted records in the results.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function listTrashed()
    {
        // Code goes brrrr.
        return $this->model->onlyTrashed()->paginate(5);
    }

    /**
     * Restore model resource.
     *
     * @param  integer|array $id
     * @return void
     */
    public function restore($id)
    {
        return $this->model->onlyTrashed()->findOrFail($id)->restore();
        // Code goes brrrr.
    }

    /**
     * Permanently delete model resource.
     *
     * @param  integer|array $id
     * @return void
     */
    public function delete($id)
    {
        // Code goes brrrr.
        $record = $this->model->withTrashed()->findOrFail($id);
        return $record->forceDelete();
    }

    /**
     * Generate random hash key.
     *
     * @param  string $key
     * @return string
     */
    public function hash(string $key): string
    {
        // Code goes brrrr.
        return Hash::make($key);
    }

    /**
     * Upload the given file.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    public function upload(UploadedFile $file)
    {
        // Code goes brrrr.
        $fileName = time().'_'. $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        return $filePath;
    }

    public function saveUserDetails($user)
    {
        $details = [
            [
                'key' => 'Full name',
                'value' => $user->fullname,
                'type' => 'bio',
                'user_id' => $user->id
            ],
            [
                'key' => 'Middle Initial',
                'value' => $user->middleinitial,
                'type' => 'bio',
                'user_id' => $user->id
            ],
            [
                'key' => 'Avatar',
                'value' => $user->avatar,
                'type' => 'bio',
                'user_id' => $user->id
            ],
            [
                'key' => 'Gender',
                'value' => ($user->prefixname == 'Mr') ? 'Male' : 'Female',
                'type' => 'bio',
                'user_id' => $user->id
            ]
        ];

        return $this->model->saveDetails($details);

    }
}
