<?php

use App\Models\UserAccess;

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