<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BoqMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class DynamicController extends Controller
{

    public function dropDown(Request $request)
    {

   
        $token = Crypt::decrypt($request->token);
        $model = DB::connection($token['connection'] ?? 'mysql')->table($token['model'] ?? '')->select(($token['value'] ?? 'value') . ' as value', ($token['label']  ?? 'label') . ' as label')->orderBy($token['label'] ?? '', 'asc');
        if ($request->has('search')) {
            $search = $request->search;
            $model->where($token['label'] ?? '', 'like', '%' . $search . '%');
        }


        // Magic for concat column 
        if (isset($token['concat_column'])) {
            $concatColumn = $token['concat_column'];
            $model->selectRaw("CONCAT({$token['label']}, 
                CASE WHEN {$concatColumn} IS NOT NULL THEN ' - ' ELSE '' END, 
                COALESCE({$concatColumn}, '')) AS label");

            if ($request->has('search')) {
                $search = $request->search;
                $model->orwhere($concatColumn, 'like', '%' . $search . '%');
            }
        }

        if ($request->filled('where')) {
            $where = $request->where;
            $model->where($where['column'], $where['operator'], $where['value']);
        }

        $perPage = 10;
        $page = $request->input('page') ?: 1;

        $model = $model->paginate($perPage, ['*'], 'page', $page);
        return response()->json($model);
    }


    public function dropDownTypeBase(Request $request)
    {
        $user = auth()->user();
        $token = Crypt::decrypt($request->token);
        $model = DB::connection($token['connection'] ?? 'mysql')->table($token['model'] ?? '')->select(($token['value'] ?? 'value') . ' as value', ($token['label']  ?? 'label') . ' as label')->orderBy($token['label'] ?? '', 'asc');
        if ($request->has('search')) {
            $search = $request->search;
            $model->where($token['label'] ?? '', 'like', '%' . $search . '%');
        }

        if ($request->filled('where')) {
            $where = $request->where;

            if (!empty($where['value'])) {
                $model->where($where['column'], $where['operator'], $where['value']);
            }

            if (isset($where['isFilterByUserPermission']) && !$user->hasRole('Super Admin')) {
                $model->whereIn('id', $user->userPermissions()->where('type', $where['isFilterByUserPermission'])
                    ->pluck('permission_id')
                    ->toArray() ?? []);
            }
        }

        $perPage = 10;
        $page = $request->input('page') ?: 1;

        $model = $model->paginate($perPage, ['*'], 'page', $page);
        return response()->json($model);
    }




    public function get_scheme_by_division_sub_division(Request $request)
    {
        $division_id = $request->input('division_id');
        $sub_division_id = $request->input('sub_division_id');

        // Filter the BoqMaster model based on the provided division_id and sub_division_id
        $boqMasters = BoqMaster::where('division_id', $division_id)
            ->where('sub_division_id', $sub_division_id)
            ->pluck('SchemeName', 'id');

        return response()->json($boqMasters);
    }
}
