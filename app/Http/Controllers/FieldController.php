<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
{
    public function create(Request  $request)
    {
        $types = CustomField::getTypes();
        return view("field.field_create")->with(['types' => $types]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ["required", "string", "max:150", function (string $attribute, mixed $value, Closure $fail) use ($request) {
                if ($request->name != '' && $request->fieldtype != "") {
                    $exist = CustomField::where('name', $value)->where('type', $request->fieldtype)->first();
                    if ($exist) $fail($value . " for " . $request->fieldtype . " already exist.");
                }
            },],
            'fieldtype' => ['required', Rule::in(array_values(CustomField::getTypes()))]
        ], [], [
            'name' => "Name",
            'fieldtype' => "Field Type"
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->toArray(), 422);

        $field = new CustomField;
        $field->name = $request->name;
        $field->type = $request->fieldtype;
        $field->save();

        return response()->json(['status' => 'success']);
    }

    public function edit(Request $request, $id)
    {
        $record = CustomField::find($id);

        if (! $record) {
            abort(404);
        }
        $types = CustomField::getTypes();

        return view("field.field_update")->with(['field' => $record, 'types' => $types]);
    }

    public function update(Request $request, $id)
    {
        $field = CustomField::find($id);

        if (! $field) return response()->json(['status' => 'error', 'message' => 'Field not found'], 404);

        $validator = Validator::make($request->all(), [
            'name' => ["required", "string", "max:150", function (string $attribute, mixed $value, Closure $fail) use ($request, $id) {
                if ($request->name != '' && $request->fieldtype != "") {
                    $exist = CustomField::where('name', $value)->where('type', $request->fieldtype)->where('id', '!=', $id)->first();
                    if ($exist) $fail($value . " for " . $request->fieldtype . " already exist.");
                }
            },],
            'fieldtype' => ['required', Rule::in(array_values(CustomField::getTypes()))]
        ], [], [
            'name' => "Name",
            'fieldtype' => "Field Type"
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->toArray(), 422);

        $field->name = $request->name;
        $field->type = $request->fieldtype;
        $field->save();

        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request, $id)
    {
        $field = CustomField::find($id);
        if (! $field) {
            return response()->json(['status' => 'error', 'message' => 'Field not found'], 404);
        }

        $field->delete();

        return response()->json(['status' => 'success']);
    }

    public function index(Request $request)
    {
        $fields = CustomField::paginate(10);
        return ($request->ajax()) ? view('field.field_partial')->with(['resources' => $fields]) : view("field.field_list")->with(['resources' => $fields]);
    }

    public function show(Request $request, $id)
    {
        $field = CustomField::find($id);
        if (! $field) {
            abort(404);
        }

        return view("field.field_show")->with(['field' => $field]);
    }
}
