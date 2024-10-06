<?php

use App\Models\UserAccess;
use App\Models\Kelas;
use App\Models\Teacher;

function getMenu($roleId){
    $module = UserAccess::join('m_modules', 'm_modules.id', '=', 'm_user_accesses.module_id')
                ->select('m_modules.module as nama_module', 'm_modules.icon', 'm_modules.id as module_id')
                ->where('m_user_accesses.role_id', $roleId)
                ->where('m_user_accesses.module_function_id', '=', '-')
                ->get();
    return $module;
}

function getSubMenu($moduleId, $roleId){
    $moduleFunction = UserAccess::join('m_module_functions as mf', 'mf.id', '=', 'm_user_accesses.module_function_id')
                ->select('mf.nama_menu', 'mf.routes', 'mf.module_id')
                ->where('m_user_accesses.role_id', $roleId)
                ->where('m_user_accesses.module_id', $moduleId)
                ->where('mf.is_parent', '=', 1)
                ->get();

    return $moduleFunction;
}

function getModuleAccess($function_id){
    $role_id = Auth()->user()->role_id;

    $userAccess = UserAccess::where('role_id', $role_id)
                    ->where('module_function_id', $function_id)
                    ->first();

    if($userAccess){
        return TRUE;
    }else{
        return FALSE;
    }
}
