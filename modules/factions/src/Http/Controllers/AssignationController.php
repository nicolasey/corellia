<?php
namespace Modules\Factions\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Factions\Models\Group;
use Modules\Factions\Models\Assignation;

class AssignationController extends Controller
{
    /**
     * Join a group
     *
     * @param Group $group
     * @return mixed
     * @throws \Exception
     */
    public function join(Group $group)
    {
        $data = request()->only(['element_type', 'element_id', 'isMain', 'isLeader', 'nb']);
        $data['element_type'] = config("groups.inFaction.".$data['element_type']);
        $data['group_id'] = $group->id;

        try {
            $assignation = Assignation::create($data);
            return $assignation;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update assignation
     *
     * @param Group $group
     * @throws \Exception
     */
    public function update(Group $group)
    {
        $data = request()->only(['element_type', 'element_id', 'isMain', 'isLeader', 'nb']);

        $assignation = Assignation::where("element_type", request()->input("element_type"))
            ->and("element_id", request()->input("element_id"))
            ->and("group_id", $group->id)
            ->findOrFail();

        try {
            $assignation->update($data);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Leave a group
     *
     * @param Group $group
     * @throws \Exception
     */
    public function leave(Group $group)
    {
        $data = request()->only(['element_type', 'element_id', 'isMain', 'isLeader', 'nb']);
        $data['element_type'] = config("groups.inFaction.".$data['element_type']);
        $data['group_id'] = $group->id;

        try {
            $assignation = Assignation::where($data)->findOrFail();
            $assignation->delete();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Get all assignations of a given element
     *
     * @return mixed
     */
    public function find()
    {
        $data = request()->only(['element_type', 'element_id']);

        return Assignation::where($data)->with("group")->get();
    }
}