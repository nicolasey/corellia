<?php
namespace Modules\Factions\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Factions\Models\Group;

class GroupsController extends Controller
{
    /**
     * Get all groups
     *
     * @return \Illuminate\Database\Eloquent\Collection|Group[]
     * @throws \Exception
     */
    public function index()
    {
        $filters = ['isSecret', 'isPrivate', 'isFaction', 'active'];

        $groups = Group::all();

        foreach ($filters as $filter) {
            $groups = (request()->input($filter)) ? $groups->where($filter, request()->input($filter)) : $groups;
        }

        return $groups;
    }

    /**
     * Show a group
     *
     * @param Group $group
     * @return Group
     */
    public function show(Group $group)
    {
        return $group;
    }

    /**
     * Store new group
     *
     * @return mixed
     * @throws \Exception
     */
    public function store()
    {
        $data = request()->only(['name', 'isPrivate', 'isSecret', 'color', 'isFaction']);

        try {
            $group = Group::create($data);
            return $group;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update a group
     *
     * @param Group $group
     * @return Group
     * @throws \Exception
     */
    public function update(Group $group)
    {
        $data = request()->only(['name', 'isPrivate', 'isSecret', 'active', 'color','isFaction']);

        try {
            $group->update($data);
            $group->load(config("groups.loads.update"));
            return $group;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete a faction
     *
     * @param Group $group
     * @throws \Exception
     */
    public function destroy(Group $group)
    {
        try {
            $group->delete();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}