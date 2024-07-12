<?php

use App\Models\Comment;
use App\Models\Permission;
use App\Models\RolePermission;

function apiReqponse($data = '', $success = false, $message = "", $status = 201)
{
    $response['success'] = $success;
    $response['status'] = $status;
    $response['message'] = $message;
    $response['data'] = $data;
    return response()->json($response, $response['status']);
}

function menu($role_id, $baseUrl)
{
    $perIds = RolePermission::where('role_id', $role_id)->pluck('permission_id')->toArray();
    $permissions = Permission::orderBy('id', 'asc')->whereNull('parent_id');
    if ($role_id != 1) {
        $permissions = $permissions->with(['permissions' => function ($query) use ($perIds) {
            $query->whereIn('id', $perIds);
        }])->whereIn('id', $perIds);
    } else {
        $permissions->with('permissions');
    }
    $permissions = $permissions->get();

    $userPermission = [];
    foreach ($permissions as $key => $per) {
        $data["key"] = $per->key;
        $data["path"] = $per->path;
        $data["title"] = $per->title;
        $data["icon"] = $per->icon;
        $data["breadcrumb"] = $per->breadcrumb == 1 ? true : false;
        $data1 = [];
        foreach ($per->permissions ?? [] as $key1 => $subPer) {
            $data2["key"] = $subPer->key;
            $data2["path"] = $subPer->path;
            $data2["title"] = $subPer->title;
            $data2["icon"] = $subPer->icon;
            $data2["breadcrumb"] = $subPer->breadcrumb == 1 ? true : false;
            $data2["submenu"] = [];
            $data1[] = $data2;
        }
        $data["submenu"] = $data1;
        $userPermission[] = $data;
    }

    return $userPermission;
}

function getRolePermissions($role_id)
{
    $perIds = RolePermission::where('role_id', $role_id)->pluck('permission_id')->toArray();
    $permissions = Permission::orderBy('id', 'asc');
    if ($role_id != 1) {
        $permissions = $permissions->whereIn('id', $perIds);
    }
    return $permissions->get(['id', 'title']);
}

function send_notification($data)
{
    $comment = new Comment();
    $comment->user_id = $data['user_id'];
    $comment->type = $data['type'];
    $comment->type_id = $data['type_id'];
    $comment->message = $data['message'];
    $comment->data = json_encode($data);
    $comment->save();
    return "success";
}
