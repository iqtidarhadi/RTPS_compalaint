<?php


use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

if (!function_exists('getPrefixRoute')) {
    function getPrefixRoute($prefix)
    {
        $routes = [
            'app' => 'app.home',
            'setting' => 'setting.dashboard',
            'assets' => 'assets.dashboard',
            'hr' => 'hr.dashboard',
        ];

        return $routes[$prefix] ?? 'module.home';
    }
}

if (!function_exists('sendResponse')) {
    function sendResponse($result, $message = null)
    {
        $response = [
            'success' => true,
            'data' => $result,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, 200);
    }
}


if (!function_exists('sendError')) {
    function sendError($message, $errors = [], $code = 401)
    {
        $response = ['response' => false, 'message' => $message, 'code' => $code];
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
        throw new HttpResponseException(response()->json($response, $code));
    }
}

// For add'active' class for activated route nav-item
if (!function_exists('active_class')) {
    function active_class($path, $active = 'active')
    {
        return call_user_func_array('Request::is', (array) $path) ? $active : '';
    }
}

// For checking activated route
if (!function_exists('is_active_route')) {
    function is_active_route($path)
    {
        return call_user_func_array('Request::is', (array) $path) ? 'true' : 'false';
    }
}



// For add 'show' class for activated route collapse
if (!function_exists('show_class')) {
    function show_class($path)
    {
        return call_user_func_array('Request::is', (array) $path) ? 'show' : '';
    }
}



if (!function_exists('customButton')) {
    function customButton($model, $permission, $route = null, $isShowView = true, $customHtml = null)
    {

        $editPermission = Auth::user()->can($permission . '-edit');
        $showPermission = Auth::user()->can($permission . '-list');
        $deletePermission = Auth::user()->can($permission . '-delete');
        $editorDeletePermission = Auth::user()->canany([$permission . '-edit', $permission . '-delete', $permission . '-list']);

        $showPermissionView = '';

        if ($isShowView) {
            $showPermissionView = $showPermission ? '<a href="' . route($route . '.show', $model->id) . '" class="dropdown-item">Show Details</a>' : '';
        }

        if ($editorDeletePermission) {
            return '<div class="d-flex align-items-center">
            <div class="dropdown">
                <a class="btn dropdown-toggle hide-arrow text-body p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">   

                    ' . $showPermissionView . '
                    ' . ($editPermission ? '<a href="' . route($route . '.edit', $model->id) . '" class="dropdown-item">Edit</a>' : '') . '
                    ' . ($deletePermission ? '<a href="javascript:void(0);" class="dropdown-item delete-record text-danger" onclick="destroy(\'' . route($route . ".destroy", $model->id) . '\')">Delete</a>' : '') . '
                    ' . $customHtml . '
                </div>
            </div>
        </div>';
        }

        return null;
    }
}


if (!function_exists('customButtonCrypt')) {
    function customButtonCrypt($model, $permission, $route = null, $isShowView = true, $customHtml = null)
    {
        $editPermission = Auth::user()->can($permission . '-edit');
        $showPermission = Auth::user()->can($permission . '-list');
        $deletePermission = Auth::user()->can($permission . '-delete');
        $id = Crypt::encrypt($model->id);
    Log::info('ID: ' . $id);
        $editorDeletePermission = Auth::user()->canany([$permission . '-edit', $permission . '-delete', $permission . '-list']);
       
        if ($editorDeletePermission) {
            return '<div class="d-inline-block">
                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end m-0">
                    ' . ($showPermission && $isShowView ? '<li><a href="' . route($route . '.show', $id) . '" class="dropdown-item">Details</a></li>' : '') . '
                    ' . ($editPermission ? '<li><a href="' . route($route . '.edit', $id) . '" class="dropdown-item">Edit</a></li>' : '') . '
                    ' . $customHtml . '
                    ' . ($deletePermission ? '<div class="dropdown-divider"></div>
                    <li><a href="javascript:void(0);" class="dropdown-item text-danger delete-record" onclick="destroy(this, \'' . route($route . '.destroy', $id) . '\')">Delete</a></li>' : '') . '
                </ul>
            </div>' .
                ($editPermission ? ' <a href="' . route($route . '.edit', $id) . '" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>' : '');
        }

        return null;
    }
}



// get specfic user of the branch by role 

if (!function_exists('getSpecificUserbyRole')) {
    function getSpecificUserbyRole($roleName, $mb)
    {
        $users = \App\Models\User::whereHas('roles', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        })->where(function ($query) use ($mb) {
            $query->where(function ($subquery) use ($mb) {
                $subquery->where('sub_division_id', $mb->Boq->sub_division_id)
                    ->where('division_id', $mb->Boq->division_id);
            })->orWhere(function ($subquery) {
                $subquery->whereNull('sub_division_id')
                    ->whereNull('division_id');
            })->orWhere('division_id', $mb->Boq->division_id);
        })->get();

        return $users;
    }
}






if (!function_exists('selectDropDown')) {
    function selectDropDown($object, $selected, $lable = null)
    {
        $selected = $selected ?? '';
        $lable = $lable ?? 'Select';
        $html = '';
        $html .= '<option value="">' . $lable . '</option>';
        foreach ($object as $key => $value) {
            $html .= '<option value="' . $value . '"';
            $html .= $selected == $value ? 'selected' : '';
            $html .= '>' . $value . '</option>';
        }
        $html .= '</select>';

        return $html;
    }
}

if (!function_exists('textAfterHyphen')) {
    function textAfterHyphen($string)
    {
        $parts = explode('-', $string);
        return isset($parts[1]) ? $parts[1] : '';
    }
}


if (!function_exists('getDefaultSector')) {
    function getDefaultSector($sector)
    {
        // Helper function to return the appropriate default sector
        return in_array($sector, ['road', 'bridge']) ? $sector : 'building';
    }
}

if (!function_exists('toRoman')) {
    function toRoman($num)
    {
        $lookup = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];
        $result = '';
        foreach ($lookup as $roman => $value) {
            while ($num >= $value) {
                $result .= $roman;
                $num -= $value;
            }
        }
        return strtolower($result);
    }
}


if (!function_exists('officeType')) {
    function officeType(): array
    {
        return [
            '' => 'Select Type',
            'executive_office_id' => 'Executive Office',
            'division_id' => 'Division',
            'sub_division_id' => 'Sub Division',
        ];
    }
}



if (!function_exists('transferType')) {
    function transferType(): array
    {
        return [
            '' => 'Select Type',
            'ops' => 'OPS',
            'additional_charge' => 'Additional Charge',
            'general' => 'General',
        ];
    }
}


if (!function_exists('employeeType')) {
    function employeeType(): array
    {
        return [
            '' => 'Select Type',
            'on_service' => 'On Service',
            'terminate' => 'Terminate',
            'death' => 'Death',
        ];
    }
}

if (!function_exists('getOfficeName')) {
    function getOfficeName($model, $key = 'to_type', $officeKey = 'to_office', $executiveOffice = 'toExecutiveOffice', $division = 'toDivision', $subDirectorate = 'toSubDirectorate', $otherOffice = 'to_other_office')
    {
        if (!isset($model->$key)) {
            return 'N/A';
        }

        $officeName = !empty($model->$officeKey) ? "{$model->$officeKey} - " : ''; // Only show if not empty

        return $officeName . ($model->$executiveOffice->name ?? $model->$division->name ?? $model->$subDirectorate->name ?? $model->$otherOffice ?? 'N/A');
    }
}

if (!function_exists('encryptId')) {
    function encryptId($id)
    {
        return encrypt($id);
    }
}

if (!function_exists('decryptId')) {
    function decryptId($encryptedId)
    {
        return decrypt($encryptedId);
    }
}
